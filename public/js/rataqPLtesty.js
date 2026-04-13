var url2 = window.location.href;

url2 = url2.split('konkurs/');

url2 = url2[1];
if (url2 != undefined) {
    $.ajax({

        type: "POST",

        url: "/api/pobierzPytania/" + url2,

        data: {

            'url2': url2

        },

        dataType: "json",

        success: function (data) {

            console.log(data);

            $('#loader').fadeOut(1000, function () {

                $('#trescPytanWlasciwa').fadeIn(1000, function () {

                    klikanie(data);

                });

            })

        },

        error: function (errMsg) {

            console.log(errMsg);

        }

    });
}
function klikanie(data) {

    var pytania = data;

    document.getElementById('rozpocznijTest').addEventListener('click', function () {

        //console.log(document.getElementById('zgodaPolityka').checked);

        if (document.getElementById('zgodaPolityka').checked == true && document.getElementById('email').value != '') {

            var zadane = '';

            for (i = 0; i < data.length; i++) {

                if (zadane == '') {

                    zadane = data[i]['pytanie'];

                } else {

                    zadane += '----------' + data[i]['pytanie'];

                }

            }

            $.ajax({

                type: "POST",

                url: "/api/startPytan",

                // The key needs to match your method's input parameter (case-sensitive).

                data: {

                    'url': zadane,

                    'email': document.getElementById('email').value,

                    'ip': document.getElementById('ip').value,

                    'klucz': 'afsavnvkjg'

                },

                dataType: "json",

                success: function (data) {

                    if (data['status'] == true) {

                        var idTestu = data['idTestu'];

                        var wstawka = '';

                        for (i = 0; i < pytania.length; i++) {

                            var wstawkaTeraz = '<div id="pytanieNr' + i + '" class="pytanieKurs">';

                            wstawkaTeraz += '<h5 id="pytanie' + i + '">' + pytania[i]['pytanie'] + '</h5>';

                            var listaOdpowiedzi = pytania[i]['odpowiedzi'].split('----------');

                            var odpowiedzi = '';

                            for (j = 0; j < listaOdpowiedzi.length; j++) {

                                if (odpowiedzi == '') {

                                    odpowiedzi = '<div id="odpowiedz' + i + '-' + j + '" class="mozliwaOdpowiedz odpowiedz' + i + '" data-odp="' + j + '">' + listaOdpowiedzi[j] + '</div>';

                                } else {

                                    odpowiedzi += '<div id="odpowiedz' + i + '-' + j + '" class="mozliwaOdpowiedz odpowiedz' + i + '" data-odp="' + j + '">' + listaOdpowiedzi[j] + '</div>';

                                }

                            }

                            wstawkaTeraz += odpowiedzi;

                            wstawkaTeraz += '</div>';

                            if (wstawka == '') {

                                wstawka = wstawkaTeraz;

                            } else {

                                wstawka += wstawkaTeraz;

                            }

                        }

                        wstawka += '<div class="col-md-12 text-center" style="padding-top:5%;"><a id="oznaczTestJakoGotowy" class="btn btn-dark text-white">Prześlij odpowiedzi</a></div>';

                        podmianaFormularzaPytan(wstawka, idTestu);

                    }

                },

                error: function (errMsg) {

                    //console.log(errMsg);

                }

            });

        } else {

            if (document.getElementById('email').value == '') {

                document.getElementById('email').style.borderColor = 'red';

                document.getElementById('email').style.background = '#ffd4d4';

            }

            if (document.getElementById('zgodaPolityka').checked != true) {

                document.getElementById('podswietlZgoda').style.backgroundColor = '#ffbebe';

            }

        }

    })

}

function podmianaFormularzaPytan(wstawka, idTestu) {

    $('#trescPytanWlasciwa').fadeOut(1500, function () {

        $('#loader').fadeIn(1500, function () {

            $('#trescPytanWlasciwa').html(wstawka).after(function () {

                $('#loader').fadeOut(1000, function () {

                    $('#trescPytanWlasciwa').fadeIn(1000, function () {

                        sprawdzajGotowoscOdpowiedzi(idTestu);

                    });

                })

            })

        });

    })

}

