define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/publish.html',
    'bootstrap'
], function (
    $,
    _,
    Backbone,
    template
    ) {
    return Backbone.View.extend({
        el: 'body',
        events: {
            'click #start-publishing': 'startPublishing',
            'click #stop-publishing': 'stopPublishing'
        },
        render: function(item) {
            this.$el.append(_.template(template, { data: { item: item } }));
            var $popup = $('#publish');
            $popup.on('hidden.bs.modal', function () {
                    $(this).remove();
                });
            $popup.modal('show');
        },
        startPublishing: function(event) {
            event.preventDefault();
            event.stopPropagation();
            var
                self = this,
                $this = $(event.currentTarget);
            self.hidePopup(function () {
                $.ajax({
                    url: 'api/start-publishing.php',
                    type: 'post',
                    data: { target: $this.data('href') },
                    success: function (response) {
                        if (response.status === "publishing") {
                            response.href = $this.data('href');
                            self.render(response);
                        }
                    },
                    error: function () {
                        console.log('AJAX error');
                    }
                });
            });
        },
        stopPublishing: function(event) {
            event.preventDefault();
            event.stopPropagation();
            var
                self = this,
                $this = $(event.currentTarget);
            self.hidePopup(function () {
                $.ajax({
                    url: 'api/stop-publishing.php',
                    type: 'post',
                    data: { target: $this.data('href') },
                    success: function (response) {
                        if (response.status === "not publishing") {
                            response.href = $this.data('href');
                            self.render(response);
                        }
                    },
                    error: function () {
                        console.log('AJAX error');
                    }
                });
            });
        },
        hidePopup: function(callback) {
            var $popup = $('#publish');
            $popup.on('hidden.bs.modal', callback);
            $popup.modal('hide');
        }
    });
});