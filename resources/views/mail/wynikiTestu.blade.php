@php
    $czerwony = '#f01313';
    $ciemny = '#1e1e1e';
    $tekst = '#555555';
    $naglowki = "Montserrat, 'Segoe UI', Arial, sans-serif";
    $tresc = "Nunito, 'Segoe UI', Arial, sans-serif";
    $litery = range('A', 'Z');

    $punkty = $wyniki['punkty'];
    if ($wyniki['procent'] >= 100) {
        $komunikat = 'Świetnie! Myślałeś o tym, aby do nas dołączyć?';
    } elseif ($wyniki['procent'] >= 80) {
        $komunikat = 'Tak niewiele brakowało!';
    } elseif ($wyniki['procent'] >= 50) {
        $komunikat = 'Nie jest źle, ale może być jeszcze lepiej!';
    } else {
        $komunikat = 'Musisz się jeszcze sporo nauczyć – spróbuj ponownie!';
    }

    $czysc = fn ($t) => trim(html_entity_decode(strip_tags((string) $t), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $linkTestu = $test ? $strona.'/konkurs/'.$test->url : $strona.'/konkurs';
@endphp
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Twoje wyniki testu wiedzy – OSP Świerzawa</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Nunito:wght@400;600&display=swap" rel="stylesheet">
</head>
<body style="margin:0; padding:0; background:#f2f2f2; -webkit-text-size-adjust:100%;">
<div style="display:none; max-height:0; overflow:hidden;">Twój wynik: {{ $punkty }}/{{ $wyniki['naIle'] }} ({{ $wyniki['procent'] }}%). Zobacz, które odpowiedzi były prawidłowe.</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f2f2f2;">
    <tr>
        <td align="center" style="padding:30px 12px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 0 30px rgba(0,0,0,.08);">

                {{-- Nagłówek --}}
                <tr>
                    <td style="height:5px; background:{{ $czerwony }}; font-size:0; line-height:0;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" style="padding:30px 30px 10px;">
                        <a href="{{ $strona }}" target="_blank" style="text-decoration:none;">
                            <img src="{{ $strona }}/assets/images/logo.png" width="209" height="90" alt="OSP Świerzawa" style="display:block; border:0; width:209px; max-width:100%; height:auto;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:10px 30px 0; font-family:{{ $tresc }}; font-size:14px; color:{{ $czerwony }}; font-weight:600;">
                        Bogu na chwałę, ludziom na ratunek
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:6px 30px 0; font-family:{{ $naglowki }}; font-size:26px; line-height:1.3; font-weight:700; color:{{ $ciemny }};">
                        Twoje wyniki <span style="color:{{ $czerwony }};">testu wiedzy</span>
                    </td>
                </tr>
                @if ($test)
                <tr>
                    <td align="center" style="padding:6px 30px 0; font-family:{{ $tresc }}; font-size:15px; color:{{ $tekst }};">
                        Moduł: <strong style="color:{{ $ciemny }};">{{ $test->tytul }}</strong>
                    </td>
                </tr>
                @endif

                {{-- Wynik --}}
                <tr>
                    <td align="center" style="padding:25px 30px 5px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="background:{{ $ciemny }}; border-radius:10px;">
                            <tr>
                                <td align="center" style="padding:22px 40px;">
                                    <div style="font-family:{{ $naglowki }}; font-size:44px; line-height:1; font-weight:700; color:#ffffff;">{{ $punkty }}<span style="font-size:22px; color:#bbbbbb;">/{{ $wyniki['naIle'] }}</span></div>
                                    <div style="width:25px; height:3px; background:{{ $czerwony }}; margin:12px auto; font-size:0; line-height:0;">&nbsp;</div>
                                    <div style="font-family:{{ $naglowki }}; font-size:14px; font-weight:600; color:#ffffff;">poprawnych odpowiedzi ({{ $wyniki['procent'] }}%)</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:15px 40px 5px; font-family:{{ $naglowki }}; font-size:17px; font-weight:700; color:{{ $ciemny }};">
                        {{ $komunikat }}
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:5px 40px 20px; font-family:{{ $tresc }}; font-size:15px; line-height:1.6; color:{{ $tekst }};">
                        Dziękujemy za sprawdzenie swojej wiedzy! Poniżej znajdziesz wszystkie pytania z testu, Twoje odpowiedzi oraz odpowiedzi prawidłowe. Zapamiętaj je – w kolejnym podejściu pójdzie Ci jeszcze lepiej.
                    </td>
                </tr>

                {{-- Pytania --}}
                @foreach ($wyniki['lista'] as $nr => $p)
                <tr>
                    <td style="padding:0 30px 16px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e7e7e7; border-left:4px solid {{ $p['dobrze'] ? '#2e9e44' : $czerwony }}; border-radius:6px;">
                            <tr>
                                <td style="padding:16px 18px 6px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td valign="top" style="font-family:{{ $naglowki }}; font-size:12px; font-weight:700; color:#999999; text-transform:uppercase; letter-spacing:.5px;">Pytanie {{ $nr + 1 }}</td>
                                            <td valign="top" align="right" style="font-family:{{ $naglowki }}; font-size:12px; font-weight:700; color:{{ $p['dobrze'] ? '#2e9e44' : $czerwony }};">{{ $p['dobrze'] ? '✔ Dobrze' : '✘ Źle' }}</td>
                                        </tr>
                                    </table>
                                    <div style="padding-top:6px; font-family:{{ $naglowki }}; font-size:15px; line-height:1.45; font-weight:600; color:{{ $ciemny }};">{{ $p['pytanie'] }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:6px 18px 14px;">
                                    @foreach ($p['odpowiedzi'] as $j => $odp)
                                        @php
                                            $prawidlowa = $j === $p['prawidlowa'];
                                            $twoja = $j === $p['udzielona'];
                                            if ($prawidlowa) { $tlo = '#eaf7ed'; $ramka = '#2e9e44'; $kolor = '#1f6e2f'; }
                                            elseif ($twoja) { $tlo = '#fdecec'; $ramka = $czerwony; $kolor = '#a80d0d'; }
                                            else { $tlo = '#f7f7f7'; $ramka = '#f7f7f7'; $kolor = $tekst; }
                                        @endphp
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:6px;">
                                            <tr>
                                                <td style="padding:9px 12px; background:{{ $tlo }}; border:1px solid {{ $ramka }}; border-radius:5px; font-family:{{ $tresc }}; font-size:14px; line-height:1.4; color:{{ $kolor }};">
                                                    {{ $czysc($odp) }}
                                                    @if ($prawidlowa && $twoja)
                                                        <span style="white-space:nowrap; font-weight:700;">&nbsp;– Twoja odpowiedź, prawidłowa</span>
                                                    @elseif ($prawidlowa)
                                                        <span style="white-space:nowrap; font-weight:700;">&nbsp;– prawidłowa</span>
                                                    @elseif ($twoja)
                                                        <span style="white-space:nowrap; font-weight:700;">&nbsp;– Twoja odpowiedź</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                    @if (empty($p['odpowiedzi']))
                                        <div style="font-family:{{ $tresc }}; font-size:14px; color:#999999;">Brak odpowiedzi na to pytanie.</div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endforeach

                {{-- Przyciski --}}
                <tr>
                    <td align="center" style="padding:14px 30px 35px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="border-radius:5px; background:{{ $czerwony }};">
                                    <a href="{{ $linkTestu }}" target="_blank" style="display:inline-block; padding:13px 28px; font-family:{{ $naglowki }}; font-size:14px; font-weight:700; color:#ffffff; text-decoration:none; text-transform:uppercase;">Spróbuj ponownie</a>
                                </td>
                                <td style="width:12px;">&nbsp;</td>
                                <td style="border-radius:5px; background:{{ $ciemny }};">
                                    <a href="{{ $strona }}/konkurs" target="_blank" style="display:inline-block; padding:13px 28px; font-family:{{ $naglowki }}; font-size:14px; font-weight:700; color:#ffffff; text-decoration:none; text-transform:uppercase;">Inne moduły</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Stopka --}}
                <tr>
                    <td align="center" style="background:{{ $ciemny }}; padding:30px 30px 10px;">
                        <a href="{{ $strona }}" target="_blank" style="text-decoration:none;">
                            <img src="{{ $strona }}/assets/images/logo.png" width="140" height="60" alt="OSP Świerzawa" style="display:block; border:0; width:140px; height:auto; background:#ffffff; border-radius:8px; padding:8px 12px;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background:{{ $ciemny }}; padding:10px 30px 4px; font-family:{{ $tresc }}; font-size:14px; line-height:1.6; color:#bbbbbb;">
                        Ochotnicza Straż Pożarna w Świerzawie
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background:{{ $ciemny }}; padding:0 30px 20px; font-family:{{ $tresc }}; font-size:14px;">
                        <a href="{{ $strona }}" target="_blank" style="color:#ffffff; text-decoration:none; font-weight:600;">osp-swierzawa.pl</a>
                        <span style="color:#666666;">&nbsp;|&nbsp;</span>
                        <a href="{{ $strona }}/kontakt" target="_blank" style="color:#ffffff; text-decoration:none; font-weight:600;">Kontakt</a>
                        <span style="color:#666666;">&nbsp;|&nbsp;</span>
                        <a href="{{ $strona }}/dzialania-ratownicze" target="_blank" style="color:#ffffff; text-decoration:none; font-weight:600;">Działania</a>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background:#151515; padding:14px 30px; font-family:{{ $tresc }}; font-size:12px; line-height:1.5; color:#888888;">
                        Wiadomość wysłana, ponieważ poprosiłeś/aś o przesłanie wyników testu na ten adres.<br>
                        Projekt: <a href="https://rataq.pl" target="_blank" style="color:{{ $czerwony }}; text-decoration:none;">RATAQ.PL</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
