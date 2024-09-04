<template>
  <div class="container intro-container">
      <h2>Welcome to the Math Test!</h2>
      <p>There is only 1 correct answer per question.</p>
      <p>You have 7 minutes to complete the test.</p>
      <div class="button-container">
          <button class="start" @click="startQuiz">Start Quiz</button>
      </div>
  </div>
</template>

<script>
export default {
  methods: {
    startQuiz() {
      this.$emit('start-quiz');
    }
  }
};
</script>
