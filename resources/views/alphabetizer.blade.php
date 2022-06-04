@extends('layouts.app')

@section('pageName', 'alphabetizer')

@section('process_alphabetization_button')
    <div style="max-width: 190px;">
        <button type="button" class="btn btn-primary w-100 d-flex make_magic_happen_button lh-sm" type="button" data-action="PROCESS_ALPHABETIZATION">
            <div class="col p-0">→</div>
            <div class="col p-0">Alphabetize<br/><span class="make_magic_happen smaller">MAKE MAGIC HAPPEN</span></div>
            <div class="col p-0">→</div>
        </button>
    </div>
@endsection

@section('content')
    <div class="container-fluid">

{{--        <div class="mb-2">--}}
{{--            @yield('process_alphabetization_button')--}}
{{--        </div>--}}

        <h1 class="text-center my-0 fst-normal">Alphabetizer</h1>

        <div class="row mb-3">
            <div class="col-md">
                <fieldset class="fieldset p-3 mb-0" id="input_fieldset">
                    <legend class="bigger px-0">
                        <u>Input</u>

                        <div class="btn-group dropdown">
                            <button id="alphabetizationInputOptionsDropdown" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                                Options
                            </button>
                            <div class="dropdown-menu" aria-labelledby="alphabetizationInputOptionsDropdown">
                                <button class="dropdown-item" type="button" data-action="COPY_ALPHABETIZATION_INPUT"><i class="icon-copy"></i> Copy</button>
                                <button class="dropdown-item" type="button" data-action="CLEAR_ALPHABETIZATION_INPUT"><i class="icon-trash"></i> Clear</button>
                            </div>
                        </div>
                    </legend>

                    <div class="form-group row mb-0">
                        <div class="col">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize shadow-none" id="alphabetizer_input" name="alphabetizer_input" placeholder="Unalphabetized Input..." rows="10" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md">
                <fieldset class="fieldset p-3 mb-0" id="output_fieldset">
                    <legend class="bigger px-0">
                        <u>Output</u>

                        <div class="btn-group dropdown">
                            <button id="alphabetizationOutputOptionsDropdown" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                                Options
                            </button>
                            <div class="dropdown-menu" aria-labelledby="alphabetizationOutputOptionsDropdown">
                                <button class="dropdown-item" type="button" data-action="COPY_ALPHABETIZATION_OUTPUT"><i class="icon-copy"></i> Copy</button>
                                <button class="dropdown-item" type="button" data-action="CLEAR_ALPHABETIZATION_OUTPUT"><i class="icon-trash"></i> Clear</button>
                            </div>
                        </div>
                    </legend>

                    <div class="form-group row mb-0">
                        <div class="col">
{{--                            <div class="input-group">--}}
{{--                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize shadow-none" id="alphabetizer_output" name="alphabetizer_output" placeholder="The alphabetized output will go here." rows="20" spellcheck="false"></textarea>--}}
{{--                            </div>--}}

                            <div id="alphabetizer_output"></div>
{{--                            The alphabetized output will go here.--}}
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row align-items-end mb-0">
            <div class="col-6">
                <div class="btn-group" role="group">
                    @yield('process_alphabetization_button')
                    <button type="button" class="btn btn-secondary" data-action="TOGGLE_ALPHABETIZER_OPTIONS">Options</button>
                </div>

                <fieldset class="fieldset p-2 d-none" id="alphabetization_options_fieldset">
                    <legend class="text-center bigger font-weight-bold"><u>Alphabetizer Options:</u></legend>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="alphabetization_option_IGNORE_CASE" name="alphabetization_options[]" type="checkbox" value="IGNORE_CASE">
                                <label class="form-check-label" for="alphabetization_option_IGNORE_CASE">Ignore Case</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="alphabetization_option_REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES" name="alphabetization_options[]" type="checkbox" value="REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES">
                                <label class="form-check-label" for="alphabetization_option_REPLACE_MAGIC_QUOTES_WITH_STANDARD_QUOTES">Replace Magic Quotes (“/’) With Regular Quotes ("/')</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="alphabetization_option_UPPERCASE_FIRST_LETTER" name="alphabetization_options[]" type="checkbox" value="UPPERCASE_FIRST_LETTER">
                                <label class="form-check-label" for="alphabetization_option_UPPERCASE_FIRST_LETTER">Uppercase First Letter</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="alphabetization_option_UPPERCASE_FIRST_LETTER_OF_EACH_WORD" name="alphabetization_options[]" type="checkbox" value="UPPERCASE_FIRST_LETTER_OF_EACH_WORD">
                                <label class="form-check-label" for="alphabetization_option_UPPERCASE_FIRST_LETTER_OF_EACH_WORD">Uppercase First Letter of Each Word</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="alphabetization_option_STRIP_WHITESPACE" name="alphabetization_options[]" type="checkbox" value="STRIP_WHITESPACE">
                                <label class="form-check-label" for="alphabetization_option_STRIP_WHITESPACE">Strip Whitespace</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="alphabetization_option_REVERSE_ALPHABETIZATION" name="alphabetization_options[]" type="checkbox" value="REVERSE_ALPHABETIZATION">
                                <label class="form-check-label" for="alphabetization_option_REVERSE_ALPHABETIZATION">Reverse Alphabetization</label>
                            </div>
                        </li>
                    </ul>
                </fieldset>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-link" data-action="RESET_ALPHABETIZER">Reset Alphabetizer</button>
            </div>
        </div>


    </div>
@endsection
