<!-- quiz-details.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Details</title>
    
    <!-- Include Vite for the Vue component -->
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
        <!-- Mount the Vue component and pass the quizId as a prop -->
        <quiz-page :quiz-id="{{ $quizId }}"></quiz-page>
    </div>

    <!-- Include the compiled JavaScript for your Vue app -->
    <script type="module" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
