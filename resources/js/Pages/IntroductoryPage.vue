<template>
  <div class="container intro-container">
    <h2>Introduction to the Quiz</h2>
    
    <div class="quiz-details">
      <p><strong>Quiz Title:</strong> {{ quizTitle }}</p>
      <p><strong>Number of Questions:</strong> {{ questionsCount }}</p>
    </div>
    
    <div class="button-container">
      <button class="start" @click="startQuiz">Start Quiz</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    quizTitle: String,     // The title of the selected quiz
    questionsCount: Number // The number of questions in the quiz
  },
  methods: {
    startQuiz() {
      this.$emit('start-quiz'); // Emit the event to start the quiz
    }
  }
};
</script>

