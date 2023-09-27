<!DOCTYPE html>
<html>
    <head>
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="main-body app sidebar-mini">
        @inertia
        @include('layouts.sidebar')
        @include('layouts.models')
        @include('layouts.footer')
        @include('layouts.footer-scripts')
    </body>
</html>
