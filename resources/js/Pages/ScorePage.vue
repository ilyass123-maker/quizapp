<template>
  <div class="container score-container">
    <h2>Your Score</h2>

    <!-- Donut Chart -->
    <div class="chart-container" v-if="questions.length">
      <apexchart type="donut" :options="chartOptions" :series="chartSeries"></apexchart>
    </div>

    <p v-if="questions.length">You got {{ correctAnswers }} out of {{ questions.length }} questions correct.</p>

    <div class="score-section" v-if="questions.length">
      <p>Correct Answers: {{ correctAnswers }}</p>
      <p>Wrong or Skipped Questions: {{ wrongAnswers + skippedAnswers }}</p>
    </div>

    <!-- Display validation errors -->
    <div v-if="errors.length" class="error-messages">
      <p v-for="(error, index) in errors" :key="index" class="text-danger">{{ error }}</p>
    </div>

    <div class="button-container">
      <button class="start" @click="goToSummary">Go to Summary</button>
    </div>
  </div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';

export default {
  components: {
    apexchart: VueApexCharts
  },
  props: ['questions', 'userAnswers', 'quizId'], // Ensure quizId is passed as a prop
  data() {
    return {
      errors: [] // Array to store validation errors
    };
  },
  computed: {
    correctAnswers() {
      return this.userAnswers.filter((answer, index) => {
        const question = this.questions[index];
        if (!answer) return false; // Safeguard against null values
        if (question.type === 'multi-choice') {
          const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
          const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
          return userAnswerSet.size === correctAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans));
        } else {
          return answer.toLowerCase() === question.correct.toLowerCase();
        }
      }).length;
    },
    wrongAnswers() {
      return this.userAnswers.filter((answer, index) => {
        const question = this.questions[index];
        if (!answer) return false; // Safeguard against null values
        if (question.type === 'multi-choice') {
          const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
          const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
          return !(userAnswerSet.size === correctAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans)));
        } else {
          return answer.toLowerCase() !== question.correct.toLowerCase();
        }
      }).length;
    },
    skippedAnswers() {
      return this.userAnswers.filter(answer => !answer || (Array.isArray(answer) && answer.length === 0)).length;
    },
    chartSeries() {
      return [
        this.correctAnswers, 
        this.wrongAnswers + this.skippedAnswers
      ];
    },
    chartOptions() {
      return {
        chart: {
          type: 'donut'
        },
        labels: ['Correct Answers', 'Wrong or Skipped Answers'],
        colors: ['#219ebc', '#f3f3f3'],
        plotOptions: {
          pie: {
            donut: {
              size: '40%' // Adjust size here
            }
          }
        },
        legend: {
          position: 'bottom'
        }
      };
    }
  },
  methods: {
    goToSummary() {
      this.$emit('go-to-summary');
    },
    saveScore(score, quizId) {
      fetch('/save-score', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          score: score,
          quiz_id: quizId
        })
      })
      .then(response => {
        if (!response.ok) {
          return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
      })
      .then(data => {
        console.log('Success:', data);
      })
      .catch((error) => {
        this.errors.push('Failed to save score.');
        console.error('Error:', error);
      });
    },
    finishQuiz() {
      const score = this.correctAnswers;
      const quizId = this.quizId || 1; // Hardcoded quizId

      if (!quizId) {
        this.errors.push('Quiz ID is missing.');
        return;
      }

      this.saveScore(score, quizId);
    }
  },
  mounted() {
    this.finishQuiz(); // Automatically save the score when the component is mounted
  }
};
</script>

