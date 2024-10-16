<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Quiz Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .input-container {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }
        .input-container input, .input-container button {
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .loading, .error, .response {
            margin-top: 20px;
        }
    </style>
    <!-- Include your CSS stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
                            <div class="settings-inner-blk p-3">
                                <h2>AI Quiz Generator</h2>

                                <div class="input-container">
                                    <!-- Input for quiz title -->
                                    <input v-model="title" placeholder="Enter quiz title (e.g., Physics Quiz)" class="form-control mb-3" />

                                    <!-- Input for subject -->
                                    <input v-model="subject" placeholder="Enter subject (e.g., Physics, Math)" class="form-control mb-3" />

                                    <!-- Input for time limit -->
                                    <input type="number" v-model="timeLimit" placeholder="Enter time limit in minutes" class="form-control mb-3" />

                                    <!-- Input for number of questions -->
                                    <input type="number" v-model="numQuestions" placeholder="Enter number of questions" class="form-control mb-3" />

                                    <!-- Button to trigger content generation -->
                                    <button @click="generateQuiz" class="btn btn-primary">Generate Quiz</button>
                                </div>

                                <!-- Loading, Error, and Response Messages -->
                                <div v-if="loading" class="loading mt-3">
                                    <p>Loading...</p>
                                </div>

                                <div v-if="errorMessage" class="alert alert-danger mt-3">
                                    <p>Error: @{{ errorMessage }}</p>
                                </div>

                                <div v-if="quiz.length" class="response mt-4">
                                    <h3>Generated Quiz</h3>
                                    <div v-for="(question, index) in quiz" :key="index">
                                        <p><strong>Question @{{ index + 1 }}:</strong> @{{ question.text }}</p>
                                        <p><strong>Answers:</strong> @{{ question.answers }}</p>
                                        <p><strong>Correct Answer:</strong> @{{ question.correct }}</p>
                                        <hr>
                                    </div>
                                </div>

                                <!-- Button to save the quiz to the backend -->
                                <button @click="saveQuiz" v-if="quiz.length" class="btn btn-success mt-3">Save Quiz</button>
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

    <!-- Include Vue.js and Axios from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Vue.js Instance -->
    <script>
        new Vue({
            el: '#app',
            data: {
                title: '', // Title of the quiz
                subject: '',
                timeLimit: null, // Time limit of the quiz
                numQuestions: 1,
                quiz: [], // To store generated questions
                errorMessage: null,
                loading: false
            },
            methods: {
                async generateQuiz() {
                    if (!this.title) {
                        this.errorMessage = "Please enter a title!";
                        return;
                    }

                    if (!this.subject) {
                        this.errorMessage = "Please enter a subject!";
                        return;
                    }

                    if (this.numQuestions < 1) {
                        this.errorMessage = "Number of questions must be at least 1!";
                        return;
                    }

                    this.loading = true;
                    this.quiz = [];
                    this.errorMessage = null;

                    const apiKey = 'AIzaSyAdJXBzCx0bZsG7dFRYotjZsZK-fsfq3Xc';  // Replace with your actual API key
                    const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`;

                    try {
                        for (let i = 0; i < this.numQuestions; i++) {
                            const data = {
                                contents: [
                                    {
                                        parts: [
                                            {
                                                text: `Create a question about ${this.subject}. You can choose the type of question (e.g., multiple choice, single choice, typing) and provide answers. Format the response like this: \n\n 1. Question text: \n 2. Type: \n 3. Answer options: Provide appropriate options in a list format \n 4. Correct answer: Indicate the correct option(s).`
                                            }
                                        ]
                                    }
                                ]
                            };

                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(data)
                            });

                            const result = await res.json();

                            if (res.ok && result.candidates && result.candidates.length > 0) {
                                const generatedContent = result.candidates[0].content.parts[0].text;

                                const lines = generatedContent.split("\n");
                                const questionText = lines[0].replace("1. Question text: ", "");
                                const answers = lines[2].replace("3. Answer options: ", "");
                                const correctAnswer = lines[3].replace("4. Correct answer: ", "");

                                this.quiz.push({
                                    text: questionText,
                                    answers: answers,
                                    correct: correctAnswer
                                });
                            } else {
                                this.errorMessage = 'Failed to generate one or more questions. Please try again.';
                                break;
                            }
                        }
                    } catch (err) {
                        this.errorMessage = 'Error: ' + err.message;
                    } finally {
                        this.loading = false;
                    }
                },

                // Save the generated quiz to the backend
                async saveQuiz() {
                    try {
                        const response = await axios.post('/save-quiz', {
                            title: this.title,
                            subject: this.subject,
                            time_limit: this.timeLimit,
                            number_of_questions: this.numQuestions,
                            questions: this.quiz
                        });

                        if (response.status === 201) {
                            alert('Quiz saved successfully!');
                        } else {
                            this.errorMessage = 'Failed to save the quiz.';
                        }
                    } catch (error) {
                        this.errorMessage = 'Error saving the quiz: ' + error.message;
                    }
                }
            }
        });
    </script>
</body>
</html>
