<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Quizzes</title>
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
                                <h2>Your Quizzes</h2>

                                <!-- Success message -->
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <!-- Quiz list -->
                                <ul class="list-group mb-4">
                                    @foreach($quizzes as $quiz)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $quiz->title }}</span>
                                            <span>
                                                <a href="{{ route('teacher.show-quiz', $quiz->id) }}" class="btn btn-sm btn-primary">View</a>
                                                <form action="{{ route('teacher.delete-quiz', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Create new quiz button -->
                                <a href="{{ route('teacher.create-quiz') }}" class="btn btn-primary">Create New Quiz</a>
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
