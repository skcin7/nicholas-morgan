;(function(app, $, axios, undefined) {
    app.appPages.push({
        pageName: 'admin_quotes',

        $quoteAdminModal: $('#quote_admin_modal'),

        /**
         * Set the page's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let page = this;

            // Add a quote
            $('body').on('click', '[data-action=admin_add_quote]', function(event) {
                event.preventDefault();

                page.$quoteAdminModal.find('input[name=id]').val('');
                page.$quoteAdminModal.find('textarea[name=quote]').val('');
                page.$quoteAdminModal.find('input[name=author]').val('');
                page.$quoteAdminModal.find('input[name=is_public]').prop('checked', false);
                page.$quoteAdminModal.modal('show');
            });

            // Edit a quote
            $('body').on('click', '[data-action=admin_edit_quote]', function(event) {
                event.preventDefault();
                let $clickedElement = $(this);
                let quote_id = $clickedElement.data('id');

                axios.get(app.url('api/quotes/' + quote_id))
                    .then((response) => {
                        // console.log(response);
                        // console.log(response.data);

                        let quote_data = response.data.data;
                        page.$quoteAdminModal.find('input[name=id]').val(quote_data.id);
                        page.$quoteAdminModal.find('textarea[name=quote]').val(quote_data.quote);
                        page.$quoteAdminModal.find('input[name=author]').val(quote_data.author);
                        page.$quoteAdminModal.find('input[name=is_public]').prop('checked', quote_data.is_public);
                        page.$quoteAdminModal.modal('show');
                    })
                    .catch((error) => {
                        console.log(error);
                        console.log(error.response);
                    });
            });

            // form is being submitted to add a new modal or edit an existing modal:
            page.$quoteAdminModal.on('submit', 'form', async function(event) {
                event.preventDefault();

                let quote_data = {
                    'id': page.$quoteAdminModal.find('input[name=id]').val(),
                    'quote': page.$quoteAdminModal.find('textarea[name=quote]').val(),
                    'author': page.$quoteAdminModal.find('input[name=author]').val(),
                    'is_public': page.$quoteAdminModal.find('input[name=is_public]').is(':checked'),
                };

                // Determine whether to CREATE or UPDATE based on the ID value.
                let quote_id = page.$quoteAdminModal.find('input[name=id]').val();

                axios({
                    "method": (quote_id.length == 0 ? 'POST' : 'PUT'),
                    "url": app.url('api/quotes' + (quote_id.length == 0 ? '' : '/' + quote_id)),
                    "data": quote_data,
                })
                    .then((response) => {
                        // console.log(response);
                        // console.log(response.data);

                        $.notify(response.data.message);
                        page.$quoteAdminModal.modal('hide');
                    })
                    .catch((error) => {
                        console.log(error);
                        console.log(error.response);
                    });
            });

            return page;
        },

        /**
         * Initialize the page.
         *
         * @param config
         */
        init: function() {
            let page = this;

            //

            return page;
        },

    });
})(window.NickMorgabWebApp, window.jQuery, window.axios);
