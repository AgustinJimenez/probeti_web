<!DOCTYPE html>
<html>
<head>
    <base src="{{ URL::asset('/') }}" />
    <meta charset="UTF-8">
    <title>
        @section('title')
        {{ Setting::get('core::site-name') }} | Admin
        @show
    </title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    @foreach($cssFiles as $css)
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset($css) }}">
    @endforeach
    {!! Theme::script('vendor/jquery/jquery.min.js') !!}
    @include('partials.asgard-globals')
    @section('styles')
    @show

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="{{ config('asgard.core.core.skin', 'skin-blue') }}" style="padding-bottom: 0 !important;">
<div class="wrapper">
    <header class="main-header">
        <a href="{{ URL::route('dashboard.index') }}" class="logo" style="background-color: #34455c;">
            <?php if (isset($sitename)): ?>
            {{ $sitename }}<img 
        src="data:image/png;base64,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"
        name="Imagen2"
        align="left"
        width="230"
        height="35"
        border="0"
        style="margin-left: -12px; margin-top: 8px;"
    />
            <?php endif; ?>
        </a>
        @include('partials.top-nav')
    </header>
    @include('partials.sidebar-nav')

    <aside class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('content-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @include('flash::message')
            <script type="text/javascript">
                $('input').each(function()
                {
                    $(this).attr('autocomplete', 'off');
                });
                //fix_sidebar_actives();

                function fix_sidebar_actives()
                {
                    var current_url = window.location.href;

                    $('ul.treeview-menu li.active').removeClass('active');

                    $("li.active.treeview.clearfix").removeClass('active');

                    $('li.clearfix a[href="'+current_url+'"').parent('li').addClass("active").parent('ul').parent('li').addClass("active");
                };
            </script>
            @yield('content')
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
    @include('partials.footer')
    @include('partials.right-sidebar')
</div><!-- ./wrapper -->

@foreach($jsFiles as $js)
    <script src="{{ URL::asset($js) }}" type="text/javascript"></script>
@endforeach
<?php if (is_module_enabled('Notification')): ?>
    <script src="https://js.pusher.com/3.0/pusher.min.js"></script>
    <script src="{{ Module::asset('notification:js/pusherNotifications.js') }}"></script>
    <script>
        $(".notifications-list").pusherNotifications({
            pusherKey: '{{ env('PUSHER_KEY') }}',
            loggedInUserId: {{ $currentUser->id }}
        });
    </script>
<?php endif; ?>

@section('scripts')
@show
</body>
</html>
