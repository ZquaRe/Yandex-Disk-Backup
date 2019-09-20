define([
    'jquery',
    'underscore',
    'backbone',
    'text!templates/directory.html',
    'views/context_menu',
    'views/preview',
    'bootstrap'
], function (
    $,
    _,
    Backbone,
    template,
    ContextMenuView,
    PreviewView
    ) {
        return Backbone.View.extend({
            el: '#app',
            events: {
                'mousedown .elements-list-item': 'showItemContextMenu',
                'mousedown .container': 'showContextMenu',
                'click .directory': 'openDirectory',
                'click .navigation': 'goToPath',
                'click .container': 'removeContextMenu',
                'click .image': 'openPreview',
                'change #upload-input': 'changeUploadFileName'
            },
            getDiscSpaceInfo: function(options) {
                $.ajax({
                    url: 'api/disc-space-info.php',
                    success: options.success,
                    error: options.error
                });
            },
            render: function(path) {
                var self = this;
                var url = 'api/directory-contents.php';
                this.getDiscSpaceInfo({
                    success: function (response) {
                        var space = response;
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                directory: path
                            },
                            success: function (response) {
                                application.paths.forward(response.shift());
                                application.contents = response;
                                self.$el.html(_.template(
                                        template,
                                        {
                                            data: {
                                                baseUrl: location.protocol + "//" + location.host,
                                                space: space,
                                                paths: application.paths,
                                                contents: response,
                                                previous: '/'
                                            }
                                        }
                                    )
                                );
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                });
                return this;
            },
            showContextMenu: function(event) {
                if (event.button == 2) {
                    application.views.contextMenuView = application.views.contextMenuView || new ContextMenuView();
                    application.views.contextMenuView.render(event.pageX, event.pageY);
                    return false;
                }
                return true;
            },
            showItemContextMenu: function(event) {
                var $this = $(event.currentTarget);
                if (event.button == 2) {
                    var item = {
                        href: $this.data('href'),
                        type: $this.hasClass('file') ? 'file' : 'dir'
                    };
                    application.views.contextMenuView = application.views.contextMenuView || new ContextMenuView();
                    console.log(event);
                    application.views.contextMenuView.render(event.pageX, event.pageY, 'item', item);
                    return false;
                } else if ($this.hasClass('file') && !$this.hasClass('image')) {
                    location.href = $this.attr('href');
                    return false;
                }
                return true;
            },
            openDirectory: function(event) {
                this.render($(event.currentTarget).data('href'));
                return false;
            },
            goToPath: function(event) {
                this.render(application.paths.go($(event.currentTarget).data('num')));
                return false;
            },
            removeContextMenu: function() {
                $('.context-menu').remove();
            },
            openPreview: function(event) {
                event.stopPropagation();
                event.preventDefault();
                application.views.preview = application.views.preview || new PreviewView();
                application.views.preview.render($(event.currentTarget).data('href'), '600');
                return false;
            },
            changeUploadFileName: function(event) {
                var $this = $(event.currentTarget);
                var filePath = $this.val();
                var pathParts = filePath.indexOf('/') + 1 ? filePath.split('/') : filePath.split('\\');
                var fileName = pathParts.pop();
                var resolutions = ['jpg', 'bmp', 'png', 'gif'];
                $('#upload-button-name').html(fileName === '' ? 'Add file' : fileName);
                $('#upload-image-preview').html('');

                if (_.isFunction(FileReader)) {
                    var file = $this[0].files[0];
                    if (!_.isUndefined(file)) {
                        console.log(file.size);
                        if (file.type.match(/image.*/)) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var image = new Image();
                                image.onload = function() {
                                    var formWidth = $('#upload-form').width();
                                    var imageWidth = this.width < formWidth ? this.width : formWidth;
                                    $('#upload-image-preview').html('<img src="' + this.src + '" width="' + imageWidth + '">');
                                };
                                image.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            }
        });
    });
