
jQuery(document).ready(function($){

    // AJAX url
    var ajax_url = ajaxObject.ajax_url;
    var newsletterPage = ajaxObject.newsletterPage;

    $('#empTable').on('click','.pauseNewsletter',function(){
        var data = {
            'action': 'pauseNewsletter',
            'newsletterId': $(this).data('id')
        };
        $.ajax({
            url: ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            error: function (request, error) {
                alert(" Can't do because: " + error);
            },
            success: function(response){
                alert('Slanje newslettera je sada pokrenuto.');
            }
        });
    });

    $('#empTable').on('click','.sendNewsletter',function(){
        var data = {
            'action': 'sendNewsletter',
            'newsletterId': $(this).data('id')
        };
        $.ajax({
            url: ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            error: function (request, error) {
                alert(" Can't do because: " + error);
            },
            success: function(response){
                alert('Slanje newslettera je sada pokrenuto.');
            }
        });
    });


    $('#empTable').on('click','.updateNewsletter',function(){
        var id = $(this).data('id');
        location.href = newsletterPage + '&action=newsletterForm&newsId='+id;
    });

    //DELETE Newsletter
    $('#empTable').on('click','.deleteNewsletter',function(){
        var id = $(this).data('id');
        // AJAX request
        var data = {
            'action': 'deleteNewsletter',
            'newsletterId': id
        };
        $.ajax({
            url: newsletterPage+'&action=deleteNewsletter',
            type: 'post',
            data: data,
            dataType: 'text',
            error: function (request, error) {
                alert(" Can't do because: " + error);
            },
            success: function(response){
                location.reload();
            }
        });

    });
    let templateSelect = $('#templateName');
    templateSelect.on('change', getTemplate);
    if (templateSelect.val() !== undefined && templateSelect.val() !== '-1'){
        getTemplate();
    }
    function getTemplate() {
        let form = $('#newsletterForm')
        let newsletterId = form.data('newsletterid') ?? null;
        // If an actual template is selected and not the default 'choose a template' option call the ajax
        if ($(templateSelect).val() !== '-1') {
            $.ajax({
                url: ajax_url,
                type: 'post',
                data: {'action': 'getTemplate', 'templatePath': templateSelect.val(),'newsletterId':newsletterId},
                dataType: 'text',
                error: function (request, error) {
                    alert(" Can't do because: " + error);
                },
                success: function (response) {
                    $('#contentWrapper').html($.parseHTML(response))
                }
            });
        } else {
            $('#contentWrapper').html('');
        }
    }
});