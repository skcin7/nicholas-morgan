<div class="modal fade" id="album_modal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="#" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="albumModalLabel">Album Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="id" type="hidden" value=""/>

                    <div class="form-group row">
                        <div class="col-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Title</div>
                                </div>
                                <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="title" placeholder="Title" type="text"/>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group">
                                <button class="btn btn-primary btn_file_container">
                                    <span>Choose Album Cover...</span>
                                    <input accept="image/*" name="cover_file" type="file"/>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Artist</div>
                                </div>
                                <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="artist" placeholder="Artist" type="text"/>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Year</div>
                                </div>
                                <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="year" placeholder="Year" type="text"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Blurb</span>
                                </div>
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control autosize" name="blurb" placeholder="Blurb" rows="2" style="min-height: 60px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0 delete_album_checkbox_container">
                        <div class="col">
                            <div class="form-check abc-checkbox abc-checkbox-danger">
                                <input class="form-check-input" id="delete_album_checkbox" name="delete_album_checkbox" type="checkbox">
                                <label class="form-check-label text-danger" for="delete_album_checkbox">
                                    Delete Album
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><!--
                    --><button type="submit" class="btn btn-primary">Save Album</button>
                </div>
            </form>
        </div>
    </div>
</div>
