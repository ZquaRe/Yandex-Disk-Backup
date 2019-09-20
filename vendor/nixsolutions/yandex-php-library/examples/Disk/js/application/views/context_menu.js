define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/context_menu.html',
    'views/publish'
], function (
    $,
    _,
    Backbone,
    template,
    PublishView
    ) {
    return Backbone.View.extend({
        el: 'body',
        events: {
            'click #create-directory': 'createDirectoryInput',
            'click #create-directory-success': 'createDirectory',
            'click #open-item': 'openItem',
            'click #copy-item': 'copyItem',
            'click .item-context-folder': 'markDirectory',
            'click #item-context-open': 'openMarkedDirectory',
            'click #item-copy-do': 'copyToMarkedDirectory',
            'click #move-item': 'moveItem',
            'click #item-move-do': 'moveToMarkedDirectory',
            'click #delete-item': 'deleteItem',
            'click #info-item': 'showItemInfo',
            'click #download-item': 'downloadItem',
            'click #publish-item': 'publish'
        },
        render: function(x, y, type, item, buffer) {
            this.removeMenu();
            this.$el.append(_.template(template, {
                data: {
                    x: x,
                    y: y,
                    type: type,
                    item: item,
                    buffer: buffer
                }
            }));
            return this;
        },
        createDirectoryInput: function(event) {
            event.preventDefault();
            event.stopPropagation();
            var $this = $(event.currentTarget);
            if ($('#create-directory-success').length === 0) {
                $this.parent().append('<div><input type="text"><span id="create-directory-success"> Create</span></div>');
            }
            return false;
        },
        createDirectory: function(event) {
            var $this = $(event.currentTarget);
            var directoryName = $this.prev().val();
            if (directoryName !== '' &&  directoryName.indexOf('/') === -1) {
                var self = this;
                var url = 'api/create-directory.php';
                var directory = '';
                if (application.paths.current === '/') {
                    directory = encodeURIComponent(application.paths.current + directoryName);
                } else {
                    directory = encodeURIComponent(application.paths.current + '/' + directoryName);
                }

                $this.parent().parent().remove();

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        directory: directory
                    },
                    success: function (response) {
                        if (response.status === 'OK') {
                            application.paths.refresh();
                            application.views.directoryView.render(application.paths.current);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            } else {
                $this.prev().css('border', '2px solid red');
            }
            return false;
        },
        deleteItem: function(event) {
            var $this = $(event.currentTarget);
            var href = $this.data('href');
            $this.parent().remove();
            $.ajax({
                url: 'api/delete-by-path.php',
                type: 'post',
                data: {
                    path: href
                },
                success: function (response) {
                    if (response.status === 'OK') {
                        application.paths.refresh();
                        application.views.directoryView.render(application.paths.current);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
            return false;
        },
        openItem: function(event) {
            event.preventDefault();
            event.stopPropagation();
            var $this = $(event.currentTarget);
            if ($this.hasClass('open-file')) {
                location.href = 'api/get-file.php?file=' + $this.data('href');
            } else {
                application.views.directoryView.render($this.data('href'));
            }
            return false;
        },
        showItemInfo: function(event) {
            var $this = $(event.currentTarget);
            var info = _.findWhere(application.contents, { href: $this.data('href') });
            var x = parseInt($this.parents('.context-menu').css('left'), 10);
            var y = parseInt($this.parents('.context-menu').css('top'), 10);
            this.render(x, y, 'info', info);
            return false;
        },
        copyItem: function(event) {
            var self = this;
            var $this = $(event.currentTarget);

            var hrefArray = $this.data('href').split('/');
            application.buffer.copy = hrefArray.pop();
            application.buffer.copy = application.buffer.copy === '' ? hrefArray.pop(): application.buffer.copy;

            var x = parseInt($this.parents('.context-menu').css('left'), 10);
            var y = parseInt($this.parents('.context-menu').css('top'), 10);
            this.getDirectoryInfo({
                path: '/',
                success: function (response) {
                    response.shift();
                    self.render(x, y, 'copy', response, application.buffer);
                }
            });
            return false;
        },
        unmarkDirectories: function() {
            $('.item-context-folder').each(function () {
                $(this).removeClass('marked');
            });
        },
        markDirectory: function(event) {
            this.unmarkDirectories();
            var $this = $(event.currentTarget);
            $this.addClass('marked')
            return false;
        },
        openMarkedDirectory: function(event) {
            var self = this;
            var $this = $(event.currentTarget);
            var x = parseInt($this.parents('.context-menu').css('left'), 10);
            var y = parseInt($this.parents('.context-menu').css('top'), 10);
            var path = $this.parents('.context-menu').find('.marked').data('href');
            var action = $this.parents('.context-menu').find('.marked').hasClass('copy') ? 'copy' : 'move';
            this.getDirectoryInfo({
                path: path,
                success: function(response) {
                    response.shift();
                    if (response.length > 0) {
                        self.render(x, y, action, response, application.buffer);
                    }
                }
            });
            return false;
        },
        copyToMarkedDirectory: function(event) {
            var $this = $(event.currentTarget);
            var target = application.paths.current + application.buffer.copy;
            var destination = $this
                .parents('.context-menu')
                .find('.marked')
                .data('href');
            if (destination) {
                destination += application.buffer.copy;
                $this.addClass('disabled');
                $.ajax({
                    url: 'api/copy.php',
                    type: 'post',
                    data: { target: target, destination: destination },
                    success: function(response) {
                        if (response.status === "OK") {
                            application.views.directoryView.render(application.paths.refresh());
                        }
                    }
                });
            }
            return false;
        },
        moveItem: function(event) {
            var self = this;
            var $this = $(event.currentTarget);

            var hrefArray = $this.data('href').split('/');
            application.buffer.move = hrefArray.pop();
            application.buffer.move = application.buffer.move === '' ? hrefArray.pop() : application.buffer.move;

            var x = parseInt($this.parents('.context-menu').css('left'), 10);
            var y = parseInt($this.parents('.context-menu').css('top'), 10);
            this.getDirectoryInfo({
                path: '/',
                success: function (response) {
                    response.shift();
                    self.render(x, y, 'move', response, application.buffer);
                }
            });
            return false;
        },
        moveToMarkedDirectory: function(event) {
            var $this = $(event.currentTarget);
            var target = application.paths.current + application.buffer.move;
            var destination = $this
                .parents('.context-menu')
                .find('.marked')
                .data('href');
            if (destination) {
                destination += application.buffer.move;
                $this.addClass('disabled');
                $.ajax({
                    url: 'api/move.php',
                    type: 'post',
                    data: { target: target, destination: destination },
                    success: function(response) {
                        if (response.status === "OK") {
                            application.views.directoryView.render(application.paths.refresh());
                        }
                    }
                });
            }
            return false;
        },
        getDirectoryInfo: function(options) {
            $.ajax({
                url: 'api/directory-contents.php',
                type: 'post',
                data: { 'directory': options.path },
                success: options.success,
                error: options.error
            });
        },
        downloadItem: function(event) {
            var $this = $(event.currentTarget);
            location.href = 'api/get-file.php?file=' + $this.data('href');
            return false;
        },
        publish: function(event) {
            var $this = $(event.currentTarget);
            var self = this;
            $.ajax({
                url: 'api/check-publishing.php',
                type: 'post',
                data: { target: $this.data('href') },
                success: function (response) {
                    response.href = $this.data('href');
                    self.removeMenu();
                    application.views.publishView = application.views.publishView || new PublishView();
                    application.views.publishView.render(response);
                },
                error: function () {
                    console.log('AJAX error');
                }
            });
            return false;
        },
        removeMenu: function() {
            $('.context-menu').remove();
        }
    });
});