(function ($) {
  function generateKey(length) {
    var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
    var key = '';
    for (var i = 0; i < length; i++) {
      key += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return key;
  }

  $(function () {
    var frame;

    $('.bakhtech-cs-logo-upload').on('click', function (event) {
      event.preventDefault();

      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title: 'Select logo',
        button: { text: 'Use logo' },
        multiple: false
      });

      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        $('#bakhtech-cs-logo-url').val(attachment.url);
        $('#bakhtech-cs-logo-preview').attr('src', attachment.url).removeClass('is-hidden');
      });

      frame.open();
    });

    $('.bakhtech-cs-logo-remove').on('click', function (event) {
      event.preventDefault();
      $('#bakhtech-cs-logo-url').val('');
      $('#bakhtech-cs-logo-preview').attr('src', '').addClass('is-hidden');
    });

    $('.bakhtech-cs-generate-key').on('click', function (event) {
      event.preventDefault();
      $('#bakhtech-cs-bypass-key').val(generateKey(16));
    });
  });
})(jQuery);
