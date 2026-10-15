<?php

namespace App\Console\Commands;

use App\Http\Controllers\Harnas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

// CRON: zapisuje liczbe glosow pierwszych 20 jednostek rankingu osp-harnas.pl (oraz OSP Swierzawa,
// z tabeli harnas_ranking) - z kolejnych dni panel /admin/przekierowania wylicza dzienne przyrosty glosow
class HarnasKonkurencja extends Command
{
    protected $signature = 'harnas:konkurencja';

    protected $description = 'Zapisuje glosy pierwszych 20 jednostek rankingu osp-harnas.pl';

    // osp-harnas.pl zwraca najwyzej 10 pozycji na strone
    const STRON = 2;

    const STREFA = 'Europe/Warsaw';

    public function handle(): int
    {
        $pozycje = [];
        for ($strona = 1; $strona <= self::STRON; $strona++) {
            if ($strona > 1) {
                sleep(1);
            }
            try {
                $dane = Harnas::pobierzStrone($strona);
            } catch (\Throwable $e) {
                $this->error($e->getMessage());

                return self::FAILURE;
            }
            foreach ($dane['data'] ?? [] as $poz) {
                $pozycje[trim($poz['name'])] = ['pozycja' => (int) $poz['position'], 'glosy' => (int) $poz['vote_count']];
            }
        }

        // OSP Swierzawa poza pierwsza 20 - bierzemy ostatni odczyt strony glownej, o ile jest swiezy
        $my = DB::table('harnas_ranking')->where('id', 1)->first();
        if ($my && $my->pozycja && !isset($pozycje[Harnas::NAZWA]) && $my->aktualizacja >= now()->subHours(2)) {
            $pozycje[Harnas::NAZWA] = ['pozycja' => (int) $my->pozycja, 'glosy' => (int) $my->glosy];
        }

        $dzien = now(self::STREFA)->toDateString();
        foreach ($pozycje as $nazwa => $p) {
            $istniejacy = DB::table('harnas_konkurencja')->where('data', $dzien)->where('nazwa', $nazwa)->exists();
            if ($istniejacy) {
                DB::table('harnas_konkurencja')->where('data', $dzien)->where('nazwa', $nazwa)
                    ->update($p + ['updated_at' => now()]);
            } else {
                DB::table('harnas_konkurencja')->insert($p + ['data' => $dzien, 'nazwa' => $nazwa, 'glosy_rano' => $p['glosy'], 'updated_at' => now()]);
            }
            $this->line($p['pozycja'].'. '.$nazwa.' - '.$p['glosy']);
        }

        return self::SUCCESS;
    }
}
