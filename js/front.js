
    jQuery( document ).ready(function(){
        console.log(ajaxObject['ajax_url']);
        jQuery('.newsletterForma').on('submit', function(event){
            $.ajax({
                url: ajaxObject['ajax_url'],
                type: 'POST',
                data:{
                    action:'wp_ajax_subscribeToNewsletter',
                    email: jQuery('.newsletterForma input[type=email]').val(),
                },
                success: function(data) {
                    console.log(data);
                },
                error: function() {
                    alert('Dogodila se neočekivana greška')
                },
            
            });
            event.preventDefault();
        });
    });
