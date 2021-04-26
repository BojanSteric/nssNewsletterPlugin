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
})