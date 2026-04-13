var button = document.getElementById('wysylka');
if (button != undefined) {
    button.addEventListener('click', function () {
        if (document.getElementById('zgoda').checked == true) {
            var imie = document.getElementById('imie');
            var email = document.getElementById('email');
            var telefon = document.getElementById('telefon');
            var tresc = document.getElementById('tresc');
            if (imie.value != '' && email.value != '' && telefon.value != '' && tresc.value != '') {
                $('#formularzKonktaktowy').submit();
            } else {
                if (imie.value == '') {
                    imie.style.borderColor = 'red';
                    imie.style.background = '#ff7676';
                    imie.style.color = '#fff';
                }
                if (email.value == '') {
                    email.style.borderColor = 'red';
                    email.style.background = '#ff7676';
                    email.style.color = '#fff';
                }
                if (telefon.value == '') {
                    telefon.style.borderColor = 'red';
                    telefon.style.background = '#ff7676';
                    telefon.style.color = '#fff';
                }
                if (tresc.value == '') {
                    tresc.style.borderColor = 'red';
                    tresc.style.background = '#ff7676';
                    tresc.style.color = '#fff';
                }
            }
        } else {
            document.getElementById('zgodaForm').style.backgroundColor = '#f01313';
            document.getElementById('zgodaForm').style.color = '#fff';
        }
    })
}