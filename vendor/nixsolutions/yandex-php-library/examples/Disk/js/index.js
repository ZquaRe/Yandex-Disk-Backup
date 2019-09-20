var application = {
    views: {},
    paths: {
        length: 0,
        current: '/',
        forward: function(root) {
            var num = this.length > 0 ? this.length : 0;
            this.current = root.href;
            this[num] = {
                'num': num,
                'href': root.href,
                'name': root.displayName
            };
            this.length = this.length + 1;
        },
        refresh: function() {
            if (this.length === 0) {
                return false;
            }
            var num = this.length - 1;
            var href = this[num].href;
            this.length -= 1;
            delete this[num];
            return href;
        },
        back: function() {
            var href = this[this.length - 2].href;
            delete this[this.length - 1];
            delete this[this.length - 2];
            this.length -= 2;
            return href;
        },
        go: function(number) {
            var href = this[number].href;

            var length = this.length;

            for (var i = number; i < length; i++) {
                delete this[i];
                this.length -= 1;
            }

            return href;
        },
        reset: function() {
            for (var i = 0; i < this.length; i++) {
                delete this[i];
            }
        },
        getCurrent: function() {
            return this[this.length - 1];
        },
        getPrevious: function() {
            return this.length > 1 ? this[this.length - 2] : false;
        }
    },
    buffer: {}
};

require.config({
    baseUrl: 'js/',
    paths: {
        'jquery': '//yandex.st/jquery/2.0.3/jquery.min',
        'jquery.cookie': '//yandex.st/jquery/cookie/1.0/jquery.cookie.min',
        'underscore': '//yandex.st/underscore/1.5.2/underscore-min',
        'backbone': '//yandex.st/backbone/1.0.0/backbone-min',
        'bootstrap': '//yandex.st/bootstrap/3.0.0/js/bootstrap.min',
        'views': 'application/views',
        'templates': 'application/templates'
    },
    shim: {
        'jquery': {
            exports: '$'
        },
        'jquery.cookie': {
            deps: ['jquery']
        },
        'underscore': {
            exports: '_'
        },
        'backbone': {
            exports: 'Backbone',
            deps: ['underscore', 'jquery']
        },
        'bootstrap': {
            deps: ['jquery']
        }
    }
});

require([
    'jquery',
    'backbone',
    'application/router'
], function (
    $,
    Backbone,
    Router
    ) {
    application.router = new Router();
    Backbone.history.start();
    $(function () {
        document.oncontextmenu = function() {
            return false;
        };
        $(document).ajaxStart(function () {
            $('.ajax-loading').show();
        });

        $(document).ajaxStop(function () {
            $('.ajax-loading').hide();
        });
    });
});