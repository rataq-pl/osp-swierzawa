<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\HarnasSkrzynki;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PrzekierowaniaCzyscTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_niezalogowany_nie_moze_czyscic_ani_zmieniac_ustawien(): void
    {
        $this->post('/admin/przekierowania/czysc', ['skrzynka' => 0, 'granica' => '2026-11-01T10:00'])->assertRedirect();
        $this->post('/admin/przekierowania/skrzynki', [])->assertRedirect();
        Storage::disk('local')->assertMissing(HarnasSkrzynki::PLIK);
    }

    public function test_czyszczenie_odrzuca_zla_skrzynke_i_date(): void
    {
        $this->actingAs(new User())
            ->postJson('/admin/przekierowania/czysc', ['skrzynka' => 5, 'granica' => 'wczoraj'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['skrzynka', 'granica']);
    }

    public function test_czyszczenie_bez_hasla_zwraca_blad_zamiast_laczyc(): void
    {
        $this->actingAs(new User())
            ->postJson('/admin/przekierowania/czysc', ['skrzynka' => 0, 'granica' => '2026-11-01T10:00', 'sucho' => 1])
            ->assertStatus(500)
            ->assertJsonPath('blad', 'Uzupełnij ustawienia skrzynek (adres i hasło).');
    }

    public function test_zapis_ustawien_szyfruje_haslo_a_puste_haslo_zostawia_stare(): void
    {
        $dane = ['host' => 'imap.example.com', 'port' => 993, 'skrzynki' => ['a@example.com', 'b@example.com'], 'nadawca' => 'nadawca.pl'];

        $this->actingAs(new User())->post('/admin/przekierowania/skrzynki', $dane + ['haslo' => 'Tajne1!'])->assertRedirect('/admin/przekierowania');
        $this->assertStringNotContainsString('Tajne1!', Storage::disk('local')->get(HarnasSkrzynki::PLIK));
        $this->assertSame('Tajne1!', HarnasSkrzynki::wczytaj()['haslo']);

        $this->actingAs(new User())->post('/admin/przekierowania/skrzynki', ['host' => 'imap2.example.com', 'haslo' => ''] + $dane);
        $u = HarnasSkrzynki::wczytaj();
        $this->assertSame('imap2.example.com', $u['host']);
        $this->assertSame('Tajne1!', $u['haslo']);
        $this->assertSame(['a@example.com', 'b@example.com'], $u['skrzynki']);
    }

    public function test_zapis_ustawien_wymaga_dwoch_poprawnych_adresow(): void
    {
        $this->actingAs(new User())
            ->postJson('/admin/przekierowania/skrzynki', ['host' => 'x', 'port' => 993, 'skrzynki' => ['zly-adres'], 'nadawca' => 'n'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['skrzynki']);
    }
}
