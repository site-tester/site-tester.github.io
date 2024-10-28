<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DisasterEase - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>

    {{-- CSS --}}

    <!-- Scripts -->
    @yield('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/styles.css', 'resources/css/theme.css'])

</head>

<body class="@yield('background-color') ">
    <div id="app">

        @include('layouts.navbar')

        <main class="pb-4">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>



    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>


    <script>
        $(document).ready(function() {

            $(window).scroll(function() {
                var navBarHeight = $('.navbar').outerHeight();
                var scrollTop = $(this).scrollTop()

                if (scrollTop > navBarHeight) {
                    $('#moveUpButton').fadeIn();

                } else {
                    $('#moveUpButton').fadeOut()
                }
            });

            $('#moveUpButton').click(function() {
                $('html,body').animate({
                    scrollTop: 0
                }, 200)
            });

            // $('#smartwizard').smartWizard({
            //     selected: 0,
            //     theme: 'dots',
            //     justified: true,
            //     autoAdjustHeight: true,
            //     backButtonSupport: true,
            //     transition: {
            //         animation: 'fade',
            //         speed: '400',
            //     },
            //     toolbar: {
            //         position: 'bottom', // none|top|bottom|both
            //         showNextButton: true, // show/hide a Next button
            //         showPreviousButton: true, // show/hide a Previous button
            //         // extraHtml: '' // Extra html to show on toolbar
            //     },
            //     anchor: {
            //         enableNavigation: true, // Enable/Disable anchor navigation
            //         enableNavigationAlways: false, // Activates all anchors clickable always
            //         enableDoneState: true, // Add done state on visited steps
            //         markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
            //         unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
            //         enableDoneStateNavigation: true // Enable/Disable the done state navigation
            //     },
            //     keyboard: {
            //         keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            //         keyLeft: [37], // Left key code
            //         keyRight: [39] // Right key code
            //     },
            //     lang: { // Language variables for button
            //         next: 'Next',
            //         previous: 'Previous'
            //     },
            //     // disabledSteps: [], // Array Steps disabled
            //     // errorSteps: [], // Array Steps error
            //     // warningSteps: [], // Array Steps warning
            //     // hiddenSteps: [], // Hidden steps
            //     // getContent: null // Callback function for content loading
            // });
        });
    </script>
    @yield('scripts')
</body>

</html>
