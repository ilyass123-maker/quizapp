<template>
  <div class="container score-container">
    <h2>Your Score</h2>

    <!-- Donut Chart -->
    <div class="chart-container">
      <apexchart type="donut" :options="chartOptions" :series="chartSeries"></apexchart>
    </div>

    <p>You got {{ correctAnswers }} out of {{ questions.length }} questions correct.</p>

    <div class="score-section">
      <p>Correct Answers: {{ correctAnswers }}</p>
      <p>Wrong Answers: {{ wrongAnswers }}</p>
      <p>Skipped Questions: {{ skippedAnswers }}</p>
    </div>

    <div class="button-container">
      <button class="start" @click="goToSummary">Go to Summary</button>
    </div>
  </div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';
import axios from 'axios';

export default {
  components: {
    apexchart: VueApexCharts,
  },
  props: ['questions', 'userAnswers', 'quizId'],
  data() {
    return {
      scoreSaved: false, // Prevent multiple score submissions
    };
  },
  computed: {
    correctAnswers() {
      if (!this.questions || !Array.isArray(this.questions) || !this.userAnswers) return 0;

      return this.userAnswers.filter((answer, index) => {
        const question = this.questions[index];
        if (!question || !question.correct) return false;

        if (answer === null || answer === undefined) return false; // Skipped

        // Multiple-choice questions
        if (question.type === 'multi-choice') {
          const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
          const correctAnswerSet = new Set(
            question.answers
              .filter(a => a.correct)
              .map(a => a.text.toLowerCase())
          );
          return (
            userAnswerSet.size === correctAnswerSet.size &&
            [...userAnswerSet].every(ans => correctAnswerSet.has(ans))
          );
        }
        // Single-choice or typing questions
        else {
          return answer.toString().trim().toLowerCase() === question.correct.toString().trim().toLowerCase();
        }
      }).length;
    },

    skippedAnswers() {
      if (!this.userAnswers) return 0;
      return this.userAnswers.filter(answer => answer === null || answer === undefined).length;
    },

    wrongAnswers() {
      if (!this.questions || !this.userAnswers || !Array.isArray(this.questions) || !Array.isArray(this.userAnswers)) return 0;

      return this.userAnswers.filter((answer, index) => {
        const question = this.questions[index];
        if (!question || !question.correct) return false;

        if (answer === null || answer === undefined) return true; // Skipped answers are considered wrong

        // Multi-choice
        if (question.type === 'multi-choice') {
          const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
          const correctAnswerSet = new Set(
            question.answers
              .filter(a => a.correct)
              .map(a => a.text.toLowerCase())
          );
          return !(
            userAnswerSet.size === correctAnswerSet.size &&
            [...userAnswerSet].every(ans => correctAnswerSet.has(ans))
          );
        }
        // Single-choice or typing questions
        else {
          return answer.toString().trim().toLowerCase() !== question.correct.toString().trim().toLowerCase();
        }
      }).length;
    },

    chartSeries() {
      return [this.correctAnswers, this.wrongAnswers + this.skippedAnswers];
    },

    chartOptions() {
      return {
        chart: {
          type: 'donut',
        },
        labels: ['Correct Answers', 'Wrong or Skipped Answers'],
        colors: ['#219ebc', '#f3f3f3'],
        plotOptions: {
          pie: {
            donut: {
              size: '50%',
            },
          },
        },
        legend: {
          position: 'bottom',
        },
      };
    },
  },

  methods: {
    goToSummary() {
      this.$emit('go-to-summary');
    },

    submitScore() {
      // Prevent multiple submissions
      if (!this.scoreSaved) {
        this.scoreSaved = true;
        axios
          .post('/save-score', {
            score: this.correctAnswers, // Send only correct answers to score table
            quiz_id: this.quizId,
          })
          .then(response => {
            console.log('Score saved successfully:', response.data);
          })
          .catch(error => {
            console.error(
              'Error saving score:',
              error.response ? error.response.data : error.message
            );
          });
      }
    },
  },

  mounted() {
    // Ensure score is only submitted once, at the end of the quiz
    if (!this.scoreSaved) {
      this.submitScore();
    }
  },
};
</script>
