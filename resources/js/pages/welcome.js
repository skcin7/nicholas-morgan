;(function(app, $, undefined) {
    app.appPages.push({
        pageName: 'welcome',

        init: function(config) {
            let page = this;

            console.log('welcome page loaded.');

            $('[data-action=mirror]').click(function(event) {
                event.preventDefault();
                app.mirrorPage();
            });

            $('[data-action=rotate]').click(function(event) {
                event.preventDefault();
                app.rotatePage();
            });

            $('[data-action=play_contra]').click(function(event) {
                event.preventDefault();
                window.location = app.url('contra');
            });

            return page;
        },

    });
})(window.NickMorgan, window.jQuery);
