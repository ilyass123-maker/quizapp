<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Available Quizzes</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.svg') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        /* Sidebar adjustments */
        .theiaStickySidebar {
            width: 22%;
            float: left;
        }

        /* Adjust the quiz table to fit next to the sidebar */
        .quiz-container {
            width: 75%;
            float: right;
        }

        .quiz-table {
            width: 100%;
            margin: 0 auto;
        }

        .quiz-table table {
            width: 100%;
            table-layout: auto;
        }

        /* Reduce button and table element sizes */
        .quiz-table .btn {
            padding: 5px 12px;
            font-size: 12px;
        }

        .quiz-table th, .quiz-table td {
            padding: 8px;
            font-size: 14px;
        }

        /* Responsive for smaller screens */
        @media (max-width: 992px) {
            .theiaStickySidebar {
                width: 100%;
                margin-bottom: 20px;
                float: none;
            }
            .quiz-container {
                width: 100%;
                float: none;
            }
        }
    </style>
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Include Header -->
    @include('layouts.header')

    <div class="container">
        <div class="row">
            
            <!-- Sidebar on the left -->
            @include('layouts.sidebar')

            <!-- Adjusted Quiz Table Container on the right -->
            <div class="quiz-container">
                <div class="settings-widget dash-profile">
                    <div class="settings-menu p-4">
                        <h3>Available Quizzes</h3>
                        <p>Below is a list of quizzes you can take. Click "Start Quiz" to begin.</p>

                        <!-- Quiz Table -->
                        <div class="table-responsive quiz-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Quiz Title</th>
                                        <th>Questions</th>
                                        <th>Time Limit (mins)</th> <!-- Added Time Limit Column -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Loop through quizzes -->
                                    @foreach($quizzes as $quiz)
                                    <tr>
                                        <td>{{ $quiz->title }}</td>
                                        <td>{{ $quiz->questions_count }}</td> <!-- Display number of questions -->
                                        <td>{{ $quiz->time_limit ?? 'N/A' }}</td> <!-- Display time limit -->
                                        <td>
                                            <!-- Link to detail quiz page -->
                                            <a href="{{ route('quiz.details', ['id' => $quiz->id]) }}" class="btn btn-primary">Start Quiz</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /Quiz Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')

</div>
<!-- /Main Wrapper -->

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
