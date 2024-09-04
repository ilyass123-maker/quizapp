<template>
  <div class="container">
    <h2>Summary</h2>
    <div v-for="(question, index) in questions" :key="index" class="summary-item"
         :class="{
           'correct-section': isCorrect(index),
           'wrong-section': isWrong(index),
           'skipped-section': isSkipped(index)
         }">
      <p><strong>Question {{ index + 1 }}:</strong> {{ question.text }}</p>
      <p><strong>Your Answer:</strong> 
        <span :class="{
          'correct-answer': isCorrect(index),
          'wrong-answer': isWrong(index),
          'skipped-answer': isSkipped(index)
        }">
          <span v-if="isSkipped(index)">
            Skipped
          </span>
          <span v-else-if="question.type === 'multi-choice'">
            <span v-for="(answer, idx) in (userAnswers[index] || [])" :key="idx">{{ answer }}<span v-if="idx < (userAnswers[index] || []).length - 1">, </span></span>
          </span>
          <span v-else>
            {{ userAnswers[index] || 'Skipped' }}
          </span>
        </span>
      </p>
      <p><strong>Correct Answer:</strong> 
        <span v-if="question.type === 'multi-choice'">
          <span v-for="(answer, idx) in question.answers.filter(a => a.correct)" :key="idx">{{ answer.text }}<span v-if="idx < question.answers.filter(a => a.correct).length - 1">, </span></span>
        </span>
        <span v-else>
          {{ question.correct }}
        </span>
      </p>
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
    isCorrect(index) {
      const question = this.questions[index];
      const userAnswer = this.userAnswers[index];

      if (!question || userAnswer === null || userAnswer === undefined) return false;

      if (question.type === 'multi-choice') {
        const userAnswerSet = new Set((userAnswer || []).map(a => a.toLowerCase()));
        const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
        return correctAnswerSet.size === userAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans));
      }
      return userAnswer && userAnswer.toLowerCase() === question.correct.toLowerCase();
    },
    isWrong(index) {
      const question = this.questions[index];
      const userAnswer = this.userAnswers[index];

      if (!question || userAnswer === null || userAnswer === undefined) return false;

      if (question.type === 'multi-choice') {
        const userAnswerSet = new Set((userAnswer || []).map(a => a.toLowerCase()));
        const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
        return !(correctAnswerSet.size === userAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans)));
      }
      return userAnswer && userAnswer.toLowerCase() !== question.correct.toLowerCase();
    },
    isSkipped(index) {
      const userAnswer = this.userAnswers[index];
      const question = this.questions[index];
      if (question.type === 'multi-choice') {
        return !userAnswer || userAnswer.length === 0;
      }
      return userAnswer === null || userAnswer === '';
    },
    restartQuiz() {
      this.$emit('restart');
    }
  }
};
</script>