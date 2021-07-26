<div class="modal fade" id="bookmarklet_modal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="#" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Bookmarklet</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <input name="id" type="hidden" value=""/>

                    <div class="form-group row">
                        <div class="col-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text small">Bookmarklet Name</span>
                                </div>
                                <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="name" placeholder="Bookmarklet Name..." type="text"/>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <select class="form-control" name="status">
                                    <option value="">[Select Status]</option>
                                    <option value="ENABLED">ENABLED</option>
                                    <option value="ENABLED_ONLY_FOR_ADMINS">ENABLED_ONLY_FOR_ADMINS</option>
                                    <option value="DISABLED">DISABLED</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <fieldset>
                        <legend>JavaScript Code <button class="btn btn-secondary btn-sm" type="button" data-action="reformat_javascript_code">Format Code</button> <button class="btn btn-secondary btn-sm" type="button" data-action="test_bookmarklet">Test Bookmarklet</button></legend>

                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="input-group">
{{--                                    <div class="input-group-prepend">--}}
{{--                                        <span class="input-group-text small">Code</span>--}}
{{--                                    </div>--}}
                                    <textarea autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control autosize border-0 p-0 textarea_code" name="javascript_code" placeholder="JavaScript Code Goes Here..." rows="30" style="min-height: 570px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group row mb-0">
                        <div class="col">
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="delete_bookmarklet_checkbox" name="delete_bookmarklet" type="checkbox">
                                <label class="form-check-label text-danger" for="delete_bookmarklet_checkbox">
                                    Delete Bookmarklet
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>{{--
                    --}}<button class="btn btn-primary" type="submit">Save Bookmarklet</button>
                </div>
            </form>
        </div>
    </div>
</div>
