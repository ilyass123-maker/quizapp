<template>
    <div class="container">
      <h2>Question {{ index + 1 }}</h2>
      <p>{{ question.text }}</p>
      <div v-if="question.type === 'single-choice'">
        <div v-for="(answer, idx) in question.answers" :key="idx">
          <button
            class="answer-button"
            @click="selectAnswer(answer)"
            :class="{ 'selected': userAnswer === answer }">
            {{ answer }}
          </button>
        </div>
      </div>
      <div v-else-if="question.type === 'multi-choice'">
        <div v-for="(answer, idx) in question.answers" :key="idx">
          <button
            class="answer-button"
            :class="{ 'selected': userAnswer.includes(answer.text) }"
            @click="toggleAnswer(answer.text)">
            {{ answer.text }}
          </button>
        </div>
      </div>
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
    methods: {
      selectAnswer(answer) {
        this.userAnswer = answer;
      },
      toggleAnswer(answerText) {
        const index = this.userAnswer.indexOf(answerText);
        if (index > -1) {
          // Remove answer if already selected
          this.userAnswer.splice(index, 1);
        } else {
          // Add answer if not selected
          this.userAnswer.push(answerText);
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
        this.$emit('skip-question');
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
  
  
  