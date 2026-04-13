window.addEventListener('load', function () {
    var pokazWpisy = document.getElementById('pokazWiecejWpisow');

    if (pokazWpisy != undefined) {
        console.log('dalej');

        pokazWpisy.addEventListener('click', function () {

            wpisyTeraz = document.getElementsByClassName('wpisBlog');

            $.ajax({

                type: "POST",

                url: "/api/pobierzStarsze",

                // The key needs to match your method's input parameter (case-sensitive).

                data: {

                    'url': pokazWpisy.getAttribute('data-src'),

                    'pomin': wpisyTeraz.length,

                    'klucz': 'fsa53rasfa'

                },

                dataType: "json",

                success: function (data) {

                    var wlaczamy = '#pomijamy' + wpisyTeraz.length;

                    var wstawka = '<div id="pomijamy' + wpisyTeraz.length + '" style="display:none;">' + data['wynik'] + '</div>';

                    $('#noweDodaj').append(wstawka).after(function () {

                        $(wlaczamy).fadeIn(1000);

                    })

                },

                error: function (errMsg) {

                    console.log(errMsg);

                }

            });

        })

    }
})