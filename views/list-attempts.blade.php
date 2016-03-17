@extends('app')

@section('page-header')
    <h2>Failed login attempts</h2>

    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Failed Login Attempts</span></li>
            <li><span>View All Failed Attempts</span></li>
        </ol>

        <div class="sidebar-right-toggle"></div>
    </div>
@endsection


@section('content')
    <div class="panel panel-default">
        @include('login-throttle::partials._list')
    </div>
@endsection
