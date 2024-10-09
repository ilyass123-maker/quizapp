<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ $quiz->title }}</title>

    <!-- Directly include CSS here -->
    <style>
        /* Add the content of your app.css here */
        body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: rgba(197, 219, 227, 0.993);
}

.top-bar {
  display: flex;
  justify-content: space-between; /* Adjusts the space between the timer and progress bar */
  align-items: center; /* Aligns the timer and progress bar vertically */
  padding: 10px; /* Adjust padding as needed */
}

.progress-bar-container {
  flex-grow: 1; /* Makes the progress bar take up the remaining space */
  margin-left: 20px; /* Adds space between the timer and progress bar */
  margin-right: 20px; /* Adds space on the right to move the progress bar left */
}

.progress-bar {
  width: calc(100% - 20px); /* Adjusts the width to account for the right margin */
  height: 10px; /* Adjust height as needed */
  background-color: #e0e0e0; /* Background color of the progress bar */
  border-radius: 5px; /* Rounds the corners of the progress bar */
  overflow: hidden;
}

.progress {
  height: 100%;
  background-color: #219ebc; /* Color of the progress */
}

.timer-container {
  display: flex;
  align-items: center;
  justify-content: flex-start; /* Align to the left */
  flex-shrink: 0;
}

.timer {
  font-size: 16px;
  font-weight: bold;
  margin-right: 10px;
  text-align: left; /* Align text to the left */
}

.circle-timer {
  width: 40px; /* Adjust size as needed */
  height: 40px; /* Adjust size as needed */
  border-radius: 50%;
  background-color: #f3f3f3; /* Ensures a background for visibility */
  flex-shrink: 0; /* Prevents the timer from shrinking */
}

.container {
  width: 100%;
  max-width: 600px;
  margin: 70px auto 20px auto;
  text-align: center;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.button-container {
  display: flex;
  justify-content: space-between; /* Ensure buttons are aligned */
  margin-top: 20px;
}

button {
  flex: 1;
  margin: 0 5px;
  padding: 15px 20px;
  border: 2px solid #219ebc;
  border-radius: 5px;
  background-color: #219ebc;
  color: white;
  cursor: pointer;
  transition: background-color 0.3s, border-color 0.3s;
  text-align: center;
}

button:hover {
  background-color: #1a7bb9;
}

button:active {
  background-color: #135d8d;
}

.start {
  background-color: #219ebc;
}

.start:hover {
  background-color: #1a7bb9;
}

.start:active {
  background-color: #135d8d;
}

.answer-button {
  width: calc(100% - 20px);
  margin: 10px auto;
  padding: 15px;
  border: 2px solid #ddd;
  background-color: #fff;
  color: #333;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
}

.answer-button:hover {
  background-color: #f9f9f9;
}

.answer-button:active {
  background-color: #e0e0e0;
}

.answer-button.selected {
  background-color: #d0d0d0;
  color: #333;
}

.summary-item {
  margin: 20px 0;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.correct-section {
  background-color: #e0f7fa;
}

.wrong-section {
  background-color: #ffebee;
}

.skipped-section {
  background-color: #ffebee; /* Red for skipped answers */
}

.restart {
  background-color: #219ebc;
  border: 2px solid #219ebc;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, border-color 0.3s;
}

.restart:hover {
  background-color: #1a7bb9;
}

.restart:active {
  background-color: #135d8d;
}

input[type="text"] {
  width: calc(100% - 20px); /* Match the width with other question containers */
  margin: 10px auto;
  padding: 15px;
  border: 2px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
  font-size: 1em;
  box-sizing: border-box;
}

@media (max-width: 600px) {
  .container {
    padding: 10px;
  }

  button {
    padding: 8px 16px;
    margin: 5px 0;
    width: calc(100% - 10px);
  }

  .timer {
    font-size: 14px;
  }
}

.chart-container {
  margin-bottom: 20px; /* Space between chart and text */
  max-width: 400px; /* Adjust as needed */
  margin-left: auto;
  margin-right: auto;
}
    </style>

    <!-- Include necessary CSS and JS files -->
    @vite('resources/js/app.js')
</head>
<body>

<div id="app">
    <!-- Mount the Vue component and pass the quizId as a prop -->
    <quiz-page :quiz-id="{{ $quizId }}"></quiz-page>
</div>

<!-- Include necessary JavaScript -->
</body>
</html>
