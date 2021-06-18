@extends('layouts.app')

@section('pageName', 'admin_quotes')

@section('content')
    <div class="container-fluid">
        <p><a href="{{ route('admin') }}">← Back To Admin</a></p>

        @include('_flash_messages')

        @if($quotes->count())

            <div class="table-responsive">
                <table class="table table-border table-hover">
{{--                    <thead class="thead-dark">--}}
{{--                    <tr>--}}
{{--                        <th>Quote Details</th>--}}
{{--                        <th class="text-right"></th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
                    <tbody>
                    @foreach($quotes as $quote)
                        <tr>
                            <td>
                                <span class="bigger">{{ $quote->quote }}</span>
                                <br/>{!! strlen($quote->author) ? '— ' . $quote->author : '<span class="font-italics text-muted">No Author</span>' !!}
                            </td>
                            <td class="text-right">
                                <button class="btn btn-secondary" data-action="admin_edit_quote" data-id="{{ $quote->id }}"><i class="icon-pencil"></i> Edit Quote</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="alert alert-warning">No quotes could be found.</div>
        @endif

        <button class="btn btn-primary" type="button" data-action="admin_add_quote">Add Quote</button>
    </div>


    <div class="modal fade" id="quote_admin_modal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="#" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Manage Quote</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <input name="id" type="hidden" value=""/>

                        <div class="form-group row">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Quote</span>
                                    </div>
                                    <textarea autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control textarea-code autosize" name="quote" placeholder="Quote" rows="2" style="min-height: 60px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Author</span>
                                    </div>
                                    <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="author" placeholder="Author" type="text" value=""/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <div class="form-check abc-checkbox abc-checkbox-primary">
                                    <input class="form-check-input" id="quote_is_public" name="is_public" type="checkbox">
                                    <label class="form-check-label" for="quote_is_public">
                                        Public
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>{{--
                        --}}<button class="btn btn-primary" type="submit">Save Quote</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
