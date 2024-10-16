<template>
    <div class="chat-box">
      <h1>AI ChatBox</h1>
      <div class="input-container">
        <input 
          v-model="prompt" 
          placeholder="Enter your message here" 
          @keydown.enter="generateResponse"
        />
        <button @click="generateResponse">Send</button>
      </div>
  
      <div v-if="loading" class="loading">
        <p>Loading...</p>
      </div>
  
      <div v-if="errorMessage" class="error">
        <p>Error: {{ errorMessage }}</p>
      </div>
  
      <div v-if="response" class="response">
        <p><strong>AI Response:</strong> {{ response }}</p>
      </div>
  
      <div v-if="needsAuthorization" class="authorization">
        <p>Please authorize the application to continue.</p>
        <button @click="authorizeApp">Authorize</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ChatBox',
    data() {
      return {
        prompt: '',
        response: null,
        errorMessage: null,
        loading: false,
        needsAuthorization: false,
      };
    },
    methods: {
      async generateResponse() {
        if (!this.prompt) {
          this.errorMessage = "Prompt cannot be empty!";
          return;
        }
  
        this.loading = true;
        this.response = null;
        this.errorMessage = null;
  
        try {
          const res = await axios.post('/teacher/generate', { prompt: this.prompt });
          this.response = res.data.data || 'No response from AI.';
        } catch (err) {
          if (err.response && err.response.status === 401) {
            // Set flag to show authorization button
            this.needsAuthorization = true;
          } else {
            this.errorMessage = err.response ? err.response.data.error : err.message;
          }
        } finally {
          this.loading = false;
        }
      },
      authorizeApp() {
        // Redirect the browser to the OAuth authorization URL under the 'teacher' prefix
        window.location.href = '/teacher/auth/google';
      },
    },
  };
  </script>
  
  <style scoped>
  .chat-box {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
  }
  
  .input-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  
  input {
    padding: 8px;
    width: 300px;
  }
  
  button {
    padding: 8px 16px;
    margin-left: 10px;
  }
  
  .response, .error, .authorization {
    margin-top: 20px;
  }
  
  .loading {
    margin-top: 10px;
  }
  </style>
  