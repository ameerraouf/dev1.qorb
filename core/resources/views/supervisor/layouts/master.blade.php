<!DOCTYPE html>
<html lang="{{ @Helper::currentLanguage()->code }}" dir="{{ @Helper::currentLanguage()->direction }}">
<head>
    @include('supervisor.layouts.head')
</head>
<body>
<div class="app" id="app">
    @php( $webmailsNewCount= Helper::webmailsNewCount())
    @include('supervisor.layouts.menu')

    <div id="content" class="app-content box-shadow-z0" role="main">
        @include('supervisor.layouts.header')
        @include('supervisor.layouts.footer')
        <div ui-view class="app-body" id="view">
            @include('supervisor.layouts.errors')
            @yield('content')
        </div>
    </div>

    @include('supervisor.layouts.settings')
</div>
@include('supervisor.layouts.foot')
</body>
</html>
