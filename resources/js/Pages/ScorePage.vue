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
  computed: {
    correctAnswers() {
    return this.userAnswers.filter((answer, index) => {
      const question = this.questions[index];
      if (!question || answer === null || answer === undefined) return false;
      
      if (question.type === 'multi-choice') {
        const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
        const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
        return userAnswerSet.size === correctAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans));
      } else {
        return answer.toLowerCase() === question.correct.toLowerCase();
      }
    }).length;
  },

  skippedAnswers() {
    // Count skipped answers, only those where the answer is explicitly skipped
    return this.userAnswers.filter(answer => answer === null || answer === undefined).length;
  },

  wrongAnswers() {
    // Count wrong answers, making sure that skipped questions are not included
    return this.userAnswers.filter((answer, index) => {
      const question = this.questions[index];
      
      // If the question was skipped, it should not be counted as wrong
      if (answer === null || answer === undefined) return false;

      // Multi-choice questions
      if (question.type === 'multi-choice') {
        const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
        const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
        return !(userAnswerSet.size === correctAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans)));
      }

      // Single-choice or typing questions
      return answer.toLowerCase() !== question.correct.toLowerCase();
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
    }
  },

  methods: {
  goToSummary() {
    this.$emit('go-to-summary');
  },

  submitScore() {
    // Ensure score is saved only once at the end of the quiz
    if (!this.scoreSaved) {
      this.scoreSaved = true;
      axios
        .post('/save-score', {
          score: this.correctAnswers, // Send only correct answers
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
  }
},

mounted() {
  // Ensure score is only submitted once, after quiz completion
  if (!this.scoreSaved) {
    this.submitScore();
  }
}

};
</script>
