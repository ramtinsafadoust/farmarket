@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav0pills card-headers-pills">
                            <li class="nav-item " >

                                <a class="nav-link {{request()->is('profile') ? 'active' : '' }}  " href="{{route('profile')}}">index</a>

                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{request()->is('profile/twofactor') ? 'active' : '' }} " href="{{route('profile.2fa.manage')}}">TwoFactroAuth</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">

                        @yield('main')

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
