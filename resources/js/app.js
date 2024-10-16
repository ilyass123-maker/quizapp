import { createApp } from 'vue';

// Import the Vue components you want to use
import CreateQuiz from './Pages/CreateQuiz.vue';
import QuizPage from './Pages/QuizPage.vue';
import AiQuiz from './Pages/AiQuiz.vue'; // Import AiQuiz component
import axios from 'axios';


axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Create the Vue application instance
const app = createApp({});

// Register the components globally
app.component('create-quiz', CreateQuiz);
app.component('quiz-page', QuizPage);
app.component('ai-quiz', AiQuiz); // Register AiQuiz component

// Mount the app to the #app element in the view
app.mount('#app');
