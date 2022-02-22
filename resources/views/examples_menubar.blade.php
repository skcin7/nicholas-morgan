@extends('layouts.app')

@section('pageName', 'examples_menubar')

@section('content')
    <nav class="navbar navbar-expand navbar-light bg-light mb-3 p-0 border-bottom" style="flex-basis: auto;
    flex-grow: 0;
    flex-shrink: 1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Menubar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Format
                        </a>
                        <ul class="dropdown-menu mt-0" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><i class="icon-check"></i> TXT</a></li>
                            <li><a class="dropdown-item" href="#"><i class="icon-check-empty"></i> MD</a></li>
                            <li><a class="dropdown-item" href="#"><i class="icon-check-empty"></i> HTML</a></li>
                            <li class="dropdown dropend">
                                <a class="dropdown-item dropdown-toggle dropdown-submenu" href="#" id="multilevelDropdownMenu1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Multilevel Action 1</a>
                                <ul class="dropdown-menu" style="left: 100%; top: 0;" aria-labelledby="multilevelDropdownMenu1">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li class="dropdown dropend">
                                        <a class="dropdown-item dropdown-toggle dropdown-submenu" href="#" id="multilevelDropdownMenu1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Multilevel Action 2</a>
                                        <ul class="dropdown-menu" style="left: 100%; top: 0;" aria-labelledby="multilevelDropdownMenu2">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><i class="icon-trash"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><i class="icon-info"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link">hi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid pb-3" style="flex-grow: 1;
    flex-shrink: 1;
    flex-basis: auto; display: flex;
    flex-flow: column;">
        <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control p-2 autosize" id="writingBody" name="writingBody" placeholder="" spellcheck="false" style="flex-grow: 1;
    flex-shrink: 1;
    flex-basis: auto;"></textarea>
    </div>
@endsection
