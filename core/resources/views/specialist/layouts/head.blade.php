<meta charset="utf-8" />
<title>@yield('title')</title>
<meta name="description" content="{{ Helper::GeneralSiteSettings('site_desc_' . @Helper::currentLanguage()->code) }}" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
<link rel="apple-touch-icon" href="{{ asset('assets/dashboard/images/logo.png') }}">
<meta name="apple-mobile-web-app-title" content="Smartend">
<base href="{{ route('adminHome') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" sizes="196x196" href="{{ asset('assets/dashboard/images/logo.png') }}">
@stack('before-styles')
<link rel="stylesheet"
    href="{{ asset('assets/dashboard/css/animate.css/animate.min.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet"
    href="{{ asset('assets/dashboard/css/animate.css/animate.min.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet"
    href="{{ asset('assets/dashboard/fonts/glyphicons/glyphicons.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet"
    href="{{ asset('assets/dashboard/fonts/font-awesome/css/font-awesome.min.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet"
    href="{{ asset('assets/dashboard/fonts/material-design-icons/material-design-icons.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/dashboard/js/sweetalert/sweetalert.css') }}">

<link rel="stylesheet"
    href="{{ asset('assets/dashboard/css/bootstrap/dist/css/bootstrap.min.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/app.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/font.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/dashboard/css/topic.css') }}?v={{ Helper::system_version() }}"
    type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script type="text/javascript">
    toastr.options.timeOut = 5000;
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('58f64b993fbe1bb0f3c5', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('qorb-channel');
    channel.bind('children-created', function(data) {
        console.log(data.message[0]);
        toastr.success(data.message[0]);
    });
</script>

<script type="text/javascript">
    toastr.options.timeOut = 5000;
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('58f64b993fbe1bb0f3c5', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('qorb-channel');
    channel.bind('children-vbmap-created', function(data) {
        if (data.data[1] == {{ auth()->user()->id }}) {

            // alert(data.data[1])
            toastr.success(data.data[0]);
        }
    });
</script>

<script type="text/javascript">
    toastr.options.timeOut = 5000;
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher('58f64b993fbe1bb0f3c5', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('qorb-channel');
    channel.bind('children-consulting-created', function(data) {
        if (data.data[1] == {{ auth()->user()->id }}) {
            toastr.success(data.data[0]);
        }
    });
</script>

<script type="text/javascript">
    toastr.options.timeOut = 5000;
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher('58f64b993fbe1bb0f3c5', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('qorb-channel');
    channel.bind('children-treatment-plan', function(data) {
        if (data.data[1] == {{ auth()->user()->id }}) {
            toastr.success(data.data[0]);
        }
    });
</script>

<script type="text/javascript">
    toastr.options.timeOut = 5000;
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher('58f64b993fbe1bb0f3c5', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('qorb-channel');
    channel.bind('children-final-report', function(data) {
        if (data.data[1] == {{ auth()->user()->id }}) {
            toastr.success(data.data[0]);
        }
    });
</script>

@if (@Helper::currentLanguage()->direction == 'rtl')
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/css/bootstrap-rtl/dist/bootstrap-rtl.css') }}?v={{ Helper::system_version() }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/app.rtl.css') }}?v={{ Helper::system_version() }}">
@endif
@stack('after-styles')
