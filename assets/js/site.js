
$(document).ready(function () {
    $('form.destroy-form').on('submit', function (submit) {
        console.log('KIRJOITTAA')

        var confirm_message = $(this).attr('data-confirm');

        if (!confirm(confirm_message)) {
            submit.preventDefault();
        }
    });
});

$(document).ready(function () {
// timestampit sekuntteina
    var alkaa = document.getElementById("alkaa").innerHTML;
    var loppuu = document.getElementById("loppuu").innerHTML;  

    // funktio, joka asettaa huolehtii jäljellä olevan ajan näyttämisestä, jos sitä on vielä.
    function count() {
        var nyt = (new Date().getTime()) / 1000;
        
        if (alkaa < nyt && loppuu > nyt) {
            
            var paivat = Math.floor((loppuu - nyt) / (24 * 60 * 60));
            var tunnit = Math.floor((loppuu - nyt - paivat * 24 * 60 * 60) / (60 * 60));
            var minuutit = Math.floor((loppuu - nyt - paivat * 24 * 60 * 60 - tunnit * 60 * 60) / 60);

            document.getElementById("count").innerHTML = "Aikaa jäljellä <br>" + paivat + " päivää " +
                    tunnit + " h " + minuutit + " min";
        }
    }
    
    // asetaan aika sivulle saavuttawssa
    count();
    
    // päivitään jäljellä olevan ajan näyttäminen 5 sekunnin välein
    setInterval(function () {
        count();
    }, 5000);
});
