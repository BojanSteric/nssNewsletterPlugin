
    jQuery( document ).ready(function(){
        jQuery('.newsletterForma').on('submit', function(event){
            var email=jQuery('#newsletter').val();
            jQuery.ajax({
                url: ajaxObject.ajax_url,
                type: 'POST',
                data:{
                    action:'subscribeToNewsletter',
                    email: email
                },
                success: function(result) {
                    alert(result.data.msg);
                },
                error: function(result) {
                    alert(result.data.msg);
                }
            });
            event.preventDefault();
        });
    });
