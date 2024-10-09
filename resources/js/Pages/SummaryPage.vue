<template>
  <div class="container summary-container">
    <h2>Quiz Summary</h2>

    <div v-for="(question, index) in questions" :key="index" class="summary-item"
         :class="{
           'correct-section': isCorrect(question, index),
           'wrong-section': !isCorrect(question, index) && !isSkipped(index),
           'skipped-section': isSkipped(index)
         }">
      <!-- Question -->
      <p><strong>Question {{ index + 1 }}:</strong> {{ question.text }}</p>

      <!-- User's Answer -->
      <p><strong>Your Answer:</strong> 
        <span v-if="question.type === 'multi-choice'">
          <span v-for="(answer, ansIndex) in userAnswers[index]" :key="ansIndex">
            {{ answer }}<span v-if="ansIndex < userAnswers[index].length - 1">, </span>
          </span>
        </span>
        <span v-else>
          {{ userAnswers[index] || 'Skipped' }}
        </span>
      </p>

      <!-- Correct Answer -->
      <p><strong>Correct Answer:</strong> 
        <span v-if="question.type === 'multi-choice'">
          <span v-for="(answer, ansIndex) in correctAnswersForMultiChoice(question)" :key="ansIndex">
            {{ answer }}<span v-if="ansIndex < correctAnswersForMultiChoice(question).length - 1">, </span>
          </span>
        </span>
        <span v-else>
          {{ question.correct }}
        </span>
      </p>
    </div>

    <!-- Restart Button -->
    <div class="button-container">
      <button class="restart" @click="restartQuiz">Restart Quiz</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['questions', 'userAnswers'],
  methods: {
    parseAnswers(question) {
      if (Array.isArray(question.answers)) {
        return question.answers;  // Already an array
      }
      try {
        return JSON.parse(question.answers);  // Parse if it's a JSON string
      } catch (e) {
        console.error('Failed to parse answers:', e);
        return [];  // Fallback to an empty array
      }
    },

    correctAnswersForMultiChoice(question) {
      return this.parseAnswers(question).filter(a => a.correct).map(a => a.text);
    },
    
    isCorrect(question, index) {
      const userAnswer = this.userAnswers[index];

      if (!userAnswer || !question.correct) return false;

      if (question.type === 'multi-choice') {
        const userAnswerSet = new Set(userAnswer.map(a => a.toLowerCase()));
        const correctAnswerSet = new Set(
          this.parseAnswers(question).filter(a => a.correct).map(a => a.text.toLowerCase())
        );
        return (
          userAnswerSet.size === correctAnswerSet.size &&
          [...userAnswerSet].every(ans => correctAnswerSet.has(ans))
        );
      }
      return userAnswer && userAnswer.toLowerCase() === question.correct.toLowerCase();
    },

    isSkipped(index) {
      const userAnswer = this.userAnswers[index];
      return !userAnswer || (Array.isArray(userAnswer) && userAnswer.length === 0);
    },

    restartQuiz() {
      this.$emit('restart');
    }
  }
};
</script>
