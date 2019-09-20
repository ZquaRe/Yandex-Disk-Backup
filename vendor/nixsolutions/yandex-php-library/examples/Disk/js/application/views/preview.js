define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/preview.html'
], function (
    $,
    _,
    Backbone,
    template
    ) {
    return Backbone.View.extend({
        el: 'body',
        events: {
            'click .resize span': 'resize',
            'click .accurate-resize': 'accurateResize'
        },
        render: function(href, size) {
            var item = _.findWhere(application.contents, { 'href': href });

            this.$el.append(_.template(template, { data: { item: item, baseUrl: location.port + '//' + location.host, size: size } }));
            var $image = $('#preview-image');
            var $popup = $('#preview');
            $popup.on('hidden.bs.modal', function () {
                $(this).remove();
            });
            $image.on('load', function() {
                $popup
                    .find('.modal-dialog')
                    .css('width', ($(this)[0].width >= 600 ? ($(this)[0].width + 60) : 600) + 'px');
                $popup.modal('show');
            });
        },
        resize: function(event) {
            var self = this;
            var $this = $(event.currentTarget);
            this.hide(function () {
                self.render($this.data('href'), $this.data('value'));
            });
            return false;
        },
        accurateResize: function (event) {
            var self = this;
            var $this = $(event.currentTarget);

            var $width = $this.prev('.accurate-size').find('#preview-width');
            var $height = $this.prev('.accurate-size').find('#preview-height');

            var width = $width.val();
            var height = $height.val();
            var size = width + 'x' + height;

            if (size === 'x') {
                $width.css('border', '2px solid red');
                $height.css('border', '2px solid red');
            } else {
                this.hide(function () {
                    self.render($this.data('href'), size);
                });
            }
            return false;
        },
        hide: function(callback) {
            var $popup = $('#preview');
            $popup.on('hidden.bs.modal', callback);
            $popup.modal('hide');
        }
    });
});