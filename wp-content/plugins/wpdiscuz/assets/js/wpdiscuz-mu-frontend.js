jQuery(document).ready(function ($) {

    const wpNativeAjax = parseInt(wpdiscuzAjaxObj.isNativeAjaxEnabled, 10);

    // Per-form file list: maps form DOM element -> Array of File objects
    const wmuFileLists = new WeakMap();

    $('body').on('click', '#wpdcom .wmu-upload-wrap', function () {
        $('.wpd-form-foot', $(this).parents('.wpd_comm_form')).slideDown(parseInt(wpdiscuzAjaxObj.enableDropAnimation) ? 500 : 0);
    });

    $(document).on('change', '.wmu-add-files', function () {
        const btn = $(this);
        const form = btn.closest('.wpd_comm_form');
        const files = btn[0].files ? Array.from(btn[0].files) : [];
        if (files.length) {
            wmuFileLists.set(form[0], files);
            $('.wmu-action-wrap .wmu-tabs', form).html('');
            $.each(files, function (index, file) {
                renderFilePreview(form, file, index);
            });
        } else {
            return;
        }
    });

    $(document).on('click', '.wmu-preview-delete', function () {
        const $preview = $(this).closest('.wmu-preview');
        const $form = $preview.closest('.wpd_comm_form');
        const index = parseInt($preview.data('wmu-index'));
        const type = $preview.data('wmu-type');

        const fileArray = wmuFileLists.get($form[0]) || [];
        fileArray[index] = null;
        wmuFileLists.set($form[0], fileArray);
        syncFileInput($form, fileArray);

        $preview.remove();

        const $tab = $('.wmu-action-wrap .wmu-' + type + '-tab', $form);
        if (!$tab.children('.wmu-preview').length) {
            $tab.addClass('wmu-hide');
        }
    });

    $(document).on('change', '.wmu-replace-input', function () {
        const input = $(this);
        const preview = input.closest('.wmu-preview');
        const form = preview.closest('.wpd_comm_form');
        const index = parseInt(preview.data('wmu-index'));
        const newFile = this.files[0];

        if (!newFile) return;

        const fileArray = wmuFileLists.get(form[0]) || [];
        fileArray[index] = newFile;
        wmuFileLists.set(form[0], fileArray);

        syncFileInput(form, fileArray);
        updatePreviewForFile(form, preview, newFile);

        // Reset so the same file can be re-selected if needed
        input.val('');
    });

    function syncFileInput(form, fileArray) {
        if (typeof DataTransfer === 'undefined') return;
        const dt = new DataTransfer();
        fileArray.forEach(function (file) {
            if (file) dt.items.add(file);
        });
        const mainInput = form.find('.wmu-add-files')[0];
        if (mainInput) {
            mainInput.files = dt.files;
        }
    }

    function renderFilePreview(form, file, index) {
        let mimeType = file.type;
        let previewArgs = {
            'id': '',
            'icon': '',
            'fullname': file.name,
            'shortname': getShortname(file.name),
            'type': '',
            'index': index,
        };

        if (mimeType.match(/^image/)) {
            previewArgs.type = 'images';
            if (window.FileReader) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function () {
                    previewArgs.icon = this.result;
                    previewArgs.shortname = '';
                    initPreview(form, previewArgs);
                }
            }
        } else if (mimeType.match(/^video/) || mimeType.match(/^audio/)) {
            previewArgs.type = 'videos';
            previewArgs.icon = wpdiscuzAjaxObj.wmuIconVideo;
            initPreview(form, previewArgs);
        } else {
            previewArgs.type = 'files';
            previewArgs.icon = wpdiscuzAjaxObj.wmuIconFile;
            initPreview(form, previewArgs);
        }
    }

    function updatePreviewForFile(form, previewEl, file) {
        let mimeType = file.type;
        let newType;

        if (mimeType.match(/^image/)) {
            newType = 'images';
        } else if (mimeType.match(/^video/) || mimeType.match(/^audio/)) {
            newType = 'videos';
        } else {
            newType = 'files';
        }

        const oldType = previewEl.data('wmu-type');
        const index = parseInt(previewEl.data('wmu-index'));

        if (oldType !== newType) {
            // File type changed — remove from old tab, add to new tab
            const oldTab = $('.wmu-action-wrap .wmu-' + oldType + '-tab', form);
            previewEl.remove();
            if (!oldTab.children().length) {
                oldTab.addClass('wmu-hide');
            }
            renderFilePreview(form, file, index);
        } else {
            // Same type — update the existing preview element in-place
            previewEl.attr('title', file.name);
            previewEl.data('wmu-type', newType);
            previewEl.find('.wmu-file-name').text(getShortname(file.name));

            if (mimeType.match(/^image/) && window.FileReader) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function () {
                    previewEl.find('.wmu-preview-img').attr('src', this.result);
                    previewEl.find('.wmu-file-name').text('');
                };
            } else if (mimeType.match(/^video/) || mimeType.match(/^audio/)) {
                previewEl.find('.wmu-preview-img').attr('src', wpdiscuzAjaxObj.wmuIconVideo);
            } else {
                previewEl.find('.wmu-preview-img').attr('src', wpdiscuzAjaxObj.wmuIconFile);
            }
        }
    }

    /**
     * @param form
     * @param args
     */
    function initPreview(form, args = {}) {
        let previewTemplate = wpdiscuzAjaxObj.previewTemplate;
        previewTemplate = previewTemplate.replace('[PREVIEW_TYPE_CLASS]', 'wmu-preview-' + args.type);
        previewTemplate = previewTemplate.replace('[PREVIEW_TITLE]', args.fullname);
        previewTemplate = previewTemplate.replace('[PREVIEW_TYPE]', args.type);
        previewTemplate = previewTemplate.replace('[PREVIEW_ID]', args.id);
        previewTemplate = previewTemplate.replace('[PREVIEW_ICON]', args.icon);
        previewTemplate = previewTemplate.replace('[PREVIEW_FILENAME]', args.shortname);
        previewTemplate = previewTemplate.replace('[PREVIEW_INDEX]', typeof args.index !== 'undefined' ? args.index : '');
        const $preview = $(previewTemplate);
        // Copy the accept attribute from the main file input so the replace picker is equally restricted
        const accept = form.find('.wmu-add-files').attr('accept');
        if (accept) {
            $preview.find('.wmu-replace-input').attr('accept', accept);
        }
        $('.wmu-action-wrap .wmu-' + args.type + '-tab', form).removeClass('wmu-hide').append($preview);
    }

    function getShortname(str) {
        let shortname = str;
        if ((typeof str !== 'undefined') && str.length) {
            if (str.length > 40) {
                shortname = str.substring(str.length - 40);
                shortname = "..." + shortname;
            }
        }
        return shortname;
    }

    $('body').on('click', '.wmu-attachment-delete', function (e) {
        if (confirm(wpdiscuzAjaxObj.wmuPhraseConfirmDelete)) {
            const btn = $(this);
            const attachmentId = btn.data('wmu-attachment');
            const data = new FormData();
            data.append('action', 'wmuDeleteAttachment');
            data.append('attachmentId', attachmentId);
            wpdiscuzAjaxObj.getAjaxObj(wpNativeAjax, true, data)
                .done(function (r) {
                    if (r.success) {
                        var parent = btn.parents('.wmu-comment-attachments');
                        btn.parent('.wmu-attachment').remove();
                        if (!$('.wmu-attached-images *', parent).length) {
                            $('.wmu-attached-images', parent).remove();
                        }
                        if (!$('.wmu-attached-videos *', parent).length) {
                            $('.wmu-attached-videos', parent).remove();
                        }
                        if (!$('.wmu-attached-files *', parent).length) {
                            $('.wmu-attached-files', parent).remove();
                        }
                    } else {
                        if (r.data.errorCode) {
                            wpdiscuzAjaxObj.setCommentMessage(wpdiscuzAjaxObj.applyFilterOnPhrase(wpdiscuzAjaxObj[r.data.errorCode], r.data.errorCode, parent), 'error', 3000);
                        } else if (r.data.error) {
                            wpdiscuzAjaxObj.setCommentMessage(r.data.error, 'error', 3000);
                        }
                    }
                    $('#wpdiscuz-loading-bar').fadeOut(250);
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $('#wpdiscuz-loading-bar').fadeOut(250);
                });
        } else {
            console.log('canceled');
        }
    });

    if (parseInt(wpdiscuzAjaxObj.wmuIsLightbox)) {

        function wmuAddLightBox() {

            if (wpdiscuzAjaxObj.postAttachmentsAsGallery) {
                $(".wmu-lightbox").colorbox({
                    maxHeight: "95%",
                    maxWidth: "95%",
                    rel: 'wmu-lightbox',
                    fixed: true
                });
            } else {
                $(".wmu-attached-images").each(function () {
                    // create a unique gallery for each comment
                    var galleryID = 'gallery-' + $(this).closest('.comment').attr('id'); // or any unique identifier
                    $(this).find('.wmu-lightbox').each(function () {
                        $(this).attr('rel', galleryID); // set rel dynamically
                    });
                });

                // initialize colorbox
                $('.wmu-lightbox').colorbox({
                    maxHeight: "95%",
                    maxWidth: "95%",
                    photo: true,
                    fixed: true,
                    rel: function () {
                        return $(this).attr('rel');
                    }
                });
            }

        }

        wmuAddLightBox();
        wpdiscuzAjaxObj.wmuAddLightBox = wmuAddLightBox;
    }

    wpdiscuzAjaxObj.wmuHideAll = function (r, wcForm) {
        if (typeof r === 'object') {
            if (r.success) {
                $('.wmu-tabs', wcForm).addClass('wmu-hide');
                $('.wmu-preview', wcForm).remove();
                $('.wmu-attached-data-info', wcForm).remove();
            } else {
                console.log(r.data);
            }
        } else {
            console.log(r);
        }
    }

});
