<template>
  <div>
    <h2>Create a Quiz Using ChatGPT</h2>
    <input v-model="topic" placeholder="Enter quiz topic">
    <button @click="fetchQuiz">Generate Quiz</button>

    <div v-if="quiz.length">
      <h3>Generated Quiz</h3>
      <div v-for="(question, index) in quiz" :key="index">
        <p><strong>Question {{ index + 1 }}: {{ question.question }}</strong></p>
        <ul>
          <li v-for="(option, idx) in question.options" :key="idx">{{ option }}</li>
        </ul>
      </div>
    </div>

    <div v-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      topic: '', // Topic for generating quiz
      quiz: [], // Array to store generated quiz questions
      error: '' // Error message to display
    };
  },
  methods: {
    // Method to fetch quiz from backend using Axios
    fetchQuiz() {
      // Ensure CSRF token is included in the headers
      axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Make the POST request to the backend
      axios.post('/generate-quiz', { topic: this.topic })
        .then(response => {
          // Handle the response and store the quiz data
          this.quiz = response.data;
          this.error = ''; // Clear any previous error messages
        })
        .catch(error => {
          // Handle any errors and set an error message
          console.error("Error generating quiz:", error);
          this.error = 'Failed to generate quiz. Please try again.';
        });
    }
  }
};
</script>

<style scoped>
/* Optional: Add any specific styles here */
.error-message {
  color: red;
  margin-top: 10px;
}
</style>
