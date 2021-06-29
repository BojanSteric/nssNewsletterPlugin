 jQuery( document ).ready(function(){
        jQuery('.newsletterForm').on('submit', function(event){
            console.log('radim')
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
