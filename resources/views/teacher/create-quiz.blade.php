<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <!-- Include your CSS stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @vite('resources/js/app.js') <!-- Include Vite for Vue setup -->
</head>
<body>
    <!-- Main Wrapper -->
    <div id="app" class="main-wrapper">
        <!-- Header -->
        @include('layouts.header') <!-- Include Blade layout for header -->

        <!-- Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        @include('layouts.sidebar') <!-- Include Blade layout for sidebar -->
                    </div>

                    <!-- Main Content -->
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        <div class="settings-widget">
                            <div class="settings-inner-blk p-0">
                                <h2>Create a New Quiz</h2>

                                <!-- Vue component for creating quiz -->
                                <create-quiz></create-quiz>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.footer') <!-- Include Blade layout for footer -->
    </div>
    <!-- /Main Wrapper -->

    <!-- Include any other scripts if needed -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
