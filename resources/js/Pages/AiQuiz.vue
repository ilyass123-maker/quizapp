<template>
  <div>
    <h1>Enter a Topic for AI to Generate a Quiz</h1>

    <!-- Input field for entering the topic -->
    <input v-model="prompt" placeholder="Enter topic..." />

    <!-- Button to trigger the API call -->
    <button @click="generateQuestion">Generate Question</button>

    <!-- Show loading indicator when waiting for the response -->
    <div v-if="loading">Generating question, please wait...</div>

    <!-- Show the generated question -->
    <div v-if="response">
      <h2>Generated Question:</h2>
      <p>{{ response }}</p>
    </div>

    <!-- Show any error messages -->
    <div v-if="error" class="error">
      <p>Error: {{ error }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'; // Make sure axios is installed and imported

export default {
  data() {
    return {
      prompt: '', // To store the prompt entered by the user
      response: '', // To store the generated question response
      error: null, // To handle errors
      loading: false // To handle the loading state
    };
  },
  methods: {
    // Method to generate the quiz based on the entered prompt
    generateQuestion() {
      this.loading = true;
      this.error = null;
      this.response = '';

      // Post the prompt to your backend and handle the response
      axios.post('/generate', { prompt: this.prompt })
        .then(response => {
          this.response = response.data.data; // Assuming response contains 'data' with the generated content
          this.loading = false;
        })
        .catch(error => {
          this.error = error.response ? error.response.data.error : error.message;
          this.loading = false;
        });
    }
  }
};
</script>

<style scoped>
.error {
  color: red;
  font-weight: bold;
}

button {
  margin-top: 10px;
  padding: 10px;
  background-color: orange;
  color: white;
  border: none;
  border-radius: 5px;
}

button:hover {
  background-color: darkorange;
}
</style>
