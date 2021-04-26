
jQuery(document).ready(function($){

    // AJAX url
    var ajax_url = ajaxObject.ajax_url;

    // Fetch All records (AJAX request without parameter)
    all_record();
    function all_record(){
        var data = {
            'action': 'allNewsletter',
        };

        $.ajax({
            url: ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response){
                // Add new rows to table
                createTableRows(response);
            }
        });
    };

    // Search record
    $('#search').keyup(function(){
        var searchText = $(this).val();

        // Fetch filtered records (AJAX request with parameter)
        var data = {
            'action': 'searchNewsletter',
            'searchText': searchText
        };

        $.ajax({
            url: ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response){
                // Add new rows to table
                createTableRows(response);
            },
            error: function() {
                alert('Dogodila se neočekivana greška');
            },
        });
    });



    // Add table rows by reading response object
    function createTableRows(response){

        $('#empTable tbody').empty();
        var len = response.length;
        var sno = 0;

        for(var i=0; i<len; i++){
            let aStat="";
            let bStat="";
            let cStat="";
            let dStat="";
            var newsId = response[i].newsId;
            let newsStatus = response[i].newsStatus;
            var title = response[i].title;
            var templateName = response[i].templateName;
            var createdAt = response[i].createdAt;
            var scheduledAt = response[i].scheduledAt;
            switch(newsStatus) {
                case 'active':
                    aStat='selected'
                    break;
                case 'pause':
                    bStat='selected'
                    break;
                case 'pending':
                    cStat='selected'
                    break;
                case 'complete':
                    dStat='selected'
                    break;
                default:
                // code block
            }
            // Add <tr>
            var tr = " <tr class=\"table-row\">";
            tr += "<td class=\"col col-1\">"+ (++sno) +"</td>";
            tr += "<td class=\"col col-3\">" +
                "<select class=\"selectStatusNewsletterList\" id=\"newsSelectStatus"+newsId +"\" >\n" +
                "                        <option value=\"active\" class=\"active\" "+ aStat +">active</option>\n" +
                "                        <option value=\"pause\" class=\"pause\" "+ bStat +">pause</option>\n" +
                "                        <option value=\"pending\" class=\"pending\"  "+ cStat +">pending</option>\n" +
                "                        <option value=\"complete\" class=\"complete\"  "+ dStat +">complete</option>\n" +
                "                    </select></td>";
            tr += "<td class=\"col col-4\">"+ title +"</td>";
            tr += "<td class=\"col col-4\">"+ templateName +"</td>";
            tr += "<td class=\"col col-5\">"+ createdAt +"</td>";
            tr += "<td class=\"col col-6\">"+ scheduledAt +"</td>";

            tr += "<td class=\"col col-7\"><button class='btn btn-sm btn-info updateNewsletter' data-id="+ newsId
                + ">Update</button>-<button class='btn btn-sm btn-danger deleteNewsletter' data-id="+ newsId
                + ">Delete</button>-<button class='btn btn-sm btn-info sendNewsletter' data-id="+ newsId
                + ">Send</button>-<button class='btn btn-sm btn-info pauseNewsletter' data-id="+ newsId
                + ">Pause</button></td>";
            tr += "<tr>";

            $("#empTable tbody").append(tr);
        }
    }


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
        var newsSelectStatus = $('#newsSelectStatus'+id+'').val();
        // AJAX request
        var data = {
            'action': 'updateNewsletter',
            'newsletterId': id,
            'newsSelectStatus':newsSelectStatus
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
                all_record();
            }
        });

    });

    //DELETE Newsletter
    $('#empTable').on('click','.deleteNewsletter',function(){
        var id = $(this).data('id');
        // AJAX request
        var data = {
            'action': 'deleteNewsletter',
            'newsletterDeleteId': id
        };
        $.ajax({
            url: ajax_url,
            type: 'post',
            data: data,
            dataType: 'text',
            error: function (request, error) {
                alert(" Can't do because: " + error);
            },
            success: function(response){
                all_record();

            }
        });

    });
    $('#templateSelect').on('change', function () {
        $.ajax({
            url: ajax_url,
            type: 'post',
            data: {'action': 'getTemplate','templatePath': this.value},
            dataType: 'text',
            error: function (request, error) {
                alert(" Can't do because: " + error);
            },
            success: function(response){
                $('#templateWrapper').html($.parseHTML(response))
            }
        });
    })
    $(document).on('submit','#templateData', function (e) {
        e.preventDefault();
        let formData = $(this).serializeArray().reduce((obj, item) => ({ ...obj, ...{ [item.name]: item.value } }), {})
        $.ajax({
            url: ajax_url,
            type: $(this).attr('method'),
            data: {action: 'saveTemplateData', formData:formData},
            error: function (request, error) {
                alert(" Can't do because: " + error);
            },
            success: function(response){
                console.log(response)
            }
        });
    })
});