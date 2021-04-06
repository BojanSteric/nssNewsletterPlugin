
    jQuery( document ).ready(function(){
        jQuery('.newsletterForma').on('submit', function(event){
            var email=jQuery('#newsletter').val();
            jQuery.ajax({
                url: ajaxObject.ajax_url,
                type: 'POST',
                data:{
                    action:'subscribeToNewsletter',
                    email: email,
                },
                success: function(data) {
                    alert('Uspešno ste se prijavili na newsletter, molimo Vas da potvrdite prijavu klikom na link u emailu koji smo vam poslali.');
                },
                error: function(data) {
                    alert('Dogodila se neočekivana greška ');

                },
            });
            event.preventDefault();
        });
    });
