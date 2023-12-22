@extends('layouts.app')
@section('content')
    <section>
        <div class="container-fluid">
            <ul class="nav nav-tabs">
                @foreach ($roles as $i => $role)
                    <li class="nav-item">
                        <a class="nav-link role-tab {{ $i == 0 ? "active" : ''}} " aria-current="page" href="#"> {{ $role->name }} </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

@endsection
