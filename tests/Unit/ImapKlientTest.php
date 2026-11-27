<?php

namespace Tests\Unit;

use App\Services\ImapKlient;
use PHPUnit\Framework\TestCase;

class ImapKlientTest extends TestCase
{
    public function test_zbior_laczy_kolejne_uidy_w_zakresy(): void
    {
        $this->assertSame('1:3,7,9:10', ImapKlient::zbior([10, 1, 3, 2, 7, 9, 2]));
        $this->assertSame('5', ImapKlient::zbior([5]));
        $this->assertSame('', ImapKlient::zbior([]));
    }

    public function test_parsuj_date_odczytuje_uid_i_internaldate(): void
    {
        [$uid, $data] = ImapKlient::parsujDate('* 5 FETCH (UID 12 INTERNALDATE "27-Nov-2026 09:22:16 +0100")');
        $this->assertSame(12, $uid);
        $this->assertSame('2026-11-27 08:22:16', $data->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i:s'));

        // odwrotna kolejnosc pol i dzien jednocyfrowy
        [$uid] = ImapKlient::parsujDate('* 1 FETCH (INTERNALDATE " 3-Nov-2026 23:59:59 +0000" UID 99)');
        $this->assertSame(99, $uid);

        $this->assertNull(ImapKlient::parsujDate('* 5 EXISTS'));
    }
}
