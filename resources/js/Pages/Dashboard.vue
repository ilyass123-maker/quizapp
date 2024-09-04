<template>
  <div>
    <div class="top-bar" v-if="currentPage > 0 && currentPage <= questions.length">
      <div class="progress-bar-container">
        <div class="progress-bar">
          <div class="progress" :style="{ width: progressPercentage + '%' }"></div>
        </div>
      </div>
      <div class="timer-container">
        <div class="timer">{{ formattedTime }}</div>
        <div class="circle-timer" :style="{ 'background': 'conic-gradient(#219ebc ' + timeProgress + '%, #f3f3f3 0%)' }"></div>
      </div>
    </div>
    <introductory-page v-if="currentPage === 0" @start-quiz="startQuiz"></introductory-page>
    <question-page v-if="currentPage > 0 && currentPage <= questions.length"
                   :index="currentPage - 1"
                   :question="questions[currentPage - 1]"
                   :userAnswers="userAnswers"
                   @answer="handleAnswer"
                   @skip="skipQuestion"
                   @next-page="nextPage"></question-page>
    <score-page v-if="currentPage === questions.length + 1"
                :questions="questions"
                :userAnswers="userAnswers"
                :quizId="quizId"
                @go-to-summary="goToSummary"></score-page>
    <summary-page v-if="currentPage === questions.length + 2"
                  :questions="questions"
                  :userAnswers="userAnswers"
                  @restart="restartQuiz"></summary-page>
  </div>
</template>

<script>
import axios from 'axios';
import IntroductoryPage from './IntroductoryPage.vue';
import QuestionPage from './QuestionPage.vue';
import ScorePage from './ScorePage.vue';
import SummaryPage from './SummaryPage.vue';

export default {
  components: {
    IntroductoryPage,
    QuestionPage,
    ScorePage,
    SummaryPage,
  },
  data() {
    return {
      currentPage: 0,
      questions: [],
      userAnswers: [],
      timer: null,
      timeRemaining: 7 * 60, // 7 minutes
      quizId: 1 // Hardcode the quiz ID to 1
    };
  },
  computed: {
    correctAnswers() {
      return this.userAnswers.filter((answer, index) => {
        const question = this.questions[index];
        if (question.type === 'multi-choice') {
          const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
          const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
          return userAnswerSet.size === correctAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans));
        } else {
          return answer && answer.toLowerCase() === question.correct.toLowerCase();
        }
      }).length;
    },
    skippedAnswers() {
      return this.userAnswers.filter(answer => answer === null || (Array.isArray(answer) && answer.length === 0)).length;
    },
    wrongAnswers() {
      return this.userAnswers.filter((answer, index) => {
        const question = this.questions[index];
        if (question.type === 'multi-choice') {
          const userAnswerSet = new Set(answer.map(a => a.toLowerCase()));
          const correctAnswerSet = new Set(question.answers.filter(a => a.correct).map(a => a.text.toLowerCase()));
          return !(userAnswerSet.size === correctAnswerSet.size && [...userAnswerSet].every(ans => correctAnswerSet.has(ans)));
        } else {
          return answer && answer.toLowerCase() !== question.correct.toLowerCase();
        }
      }).length;
    },
    progressPercentage() {
      if (this.currentPage > 0 && this.currentPage <= this.questions.length) {
        return (this.currentPage / this.questions.length) * 100;
      }
      return 100; // Full progress for the score or summary page
    },
    formattedTime() {
      const minutes = Math.floor(this.timeRemaining / 60);
      const seconds = this.timeRemaining % 60;
      return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    },
    timeProgress() {
      return (this.timeRemaining / (7 * 60)) * 100; // 7 minutes timer
    }
  },
  methods: {
    async fetchQuestions() {
      axios.get(`/questions?quiz_id=${this.quizId}`) // Use hardcoded quizId in API call
        .then(response => {
          this.questions = response.data.map(question => {
            if (question.type === 'single-choice' || question.type === 'multi-choice') {
              question.answers = typeof question.answers === 'string' ? JSON.parse(question.answers) : question.answers;
            }
            return question;
          });
        })
        .catch(error => {
          console.error('Failed to fetch questions:', error);
        });
    },
    handleAnswer({ index, answer }) {
      this.userAnswers[index] = answer;
    },
    skipQuestion() {
      this.userAnswers[this.currentPage - 1] = null;
    },
    nextPage() {
      if (this.currentPage < this.questions.length) {
        this.currentPage++;
      } else if (this.currentPage === this.questions.length) {
        this.currentPage++; // Move to the score page
      } else if (this.currentPage === this.questions.length + 1) {
        this.currentPage++; // Move to the summary page
      }
    },
    restartQuiz() {
      this.currentPage = 0;
      this.userAnswers = Array(this.questions.length).fill(null);
      this.timeRemaining = 7 * 60; // Reset to 7 minutes
      this.startTimer(); // Start the timer after restarting the quiz
    },
    startTimer() {
      if (this.timer) {
        clearInterval(this.timer);
      }
      this.timer = setInterval(() => {
        if (this.timeRemaining > 0) {
          this.timeRemaining--;
        } else {
          clearInterval(this.timer);
          this.autoSkipAndRedirect();
        }
      }, 1000);
    },
    autoSkipAndRedirect() {
      this.userAnswers = this.userAnswers.map(answer => (answer === null || (Array.isArray(answer) && answer.length === 0)) ? null : answer);
      this.currentPage = this.questions.length + 1; // Transition to score page
    },
    goToSummary() {
      this.currentPage = this.questions.length + 2; // Transition to summary page after the score page
    },
    startQuiz() {
      this.startTimer(); // Start the timer when quiz starts
      this.currentPage = 1; // Move to the first question page
    }
  },
  created() {
    this.fetchQuestions(); // Fetch the questions from the server when the component is created
  }
};
</script>



