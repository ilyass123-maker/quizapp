<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Quiz Generator</title>
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
</head>
<body>
    <div class="container">
        <div id="app">
            <h1>AI Quiz Generator</h1>
            <div class="input-container">
                <!-- Input for quiz title -->
                <input v-model="title" placeholder="Enter quiz title (e.g., Physics Quiz)" />

                <!-- Input for subject -->
                <input v-model="subject" placeholder="Enter subject (e.g., Physics, Math)" />

                <!-- Input for time limit -->
                <input type="number" v-model="timeLimit" placeholder="Enter time limit in minutes" />

                <!-- Input for number of questions -->
                <input type="number" v-model="numQuestions" placeholder="Enter number of questions" />

                <!-- Button to trigger content generation -->
                <button @click="generateQuiz">Generate Quiz</button>
            </div>

            <!-- Loading, Error, and Response Messages -->
            <div v-if="loading" class="loading">
                <p>Loading...</p>
            </div>

            <div v-if="errorMessage" class="error">
                <p>Error: @{{ errorMessage }}</p>
            </div>

            <div v-if="quiz.length" class="response">
                <h2>Generated Quiz</h2>
                <div v-for="(question, index) in quiz" :key="index">
                    <p><strong>Question @{{ index + 1 }}:</strong> @{{ question.text || 'Question not found' }}</p> <!-- Handle missing question text -->
                    <p><strong>Answers:</strong> @{{ question.answers.join(', ') }}</p>
                    <p><strong>Correct Answer:</strong> @{{ question.correct || 'Correct answer not found' }}</p>
                    <hr>
                </div>
            </div>

            <!-- Button to save the quiz to the backend -->
            <button @click="saveQuiz" v-if="quiz.length">Save Quiz</button>
        </div>
    </div>

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
        numQuestions: 1, // Number of questions to generate
        quiz: [], // To store generated questions
        errorMessage: null,
        loading: false
    },
    methods: {
        async generateQuiz() {
            // Basic validation
            if (!this.title || !this.subject || this.numQuestions < 1) {
                this.errorMessage = "Please fill all fields correctly!";
                return;
            }

            // Reset state
            this.loading = true;
            this.quiz = [];
            this.errorMessage = null;

            const apiKey = 'AIzaSyAdJXBzCx0bZsG7dFRYotjZsZK-fsfq3Xc'; // Replace with your actual API key
            const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`;

            try {
                // Loop to generate multiple questions
                for (let i = 0; i < this.numQuestions; i++) {
                    const data = {
                        contents: [
                            {
                                parts: [
                                    {
                                        text: `Please generate a question related to the subject: ${this.subject}.
                                            Include 4 answer options labeled a, b, c, and d.
                                            Ensure that the correct answer is one of the four options.
                                            Return the information in the following format:

**Question:**
Write the question here.

**Options:**
a) Option A
b) Option B
c) Option C
d) Option D

**Correct Answer:**
Place the correct answer here (just the answer, no explanation).`
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

                        // Extract the question text from the line after the **Question:** marker
                        const questionIndex = lines.findIndex(line => line.includes("**Question:**"));
                        const questionText = (questionIndex !== -1 && lines[questionIndex + 1]) ? lines[questionIndex + 1].trim() : '';

                        // Extract the options (lines starting with "a)", "b)", "c)", "d)")
                        const answerOptions = lines.filter(line => line.startsWith("a)") || line.startsWith("b)") || line.startsWith("c)") || line.startsWith("d)"))
                            .map(line => line.slice(3).trim()); // Remove "a)", "b)", etc.

                        // Extract the correct answer from two lines after the **Correct Answer:** marker
                        const correctAnswerIndex = lines.findIndex(line => line.includes("**Correct Answer:**"));
                        const correctAnswer = (correctAnswerIndex !== -1 && lines[correctAnswerIndex + 2]) ? lines[correctAnswerIndex + 2].trim() : '';

                        // Ensure the correct answer matches one of the provided options
                        const validCorrectAnswer = answerOptions.find(option => option.includes(correctAnswer)) || '';

                        // Push the formatted question into the quiz array
                        this.quiz.push({
                            text: questionText,
                            answers: answerOptions,
                            correct: validCorrectAnswer
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
        // Save the generated quiz to the backend
// Save the generated quiz to the backend
// Save the generated quiz to the backend
// Save the generated quiz to the backend
async saveQuiz() {
    try {
        const formattedQuiz = this.quiz.map(question => ({
            text: question.text,
            answers: question.answers, // Send as an array, not a JSON string
            correct: question.correct
        }));

        // Send the quiz data to the backend as plain JSON
        const response = await axios.post('/save-quiz', {
            title: this.title,
            subject: this.subject,
            time_limit: this.timeLimit,
            number_of_questions: this.numQuestions,
            questions: formattedQuiz
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
