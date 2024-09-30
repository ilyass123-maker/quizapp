<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <!-- Include your CSS stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @vite('resources/js/app.js') <!-- Include Vite for Vue setup -->
</head>
<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Sidebar -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>

            <!-- Main content area -->
            <div class="col-md-9">
                <div id="app">
                    <!-- Mount the CreateQuiz Vue component here -->
                    <create-quiz></create-quiz>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Include any other scripts if needed -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
