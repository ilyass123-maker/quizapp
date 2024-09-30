<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Dashboard</title>

    <!-- Include your CSS files -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"> <!-- Assuming your main CSS file is app.css -->
</head>
<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        @include('layouts.header') <!-- This will include your header -->

        <!-- Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        @include('layouts.sidebar') <!-- This will include your sidebar -->
                    </div>

                    <!-- Main Content -->
                    <div class="col-xl-9 col-lg-8 col-md-12">
                        <div class="settings-widget">
                            <div class="settings-inner-blk p-0 text-center"> <!-- Text center added here -->
                                <h2 class="mb-4">Teacher Dashboard</h2>

                                <div class="buttons mb-4">
                                    <!-- Button to create a new quiz -->
                                    <a href="{{ route('teacher.create-quiz') }}" class="btn btn-primary mb-2">Create New Quiz</a>

                                    <!-- Button to view teacher's quizzes -->
                                    <a href="{{ route('teacher.view-quizzes') }}" class="btn btn-secondary mb-2">View My Quizzes</a>
                                </div>

                                <!-- Additional teacher-specific data/content can be added here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer -->
        @include('layouts.footer') <!-- This will include your footer -->
    </div>
    <!-- /Main Wrapper -->

    <!-- JS Scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script> <!-- Assuming your main JS file is app.js -->

</body>
</html>
