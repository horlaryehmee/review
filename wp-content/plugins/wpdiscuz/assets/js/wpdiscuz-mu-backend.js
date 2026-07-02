jQuery(document).ready(function ($) {

    $('body').on('click', '#wmuSelectMimes', function (e) {
        $('.wpd-mu-mimes input[type="checkbox"]').each(function (i, v) {
            $(this).prop('checked', true);
        });
    });

    $('body').on('click', '#wmuUnselectMimes', function (e) {
        $('.wpd-mu-mimes input[type="checkbox"]').each(function (i, v) {
            $(this).prop('checked', false);
        });
    });

    $('body').on('click', '#wmuInvertMimes', function (e) {
        $('.wpd-mu-mimes input[type="checkbox"]').each(function (i, v) {
            $(this).prop('checked', !$(this).prop('checked'));
        });
    });

    $('body').on('click', '.wmu-attachment-delete', function (e) {
        if (confirm(wpdiscuzMUJsObj.wmuMsgConfirmAttachmentDelete)) {
            var data = new FormData();
            var clicked = $(this);
            var attachmentId = clicked.data('wmu-attachment');
            data.append('action', 'wmuDeleteAttachment');
            data.append('attachmentId', attachmentId);
            var ajax = wmuGetAjaxObj(data);
            ajax.done(function (r) {
                if (r.success) {
                    clicked.parent('.wmu-attachment').remove();
                } else {
                    if (r.data.error) {
                        alert(r.data.error);
                    }
                }
            });
        } else {
            console.log('canceled');
        }
    });

    $('body').on('change', '.wmu-image-dimension', function () {
        var parent = $(this).parents('.wpd-opt-row');
        var wmuSingleImageW = $('.wmu-image-width', parent);
        var wmuSingleImageH = $('.wmu-image-height', parent);
        var wmuImageW = Math.abs(wmuSingleImageW.val());
        var wmuImageH = Math.abs(wmuSingleImageH.val());

        if ($(this).hasClass('wmu-image-width')) {
            if (!isNaN(wmuImageW)) {
                wmuImageH = "auto";
                wmuSingleImageH.val('auto');
            } else if (!isNaN(wmuImageW)) {
                wmuSingleImageH.val('auto');
            }
        } else {
            if (!isNaN(wmuImageH)) {
                wmuImageW = 'auto';
                wmuSingleImageW.val('auto');
            } else if (!isNaN(wmuImageW)) {
                wmuSingleImageH.val('auto');
            }
        }
    });

    $('body').on('keyup', '.wmu-image-dimension', function () {
        var value = $(this).val();
        $(this).val(value.replace('-', ''));
    });

    function wmuAddLightBox() {
        if (wpdiscuzMUJsObj.postAttachmentsAsGallery) {
            $('.wmu-lightbox').colorbox({
                maxHeight: '95%',
                maxWidth: '95%',
                rel: 'wmu-lightbox',
                fixed: true
            });
        } else {
            $('.wmu-attached-images').each(function () {
                var commentId = $(this).closest('.wmu-comment-attachments').data('comment-id');
                var galleryID = 'gallery-' + commentId;
                $(this).find('.wmu-lightbox').each(function () {
                    $(this).attr('rel', galleryID);
                });
            });
            $('.wmu-lightbox').colorbox({
                maxHeight: '95%',
                maxWidth: '95%',
                photo: true,
                fixed: true,
                rel: function () { return $(this).attr('rel'); }
            });
        }
    }
    wmuAddLightBox();
    window.wmuAddLightBox = wmuAddLightBox;

    function wmuGetAjaxObj(data) {
        return $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            contentType: false,
            processData: false
        });
    }

});