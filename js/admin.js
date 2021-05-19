jQuery(document).ready(function($) {
    $(document).on('click', '.imageUpload', function (e) {
        e.preventDefault();
        let button = $(this);
        let fileFrame = wp.media.frames.file_frame = wp.media({
            title: 'Izaberite ili ubacite sliku',
            library: {
                type: 'image'
            },
            button: {
                text: 'Izaberite sliku'
            },
            multiple: false
        });
        fileFrame.open();
        fileFrame.on('select', function (){
            let attachment = fileFrame.state().get('selection').first().toJSON();
            button.siblings('.imageInput').val(attachment.url)
            button.attr('src',attachment.url)
        })
    })

    //Validation for newsletter form
    if ($('#newsletterForm').length !== 0) {
        $('#title').on('blur', validateTitle)
        $('#templateName').on('change', validateTemplateSelect)
        $( "input[type='submit']").on('click', validateForm)
    }

    function validateTitle(){
        let input = $('#title');
        if (input.val().length === 0){
            if (!input.hasClass('validationError')) {
                input.before('<div class="errorMsg">Morate uneti naziv newsletter-a</div>');
                input.addClass('validationError');
            }
        } else {
            input.parent().find('.errorMsg').remove()
            input.removeClass('validationError')
            return true;
        }
        return false;
    }

    function validateTemplateSelect(){
        let input = $('#templateName');
        if (input.val() === '-1'){
            if (!input.hasClass('validationError')) {
                input.before('<div class="errorMsg">Morate izbrati šablon</div>');
                input.addClass('validationError');
            }
        } else {
            input.parent().find('.errorMsg').remove()
            input.removeClass('validationError')
            return true;
        }
        return false;
    }

    function validateTemplate(){
        let contentWrapper = $('#contentWrapper');
        let validation = false;
        $('input[name^="url"]').each(function() {
            if ($(this).val().length === 0) {
                if (contentWrapper.find('.errorMsg.url').length === 0) {
                    $('#contentWrapper').prepend('<div class="errorMsg url">Svi linkovi moraju biti popunjeni</div>')
                    validation = false;
                }
            } else {
                $('#contentWrapper').find('.errorMsg.url').remove()
                validation = true;
            }
        });
        $('input[name^="src"]').each(function() {
            if ($(this).val().length === 0) {
                if (contentWrapper.find('.errorMsg.src').length === 0) {
                    contentWrapper.prepend('<div class="errorMsg src">Morate uneti sve slike</div>')
                    validation = false
                }
            } else {
                contentWrapper.find('.errorMsg.src').remove()
                validation = true;
            }
        });

        return validation;
    }

    function validateForm(e) {
        if (!validateTitle() || !validateTemplateSelect() || !validateTemplate()) {
            e.preventDefault();
            $(window).scrollTop(0);
        }
    }
})
