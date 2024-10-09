<template>
  <div class="container">
    <h2>Question {{ index + 1 }}</h2>
    <p>{{ question.text }}</p>

    <!-- Single-choice question type -->
    <div v-if="question.type === 'single-choice'">
      <div v-for="(answer, idx) in parsedAnswers" :key="idx">
        <button
          class="answer-button"
          @click="selectAnswer(answer)"
          :class="{ 'selected': userAnswer === answer }">
          {{ answer }}
        </button>
      </div>
    </div>

    <!-- Multi-choice question type -->
    <div v-else-if="question.type === 'multi-choice'">
      <div v-for="(answer, idx) in parsedAnswers" :key="idx">
        <button
          class="answer-button"
          :class="{ 'selected': userAnswer.includes(answer.text) }"
          @click="toggleAnswer(answer.text)">
          {{ answer.text }} <!-- Display only the answer text -->
        </button>
      </div>
    </div>

    <!-- Typing question type -->
    <div v-else-if="question.type === 'typing'">
      <input
        type="text"
        v-model="userAnswer"
        placeholder="Type your answer here"
      />
    </div>

    <div class="button-container">
      <button class="skip" @click="skipQuestion">Skip</button>
      <button class="next" @click="validateAnswer">Next</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['index', 'question', 'userAnswers'],
  data() {
    return {
      userAnswer: this.userAnswers[this.index] || (this.question.type === 'multi-choice' ? [] : '')
    };
  },
  computed: {
    parsedAnswers() {
      try {
        return typeof this.question.answers === 'string' ? JSON.parse(this.question.answers) : this.question.answers;
      } catch (e) {
        console.error("Error parsing answers:", e);
        return [];
      }
    }
  },
  methods: {
    selectAnswer(answer) {
      this.userAnswer = answer;
    },
    toggleAnswer(answer) {
      if (!Array.isArray(this.userAnswer)) {
        this.userAnswer = [];
      }

      const index = this.userAnswer.indexOf(answer);
      if (index > -1) {
        this.userAnswer.splice(index, 1);
      } else {
        this.userAnswer.push(answer);
      }
    },
    validateAnswer() {
      if (this.userAnswer === null || this.userAnswer === '') {
        alert('Please provide an answer.');
        return;
      }
      this.$emit('answer', { index: this.index, answer: this.userAnswer });
      this.$emit('next-page');
    },
    skipQuestion() {
      this.$emit('answer', { index: this.index, answer: null });
      this.$emit('next-page');
    }
  },
  watch: {
    userAnswers: {
      handler(newAnswers) {
        this.userAnswer = newAnswers[this.index] || (this.question.type === 'multi-choice' ? [] : '');
      },
      deep: true
    }
  }
};
</script>