<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: rgba(197, 219, 227, 0.993);
}

.top-bar {
  display: flex;
  justify-content: space-between; /* Adjusts the space between the timer and progress bar */
  align-items: center; /* Aligns the timer and progress bar vertically */
  padding: 10px; /* Adjust padding as needed */
}

.progress-bar-container {
  flex-grow: 1; /* Makes the progress bar take up the remaining space */
  margin-left: 20px; /* Adds space between the timer and progress bar */
  margin-right: 20px; /* Adds space on the right to move the progress bar left */
}

.progress-bar {
  width: calc(100% - 20px); /* Adjusts the width to account for the right margin */
  height: 10px; /* Adjust height as needed */
  background-color: #e0e0e0; /* Background color of the progress bar */
  border-radius: 5px; /* Rounds the corners of the progress bar */
  overflow: hidden;
}

.progress {
  height: 100%;
  background-color: #219ebc; /* Color of the progress */
}

.timer-container {
  display: flex;
  align-items: center;
  justify-content: flex-start; /* Align to the left */
  flex-shrink: 0;
}

.timer {
  font-size: 16px;
  font-weight: bold;
  margin-right: 10px;
  text-align: left; /* Align text to the left */
}

.circle-timer {
  width: 40px; /* Adjust size as needed */
  height: 40px; /* Adjust size as needed */
  border-radius: 50%;
  background-color: #f3f3f3; /* Ensures a background for visibility */
  flex-shrink: 0; /* Prevents the timer from shrinking */
}

.container {
  width: 100%;
  max-width: 600px;
  margin: 70px auto 20px auto;
  text-align: center;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.button-container {
  display: flex;
  justify-content: space-between; /* Ensure buttons are aligned */
  margin-top: 20px;
}

button {
  flex: 1;
  margin: 0 5px;
  padding: 15px 20px;
  border: 2px solid #219ebc;
  border-radius: 5px;
  background-color: #219ebc;
  color: white;
  cursor: pointer;
  transition: background-color 0.3s, border-color 0.3s;
  text-align: center;
}

button:hover {
  background-color: #1a7bb9;
}

button:active {
  background-color: #135d8d;
}

.start {
  background-color: #219ebc;
}

.start:hover {
  background-color: #1a7bb9;
}

.start:active {
  background-color: #135d8d;
}

.answer-button {
  width: calc(100% - 20px);
  margin: 10px auto;
  padding: 15px;
  border: 2px solid #ddd;
  background-color: #fff;
  color: #333;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
}

.answer-button:hover {
  background-color: #f9f9f9;
}

.answer-button:active {
  background-color: #e0e0e0;
}

.answer-button.selected {
  background-color: #d0d0d0;
  color: #333;
}

.summary-item {
  margin: 20px 0;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.correct-section {
  background-color: #e0f7fa;
}

.wrong-section {
  background-color: #ffebee;
}

.skipped-section {
  background-color: #ffebee; /* Red for skipped answers */
}

.restart {
  background-color: #219ebc;
  border: 2px solid #219ebc;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, border-color 0.3s;
}

.restart:hover {
  background-color: #1a7bb9;
}

.restart:active {
  background-color: #135d8d;
}

input[type="text"] {
  width: calc(100% - 20px); /* Match the width with other question containers */
  margin: 10px auto;
  padding: 15px;
  border: 2px solid #ddd;
  border-radius: 5px;
  background-color: #fff;
  font-size: 1em;
  box-sizing: border-box;
}

@media (max-width: 600px) {
  .container {
    padding: 10px;
  }

  button {
    padding: 8px 16px;
    margin: 5px 0;
    width: calc(100% - 10px);
  }

  .timer {
    font-size: 14px;
  }
}

.chart-container {
  margin-bottom: 20px; /* Space between chart and text */
  max-width: 400px; /* Adjust as needed */
  margin-left: auto;
  margin-right: auto;
}
</style>