function sprawdzajGotowoscOdpowiedzi(idTestu) {

    var opcje = document.getElementsByClassName('mozliwaOdpowiedz');

    var listaOpcji = [];

    for (g = 0; g < opcje.length; g++) {

        //console.log(opcje[g]);

        listaOpcji.push(opcje[g].getAttribute('id'));

    }

    console.log(listaOpcji);

    listaOpcji.forEach(function (value, index, array) {

        document.getElementById(value).addEventListener('click', function () {



            var mozliwosciWyboru = '';

            var idWybranego = value;

            var numerPytania = idWybranego.replace('odpowiedz', '').split('-');

            numerPytania = numerPytania[0];

            var pytanie = document.getElementById('pytanieNr' + numerPytania);

            $(pytanie).fadeOut(400, function () {



                var opcjeWyboru = document.getElementsByClassName('odpowiedz' + numerPytania);

                var listaWstepna = '';

                for (g = 0; g < opcjeWyboru.length; g++) {

                    if (listaWstepna == '') {

                        listaWstepna = opcjeWyboru[g].innerHTML;

                    } else {

                        listaWstepna += ',,,,,' + opcjeWyboru[g].innerHTML;

                    }

                }

                mozliwosciWyboru = listaWstepna;

                $.ajax({

                    type: "POST",

                    url: "/api/aktualizujOdpowiedzi",

                    // The key needs to match your method's input parameter (case-sensitive).

                    data: {

                        'idTestu': idTestu,

                        'mozliwosciWyboru': mozliwosciWyboru,

                        'numerPytania': numerPytania,

                        'idWybranego': idWybranego,

                        'klucz': '1fawtteaf'

                    },

                    dataType: "json",

                    success: function (data) {

                        var pytanie = document.getElementById('pytanie' + numerPytania);

                        $(pytanie).remove();

                        oznaczGotowy(idTestu);

                    },

                    error: function (errMsg) {

                        console.log(errMsg);

                    }

                });

            });



        })

    });

}

function oznaczGotowy(idTestu) {

    document.getElementById('oznaczTestJakoGotowy').addEventListener('click', function () {

        $.ajax({

            type: "POST",

            url: "/api/oznaczGotowy",

            // The key needs to match your method's input parameter (case-sensitive).

            data: {

                'idTestu': idTestu,

                'klucz': '1fa2wtteaf'

            },

            dataType: "json",

            success: function (data) {

                if (data['punkty'] < 5) {

                    var klasa = 'dark';

                    var tytul = 'Ojj!!! Musisz jeszcze się wiele nauczyć!';

                } else {

                    if (data['punkty'] >= 5 && data['punkty'] < 8) {

                        var klasa = 'danger';

                        var tytul = 'Nie jest źle!!! Może być jednak znacznie lepiej!';



                    } else {

                        if (data['punkty'] == 8 || data['punkty'] == '9') {

                            var klasa = 'warning';

                            var tytul = 'Jej!!! Tak niewiele brakowało!';



                        } else {

                            var klasa = 'success';

                            var tytul = 'Świetnie!!! Myślałeś o tym aby do nas dołączyć?!';

                        }

                    }

                }

                var wstawka = '<div class="col-md-12 alert alert-' + klasa + '">';

                wstawka += '<h3 class="text-center">' + tytul + '</h3>';

                if (data['mail'] != '') {

                    wstawka += '<div class="col-md-12 text-center"><a id="wyslijWynikiEmail" class="btn btn-danger text-white">Chce otrzymać prawidłowe odpowiedzi</a></div>';

                }

                wstawka += '</div>';

                $('#trescPytanWlasciwa').fadeOut(1000, function () {

                    $('#loader').fadeIn(1000, function () {

                        $('#trescPytanWlasciwa').html(wstawka).after(function () {

                            $('#loader').fadeOut(1000, function () {

                                $('#trescPytanWlasciwa').fadeIn(1000, function () {

                                    document.getElementById('wyslijWynikiEmail').addEventListener('click', function () {

                                        $.ajax({

                                            type: "POST",

                                            url: "/api/wyslijWyniki",

                                            // The key needs to match your method's input parameter (case-sensitive).

                                            data: {

                                                'idTestu': idTestu,

                                                'klucz': '1fawtt5eaf'

                                            },

                                            dataType: "json",

                                            success: function (data) {

                                                var wstawka = '<div class="col-md-12 text-center"><h3 class="text-center">Wyniki wysłano na wskazany <br />adres e-mail</h3><p class="text-center">Wraz z wynikami, uzyskasz pełen raport z wykonanego testu w którym zawarte są Twoje odpowiedzi wraz z informacją które były prawidlowe. Zapraszamy ponownie!</p></div>';

                                                $('#trescPytanWlasciwa').fadeOut(600, function () {

                                                    $('#loader').fadeIn(1000, function () {

                                                        $('#trescPytanWlasciwa').html(wstawka).after(function () {

                                                            $('#loader').fadeOut(600, function () {

                                                                $('#tytul1').fadeOut(400);

                                                                $('#podtytul1').fadeOut(400);

                                                                $('#trescPytanWlasciwa').fadeIn(1000);

                                                            })

                                                        })

                                                    })

                                                })

                                            },

                                            error: function (errMsg) {

                                                console.log(errMsg);

                                            }

                                        });

                                    })

                                });



                            })

                        })

                    })

                })

            },

            error: function (errMsg) {

                console.log(errMsg);

            }

        });

    })

}