'use strict';

(function($){
	wtk.openUploader = function(button, currentAttachmentId) {
		var frame = wp.media({
            title : button.title,
            multiple : false,
            library : { type : 'image'},
            button : { text : 'Insert into widget' },
        });

        var
            $row = $(button).parents('.wtk-row:first'),
            $imagePlaceholder = $row.find('.wtk-image-placeholder'),
            $imageInput = $row.find('.wtk-image-input');

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').first().toJSON();

            $imageInput.val(attachment.id);

            $imagePlaceholder.attr({
                'src': attachment.sizes.large.url,
                'title': attachment.title
            });
        });

        frame.on('close',function() {
            var selection = frame.state().get('selection');

            if(selection.length === 1) {
                return;
            }

            $imageInput.val('');

            $imagePlaceholder.attr({
                'src': $imagePlaceholder.data('default-src'),
                'title': ''
            })
        });

        frame.on('open',function() {
            let selection = frame.state().get('selection'), attachment;

            if(typeof currentAttachmentId === 'undefined')
                return;

            attachment = wp.media.attachment(currentAttachmentId);
            attachment.fetch();

            selection.add( attachment ? [ attachment ] : [] );
        });

        frame.open();
	}
})(jQuery);