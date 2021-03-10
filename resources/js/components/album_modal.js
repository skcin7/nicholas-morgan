;(function(app, $, axios, undefined) {
    app.appComponents.push({
        componentName: 'album_modal',

        // Storing a reference to the jQuery object that represents the album modal in the DOM
        $albumModal: $('#album_modal'),

        /**
         * Set the component's configuration.
         *
         * @param config
         * @returns {setConfig}
         */
        setConfig: function(config) {
            let component = this;

            $('body').on('click', '[data-action=add_album]', function(event) {
                event.preventDefault();

                component.resetModal();
                component.setModalTitle('Add Album');
                component.showModal();
            });

            // The action was started to open the album modal.
            $('body').on('click', '[data-action=edit_album]', function(event) {
                event.preventDefault();
                let album_id = $(this).data('album-id');

                // Retrieve the album from the server first based on its ID so that it may be edited
                axios.get(app.url('api/albums/' + album_id), {
                    "params": {
                        "include": "",
                    }
                })
                    .then((response) => {
                        // console.log(response);
                        // console.log(response.data);

                        let album_data = response.data.data;

                        component.resetModal();
                        component.setModalId(album_data.id);
                        component.setModalTitle(album_data.title + ' (' + album_data.artist + ', ' + album_data.year + ') - Edit Album');
                        component.setModalData({
                            "title": album_data.title,
                            "artist": album_data.artist,
                            "year": album_data.year,
                            "blurb": album_data.blurb,
                        });
                        component.$albumModal.find('.delete_album_checkbox_container').show();
                        component.showModal();
                    });
            });

            // The action was started to save the album details.
            component.$albumModal.on('submit', 'form', async function(event) {
                event.preventDefault();

                // create the new FormData object, which happens to matter what
                let formData = new FormData(); // FormData object allows an image to be sent

                // Get the ID of the album being edited photo
                let album_id = component.$albumModal.find('input[name=id]').val();

                // If deleting, handle differently:
                let isDeleteCheckboxChecked = component.$albumModal.find('input[name=delete_album_checkbox]').prop('checked');
                if(isDeleteCheckboxChecked) {
                    if(confirm("Really delete this album?")) {
                        await axios({
                            method: 'delete',
                            url: app.url('api/albums/' + album_id),
                            data: formData,
                        })
                            .then((response) => {
                                // console.log(response);
                                // console.log(response.data);

                                $.notify(response.data.message);
                                component.hideModal();
                            })
                            .catch((error) => {
                                console.log('Axios error!');
                                console.log(error);
                            });
                    }
                }
                else {
                    // save as normal

                    // Set data
                    formData.append('title', component.$albumModal.find('input[name=title]').val());
                    formData.append('artist', component.$albumModal.find('input[name=artist]').val());
                    formData.append('year', component.$albumModal.find('input[name=year]').val());
                    formData.append('blurb', component.$albumModal.find('textarea[name=blurb]').val());

                    // Also add the cover file, but only if one is set from the file input
                    let cover_files = component.$albumModal.find('input[name=cover_file]')[0].files;
                    if(cover_files[0]) {
                        formData.append("cover", cover_files[0]);
                    }

                    axios({
                        method: 'post',
                        url: app.url('api/albums' + (album_id.length ? '/' + album_id : '')),
                        data: formData,
                        config: {
                            'headers': {
                                'Content-Type': 'multipart/form-data', // must be multipart/form-data for uploading binary BLOB files (images) to be sent to the server
                            }
                        }
                    })
                        .then((response) => {
                            // console.log(response);
                            // console.log(response.data);

                            $.notify(response.data.message);
                            component.hideModal();
                        })
                        .catch((error) => {
                            console.log('Axios error!');
                            console.log(error);
                        });
                }
            });

            return component;
        },

        /**
         * Initialize the component.
         *
         * @param config
         */
        init: function() {
            let component = this;

            //

            return component;
        },

        /**
         * Reset the modal back to its default state.
         *
         * @returns {*}
         */
        resetModal: function() {
            let component = this;

            component.setModalId('');
            component.setModalTitle('Album Details');
            component.setModalData({
                "title": "",
                "artist": "",
                "year": "",
                "blurb": "",
            });

            // Also hide the checkbox to delete the album. Re-show it manually ONLY if the album is being edited
            component.$albumModal.find('.delete_album_checkbox_container').hide();

            return component;
        },

        /**
         * Set the album ID of the modal
         *
         * @param catalogItemId
         * @returns {*}
         */
        setModalId: function(catalogItemId) {
            let component = this;
            component.$albumModal.find('[name=id]').val(catalogItemId);
            return component;
        },

        /**
         * Set the title of the modal.
         *
         * @returns {*}
         */
        setModalTitle: function(newTitle) {
            let component = this;
            component.$albumModal.find('.modal-title').html(newTitle);
            return component;
        },

        /**
         * Reset the modal.
         *
         * @param newModalData
         * @returns {*}
         */
        setModalData: function(newModalData) {
            let component = this;

            let defaultModalData = {
                "title": "",
                "artist": "",
                "year": "",
                "blurb": "",
            };

            let final_modal_data = {
                ...defaultModalData,
                ...newModalData
            };

            component.$albumModal.find('input[name=title]').val(final_modal_data.title);
            component.$albumModal.find('input[name=artist]').val(final_modal_data.artist);
            component.$albumModal.find('input[name=year]').val(final_modal_data.year);
            component.$albumModal.find('textarea[name=blurb]').val(final_modal_data.blurb);
            component.$albumModal.find('input[name=cover_file_input]').val('');

            return component;
        },

        /**
         * Show the modal
         *
         * @returns {*}
         */
        showModal: function() {
            let component = this;
            component.$albumModal.modal('show');
            return component;
        },

        /**
         * Hide the modal
         *
         * @returns {*}
         */
        hideModal: function() {
            let component = this;
            component.$albumModal.modal('hide');
            return component;
        }

    });
})(window.NicksFuckinAwesomeWebApp, window.jQuery, window.axios);
