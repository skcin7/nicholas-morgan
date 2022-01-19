;(function(app, $, undefined) {
    app.appPages.push({
        pageName: 'bookmarklets',

        $bookmarkletModalElem: $('#bookmarklet_modal'),

        default_javascript_code: "(function(){/* Bookmarklet content goes here!... */ alert('The example Bookmarklet works!');}})();",

        /**
         * Set the page's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let page = this;

            // Button is clicked to add a Bookmarklet.
            $('body').on('click', '[data-action=add_bookmarklet]', function(event) {
                event.preventDefault();
                let $clickedElem = $(this);

                let javascript_code = page.default_javascript_code;

                // page.setBookmarkletModalTitle('Add Bookmarklet');
                page.showBookmarkletModal({
                    "id": "",
                    "name": "",
                    "status": "",
                    "javascript_code": javascript_code,
                }, "Add Bookmarklet", false);
            });

            // Button is clicked to edit a Bookmarklet.
            $('body').on('click', '[data-action=edit_bookmarklet]', async function(event) {
                event.preventDefault();
                let $clickedElem = $(this);
                let bookmarklet_id = $clickedElem.data('id');

                await axios({
                    "method": "get",
                    "url": app.url('api/bookmarklets/' + bookmarklet_id),
                })
                    .then((response) => {
                        // console.log(response);
                        // console.log(response.data);

                        let bookmarklet_data = response.data.data;

                        // page.setBookmarkletModalTitle('Add Bookmarklet');
                        page.showBookmarkletModal({
                            "id": bookmarklet_data.id,
                            "name": bookmarklet_data.name,
                            "status": bookmarklet_data.status,
                            "javascript_code": bookmarklet_data.javascript_code,
                        }, "Edit Bookmarklet", true);
                    })
                    .catch((error) => {
                        // console.log(error);
                        // console.log(error.response);

                        //
                    });
            });

            // The form in the modal is submitted, so create or update a Bookmarklet.
            page.$bookmarkletModalElem.on('submit', 'form', async function(event) {
                event.preventDefault();
                let $submittedFormElem = $(this);
                let $submitButtonElem = $submittedFormElem.find('button[type=submit]');
                let submit_button_original_html = $submitButtonElem.html();
                $submitButtonElem.prop('disabled', true).addClass('disabled').html('<i class="icon-spinner animate-spin"></i> Processing...');

                // let bookmarklet_id = $submittedFormElem.find('[name=id]').val();
                let bookmarklet_data = {
                    "id": $submittedFormElem.find('[name=id]').val(),
                    "name": $submittedFormElem.find('[name=name]').val(),
                    "javascript_code": $submittedFormElem.find('[name=javascript_code]').val(),
                    "status": $submittedFormElem.find('[name=status]').val(),
                };

                let method;
                let url;

                // Determine what the method and URL is to be, based on if we are creating, updating, or deleting the Bookmarklet.
                // If the delete checkbox is checked, then instead delete the Bookmarklet.
                if($submittedFormElem.find('[name=delete_bookmarklet]').is(':checked')) {
                    method = "delete";
                    url = app.url("api/bookmarklets/" + bookmarklet_data.id);
                }
                else if(bookmarklet_data.id.length > 0) {
                    method = "put";
                    url = app.url("api/bookmarklets/" + bookmarklet_data.id);
                }
                else if(bookmarklet_data.id.length == 0) {
                    method = "post";
                    url = app.url("api/bookmarklets");
                }



                // // If the delete checkbox is checked, then instead delete the Bookmarklet.
                // if($submittedFormElem.find('[name=delete_bookmarklet]').is(':checked')) {
                //     await axios({
                //         "method": "delete",
                //         "url": app.url("api/bookmarklets/" + bookmarklet_data.id),
                //         "data": bookmarklet_data,
                //     })
                //
                //     return;
                // }

                await axios({
                    "method": method,
                    "url": url,
                    "data": bookmarklet_data
                })
                    .then((response) => {
                        // console.log(response);
                        // console.log(response.data);

                        //$.notify("The Bookmarklet has been " + (response.data.statusCode == 201 ? 'created' : 'updated') + "!");

                        let bookmarklet_data = response.data.data;
                        if(method === "post") {
                            // TODO - create Bookmarklet response
                        }
                        else if(method === "put") {
                            // TODO - update Bookmarklet response


                        }
                        else if(method === "delete") {
                            $('tr[data-bookmarklet_id=' + bookmarklet_data.id + ']').fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }

                        page.hideBookmarkletModal();
                        $.notify(response.data.message);
                    })
                    .catch((error) => {
                        // console.log(error);
                        // console.log(error.response);

                        if(error.response.data.errors.name) {
                            let $nameInputElem = page.$bookmarkletModalElem.find('[name=name]');
                            $nameInputElem.removeClass('is-valid is-invalid').addClass('is-invalid');

                            if(! $nameInputElem.next().hasClass('invalid-feedback')) {
                                let $invalidFeedbackElem = $('<span class="invalid-feedback" role="alert"><strong>' + error.response.data.errors.name[0] + '</strong></span>');
                                $invalidFeedbackElem.insertAfter( $nameInputElem );
                            }
                        }

                        if(error.response.data.errors.status) {
                            let $statusInputElem = page.$bookmarkletModalElem.find('[name=status]');
                            $statusInputElem.removeClass('is-valid is-invalid').addClass('is-invalid');

                            if(! $statusInputElem.next().hasClass('invalid-feedback')) {
                                let $invalidFeedbackElem = $('<span class="invalid-feedback" role="alert"><strong>' + error.response.data.errors.status[0] + '</strong></span>');
                                $invalidFeedbackElem.insertAfter( $statusInputElem );
                            }
                        }

                        if(error.response.data.errors.javascript_code) {
                            let $javascriptCodeInputElem = page.$bookmarkletModalElem.find('[name=javascript_code]');
                            $javascriptCodeInputElem.removeClass('is-valid is-invalid').addClass('is-invalid');

                            if(! $javascriptCodeInputElem.next().hasClass('invalid-feedback')) {
                                let $invalidFeedbackElem = $('<span class="invalid-feedback" role="alert"><strong>' + error.response.data.errors.javascript_code[0] + '</strong></span>');
                                $invalidFeedbackElem.insertAfter( $javascriptCodeInputElem );
                            }
                        }

                        $.notify(error.response.data.message, {
                            "className": "danger",
                        });

                        // console.log(error.response.data.errors.name);
                    })
                    .finally(() => {
                        $submitButtonElem.prop('disabled', false).removeClass('disabled').html(submit_button_original_html);
                    });
            });

            page.$bookmarkletModalElem.on('click', '[data-action=test_bookmarklet]', function(event) {
                event.preventDefault();
                console.log('hi');

                let current_javascript_code = page.$bookmarkletModalElem.find('[name=javascript_code]').val();
                let $tempAnchorElement = $('<a/>')
                    .attr('href', current_javascript_code);
                $tempAnchorElement.appendTo( $('body') );
                $tempAnchorElement.trigger('click');
                $tempAnchorElement.remove();
            });


            return page;
        },

        /**
         * Initialize the page.
         *
         * @param config
         */
        init: function(config) {
            let page = this;

            //

            return page;
        },

        /**
         * Show the Bookmarklet modal.
         *
         * @param bookmarklet_data
         * @returns void
         */
        showBookmarkletModal: function(bookmarklet_data = {}, modal_title = "Bookmarklet", show_delete_checkbox = false) {
            let page = this;

            page.$bookmarkletModalElem.find('[name=id]').val(bookmarklet_data.id ? bookmarklet_data.id : '');
            page.$bookmarkletModalElem.find('[name=name]').val(bookmarklet_data.name ? bookmarklet_data.name : '');
            page.$bookmarkletModalElem.find('[name=status]').val(bookmarklet_data.status ? bookmarklet_data.status : '');
            page.$bookmarkletModalElem.find('[name=javascript_code]').val(bookmarklet_data.javascript_code ? bookmarklet_data.javascript_code : '');
            page.$bookmarkletModalElem.find('[name=delete_bookmarklet]').prop('checked', false);

            page.setBookmarkletModalTitle(modal_title);

            // Always hide the delete bookmarklet checkboxes. Re-show them if specified.
            page.$bookmarkletModalElem.find('[name=delete_bookmarklet]').closest('.form-group').hide();
            if(show_delete_checkbox) {
                page.$bookmarkletModalElem.find('[name=delete_bookmarklet]').closest('.form-group').show();
            }

            page.$bookmarkletModalElem.modal('show');
        },

        /**
         * Hide the Bookmarklet modal.
         *
         * @returns void
         */
        hideBookmarkletModal: function() {
            let page = this;
            page.$bookmarkletModalElem.modal('hide');
        },

        /**
         * Set the Bookmarklet modal title.
         *
         * @returns void
         */
        setBookmarkletModalTitle: function(title) {
            let page = this;
            page.$bookmarkletModalElem.find('.modal-title').html(title);
        },



    });
})(window.NickMorgabWebApp, window.jQuery);
