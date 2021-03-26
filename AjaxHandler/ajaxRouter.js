$( document ).ready(function(){
    
});


function deleteSubscriber(){
    jQuery.ajax({
        url: '<?=admin_url('admin-ajax.php')?>',
        type: 'POST',
        data: {
            action: 'deleteSubscriber',
        },
        success: function(data) {

        },
        error: function() {
            alert('Dogodila se neočekivana greška')
        },
});

}
