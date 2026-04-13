if(document.getElementById('buttonNaviWspieraj') != undefined){
    var button2 = document.getElementById('buttonNaviWspieraj')
    setInterval(function(){
        if(button2.style.background == 'blue'){
            button2.style.background = ''
        }else{
            button2.style.background = 'blue'
        }
    }, 300)
}
if(document.getElementById('buttonNaviWspieraj2') != undefined){
    var button2 = document.getElementById('buttonNaviWspieraj2')
    setInterval(function(){
        if(button2.style.background == 'blue'){
            button2.style.background = ''
        }else{
            button2.style.background = 'blue'
        }
    }, 300)
}
if(document.getElementById('wsparcieOSP') != undefined){
    var button = document.getElementById('wsparcieOSP')
    button.addEventListener('click', function(){
        var tlo = '<div id="tloModal" style="z-index:9999; width: 100%; height: 100%; position: fixed; top: 0; left: 0; background: rgba(0, 0, 0, 0.6);"></div>';
        var oknoModal = '<div id="oknoModal" style="overflow-y: scroll; width: 60%; height:70%; position: fixed; z-index: 99999; left: 20%; top:15%; background: #fff; padding: 5%;">';
        oknoModal += '<h3 class="title text-center">Aby nas <span class="theme-clr">wesprzeć</span></h3>'
        oknoModal += '<div class="text-center">'
        oknoModal += '<a id="zamknijOkno">X</a>'
        oknoModal += '<p>Możesz dokonać przelewu:</p>'
        oknoModal += '<p>Powiatowy Bank Spółdzielczy w Złotoryi (o. Świerzawa)</p>'
        oknoModal += '<p data-q="04865810190000011420000010" id="numerKontaPobierz">04 8658 1019 0000 0114 2000 0010</p>'
        oknoModal += '<a id="kopiujNumer" onclick="kopiujNumerKonta()" class="btn btn-dark text-white theme-clr">Kopiuj nr konta</a>'
        oknoModal += '<p id="skopiowano" class="theme-clr" style="display:none;">Numer konta skopiowany</p>'
        oknoModal += '</div>'
        oknoModal += '</div>';
        $('body').append(tlo)
        $('body').append(oknoModal)

        $('#zamknijOkno').on('click', function(){
            $('#oknoModal').fadeOut(1000, function(){
                $('#tloModal').fadeOut(1000, function(){
                    $('#tloModal').remove()
                    $('#oknoModal').remove()
                })
            })
        })
        $('#tloModal').on('click', function(){
            $('#oknoModal').fadeOut(1000, function(){
                $('#tloModal').fadeOut(1000, function(){
                    $('#tloModal').remove()
                    $('#oknoModal').remove()
                })
            })
        })
    })
}
function kopiujNumerKonta(){
    /* Get the text field */
  var copyText = document.getElementById("numerKontaPobierz");

   /* Copy the text inside the text field */
   copyText = copyText.getAttribute('data-q')
  navigator.clipboard.writeText(copyText);
    $('#skopiowano').fadeIn(1000, function(){
        setTimeout(function(){
            $('#skopiowano').fadeOut(2000)
        }, 3000)
    })
  /* Alert the copied text */

}
