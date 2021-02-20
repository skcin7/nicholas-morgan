@extends('layouts.app')

@section('pageName', 'alphabetizer')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <fieldset>
                    <legend>Input</legend>

                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize text-monospace" id="alphabetizer_input" name="alphabetizer_input" placeholder="Alphabetizer (Input)" rows="20" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-auto">
                <div class="mb-3">
                    <button class="btn btn-primary w-100" type="button" data-action="process_alphabetization">→ Alphabetize →</button>
                </div>

                <strong><u>Options</u></strong>
                <ul class="list-unstyled smaller mb-3">
                    <li>
                        <div class="form-check abc-checkbox abc-checkbox-primary">
                            <input class="form-check-input" id="ignore_case_option_checkbox" name="options_checkboxes[ignore_case]" type="checkbox" value="yes">
                            <label class="form-check-label" for="ignore_case_option_checkbox">Ignore Case</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check abc-checkbox abc-checkbox-primary">
                            <input class="form-check-input" id="remove_magic_quotes_option_checkbox" name="options_checkboxes[remove_magic_quotes]" type="checkbox" value="yes">
                            <label class="form-check-label" for="remove_magic_quotes_option_checkbox">Replace Magic Quotes<br/>With Regular Quotes</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check abc-checkbox abc-checkbox-primary">
                            <input class="form-check-input" id="uppercase_first_letter_option_checkbox" name="options_checkboxes[uppercase_first_letter]" type="checkbox" value="yes">
                            <label class="form-check-label" for="uppercase_first_letter_option_checkbox">Uppercase First Letter</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check abc-checkbox abc-checkbox-primary">
                            <input class="form-check-input" id="uppercase_all_words_option_checkbox" name="options_checkboxes[uppercase_all_words]" type="checkbox" value="yes">
                            <label class="form-check-label" for="uppercase_all_words_option_checkbox">Uppercase All Words</label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md">
                <fieldset>
                    <legend>Output</legend>

                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize text-monospace" id="alphabetizer_output" name="alphabetizer_output" placeholder="Alphabetizer (Output)" rows="20" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection
