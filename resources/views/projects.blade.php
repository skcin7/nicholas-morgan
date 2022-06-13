@extends('layouts.app')

@section('pageName', 'projects')

@section('content')
    <div class="container-fluid">

        @include('_flash_messages')

        <h1 class="text-center my-0 fst-normal">Projects</h1>
        <p>This page I will use to show some projects that I've been working on.</p>

{{--        <p><a href="https://skcin7.github.io/not_another_bashtools/">https://skcin7.github.io/not_another_bashtools/</a></p>--}}

        @if($projects->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover border_2 box_shadow">
                    <thead class="table-dark">
                        <th>Project</th>
                        <th>Category</th>
                        <th>Details</th>
                    </thead>
                    <tbody>
                    @foreac($projects as $project)
                        <tr>
                            <td>
                                <ul class="list-unstyled">
                                    <li class="biggest">{{ $project->name }}</li>
{{--                                    <li><strong>Category:</strong> {{ $project->category }}</li>--}}
                                    <li><strong>Website:</strong> <a class="hover_up" href="{{ $project->website }}" target="_blank">{{ $project->website }}</a></li>
                                    <li><strong>Details:</strong> {{ $project->details }}</li>
                                </ul>
                            </td>
                            <td>
                                {{ $project->category }}
                            </td>
                            <td>
                                {{ $project->details }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No projects are being shown here.</p>
        @endif


    </div>
@endsection
