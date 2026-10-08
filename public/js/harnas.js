// Glosowanie na OSP Swierzawa (osp-harnas.pl): licznik z przyciskiem + modal raz na godzine
(function(){
    var KONIEC = new Date('2026-12-01T00:00:00');
    var LINK = 'https://osp-harnas.pl/';
    var KLUCZ = 'harnasModalPokazany';
    var CO_ILE = 60 * 60 * 1000;

    if(new Date() >= KONIEC) return;

    var ranking = $.getJSON('/ranking-harnas');

    // data z serwera (ISO 8601; starsze wpisy "2026-10-08 09:53" sa w UTC) -> "08.10.2026, 11:53" w czasie polskim
    function formatujDate(data){
        if(!data) return '';
        if(/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(data)) data = data.replace(' ', 'T') + ':00Z';
        var d = new Date(data);
        if(isNaN(d)) return '';
        return d.toLocaleString('pl-PL', {
            timeZone: 'Europe/Warsaw',
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    function wpiszRanking(okno){
        ranking.done(function(d){
            okno.find('.harnas-miejsce').text(d.pozycja);
            okno.find('.harnas-glosy').text(d.glosy);
            var data = formatujDate(d.aktualizacja);
            if(data) okno.find('.harnas-sync').html('Ostatnia synchronizacja: <span>' + data + '</span>');
        });
    }

    // licznik widoczny na kazdej stronie
    var licznik = '<div id="harnasLicznik" class="harnas-licznik">';
    licznik += '<span class="harnas-tag">Harnaś wspiera OSP</span>';
    licznik += '<div class="harnas-licznik-tytul">OSP <span>Świerzawa</span></div>';
    licznik += '<div class="harnas-licznik-dane">';
    licznik += '<div><b class="harnas-miejsce">–</b><small>miejsce</small></div>';
    licznik += '<div><b class="harnas-glosy">–</b><small>głosów</small></div>';
    licznik += '</div>';
    licznik += '<a href="' + LINK + '" target="_blank" rel="noopener" class="harnas-btn">Oddaj głos</a>';
    licznik += '<div class="harnas-licznik-info">1 głos dziennie z 1 adresu e-mail</div>';
    licznik += '<div class="harnas-sync"></div>';
    licznik += '</div>';
    $('body').append(licznik);
    wpiszRanking($('#harnasLicznik'));

    // modal z grafika - raz na godzine
    var ostatnio = 0;
    try{ ostatnio = parseInt(localStorage.getItem(KLUCZ), 10) || 0; }catch(e){}
    if(Date.now() - ostatnio < CO_ILE) return;

    function zamknij(){
        $('#harnasModal').fadeOut(400, function(){ $(this).remove(); });
        $(document).off('keydown.harnas');
    }

    function pokaz(){
        try{ localStorage.setItem(KLUCZ, Date.now()); }catch(e){}

        var html = '<div id="harnasModal" class="harnas-tlo">';
        html += '<div class="harnas-okno" role="dialog" aria-modal="true" aria-label="Zagłosuj na OSP Świerzawa">';
        html += '<a class="harnas-zamknij" aria-label="Zamknij">&times;</a>';
        html += '<a href="' + LINK + '" target="_blank" rel="noopener"><img src="/OSP-Swierzawa-glosowanie-modal.jpg" alt="Zagłosuj na OSP Świerzawa - osp-harnas.pl"></a>';
        html += '<div class="harnas-dol">';
        html += '<div class="harnas-modal-dane">Miejsce w rankingu: <b class="harnas-miejsce">–</b><br>Liczba głosów: <b class="harnas-glosy">–</b><div class="harnas-sync"></div></div>';
        html += '<a href="' + LINK + '" target="_blank" rel="noopener" class="harnas-btn">Oddaj głos</a>';
        html += '</div></div></div>';

        $('body').append(html);
        $('#harnasModal').hide().fadeIn(400);
        wpiszRanking($('#harnasModal'));

        $('#harnasModal .harnas-zamknij').on('click', zamknij);
        $('#harnasModal').on('click', function(e){ if(e.target === this) zamknij(); });
        $(document).on('keydown.harnas', function(e){ if(e.key === 'Escape') zamknij(); });
    }

    $(window).on('load', function(){ setTimeout(pokaz, 1500); });
})();
