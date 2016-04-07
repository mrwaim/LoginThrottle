@extends('app')

@section('page-header')
    @include('elements.page-header', ['section_title' => 'Failed login attempts', 'page_title' => 'View All Failed Attempts'])
@endsection


@section('content')
    @include('elements.success-message-partial')
    <div class="panel panel-default">
        @include('login-throttle::partials._list')
    </div>
@endsection
