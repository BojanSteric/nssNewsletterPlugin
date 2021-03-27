
    jQuery( document ).ready(function(){
        console.log(ajaxObject['ajax_url']);
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
                    alert(data);
                },
                error: function() {
                    alert('Dogodila se neočekivana greška')
                },
            
            });
            event.preventDefault();
        });
    });
