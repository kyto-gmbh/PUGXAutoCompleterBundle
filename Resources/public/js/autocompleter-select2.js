(function ($) {
    'use strict';
    $.fn.autocompleter = function (options) {
        var settings = {
            url_list: '',
            url_get:  '',
            placeholder: '',
            minimumInput: 2
        };
        return this.each(function () {
            if (options) {
                $.extend(settings, options);
            }
            var $this = $(this), $fakeInput = $('<input type="text" name="' + $this.attr('name') + '">');
            $this.hide().after($fakeInput);
            $fakeInput.select2({
                ajax: {
                    url: settings.url_list,
                    dataType: 'json',
                    delay: 250,
                    placeholder: settings.placeholder,
                    data: function (params) {
                        return {
                            q: params
                        };
                    },
                    results: function (data) {
                        var results = [];
                        $.each(data, function (index, item) {
                            results.push({
                                id: item.id,
                                text: item.value
                            });
                        });
                        return {
                            results: results
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                initSelection: function (element, callback) {
                    $.ajax({
                        url:     settings.url_get + $this.val(),
                        success: function (name) {
                            var data = { "id": $this.val(), "text": name };
                            callback(data);
                        }
                    });
                },
                minimumInputLength:  settings.minimumInput
            });
            if ($this.val() !== '') {
                $.ajax({
                    url: (settings.url_get.substring(-1) === '/' ? settings.url_get : settings.url_get + '/') + $this.attr('value'),
                    success: function (name) {
                        $fakeInput.select2('val', name);
                    }
                });
            }
            $fakeInput.on('change', function (e) {
                $this.val(e.val).change();
            });
        });
    };
})(jQuery);
