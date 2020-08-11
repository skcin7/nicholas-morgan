;(function(app, $, undefined) {
    app.modules.push({
        moduleName: 'Welcome',

        initModule: function(config) {
            let module = this;

            console.log('Welcome module loaded.');
        },

    });
})(window.NickMorgan, window.jQuery);
