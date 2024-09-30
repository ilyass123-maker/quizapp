<template>
  <div class="container summary-container">
    <h2>Quiz Summary</h2>

    <div v-for="(question, index) in questions" :key="index" class="summary-item">
      <p><strong>Question {{ index + 1 }}:</strong> {{ question.text }}</p>

      <div :class="{'correct-section': isCorrect(question, index), 'wrong-section': !isCorrect(question, index)}">
        <p>Your Answer: 
          <span v-if="question.type === 'multi-choice'">
            <span v-for="answer in userAnswers[index]" :key="answer">
              {{ answer }}
            </span>
          </span>
          <span v-else>
            {{ userAnswers[index] }}
          </span>
        </p>

        <p>Correct Answer: 
          <span v-if="question.type === 'multi-choice'">
            <span v-for="answer in parseAnswers(question).filter(a => a.correct)" :key="answer.text">
              {{ answer.text }}
            </span>
          </span>
          <span v-else>
            {{ question.correct }}
          </span>
        </p>
      </div>
    </div>

    <div class="button-container">
      <button class="restart" @click="restartQuiz">Restart Quiz</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['questions', 'userAnswers'],
  methods: {
    // Utility method to parse the answers field
    parseAnswers(question) {
      try {
        return JSON.parse(question.answers);  // Ensure it's parsed as an array
      } catch (e) {
        console.error('Failed to parse answers:', e);
        return [];  // Fallback to an empty array in case of an error
      }
    },
    
    isCorrect(question, index) {
      const userAnswer = this.userAnswers[index];

      if (!userAnswer || !question.correct) return false;

      // Handle multi-choice question
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
      // Handle single-choice or typing question
      else if (typeof question.correct === 'string' && typeof userAnswer === 'string') {
        return userAnswer.toLowerCase() === question.correct.toLowerCase();
      }

      return false;
    },

    restartQuiz() {
      this.$emit('restart');
    }
  }
};
</script>
