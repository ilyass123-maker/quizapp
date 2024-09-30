import { createApp } from 'vue';

// Import the Vue components you want to use
import CreateQuiz from './Pages/CreateQuiz.vue';
import QuizPage from './Pages/QuizPage.vue';

// Create the Vue application instance
const app = createApp({});

// Register the components globally (or you can register them locally in specific views)
app.component('create-quiz', CreateQuiz);
app.component('quiz-page', QuizPage);

// Mount the app to the #app element in the view
app.mount('#app');
