/*
if (document.getElementById('pricePreview')){
    var productPrice = document.getElementById('pricePreview').getAttribute('data-price')
    document.getElementById('discountPercentage').addEventListener('blur', populateDiscountValue)
    document.getElementById('discountValue').addEventListener('blur', changeDiscountPercentage)
}

function changeDiscountPercentage() {
    let discountValue = document.getElementById('discountValue').value;
    document.getElementById('discountPercentage').value = discountValue / productPrice * 100;
}
function populateDiscountValue() {
    let percentage = document.getElementById('discountPercentage').value;
    let value = document.getElementById('discountValue').value = productPrice / 100 * percentage;
    if (value > productPrice) {
        if (!document.getElementById('priceAlert')) {
            let msg = document.createElement('div')
            msg.innerHTML = '<span id="priceAlert" class="errorMessage">Iznos popusta ne može biti veći od cene proizvoda</span>'
            document.getElementById('discountPercentage').parentElement.appendChild(msg)
            document.getElementById('submit').setAttribute('disabled','disabled')
        }
    }else {
        if (document.getElementById('priceAlert')){
            document.getElementById('priceAlert').remove();
            document.getElementById('submit').removeAttribute('disabled')
        }
    }
}*/
/*
jQuery( document ).ready(function(){
    console.log('ucitali smo se');
    $('.newsletterForma').on('submit', function(){
        $.ajax({
            url: my_ajax_object['ajax_url'],
            type: 'POST',
            data:{
                action:'createSubscriber',
                email: 'asdasdasd',
            },
            success:{
                console.log('email')
            },
            error:{
                console.log('error occured');
            },
            
        });
    });
});
*/

