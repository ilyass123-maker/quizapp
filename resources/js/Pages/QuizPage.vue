<template>
    <div class="quiz-page-container">
      <!-- Progress bar and timer displayed when the quiz has started -->
      <div v-if="currentPage > 0 && currentPage <= questions.length" class="top-bar">
        <!-- Progress Bar -->
        <div class="progress-bar-container">
          <div class="progress-bar">
            <div class="progress" :style="{ width: progressPercentage + '%' }"></div>
          </div>
        </div>
  
        <!-- Timer (in top-right) -->
        <div class="timer-container">
          <div class="circle-timer" :style="{ background: 'conic-gradient(#005f73 ' + timeProgress + '%, #f3f3f3 0%)' }"></div>
          <div class="timer-text">{{ formattedTime }}</div>
        </div>
      </div>
  
      <!-- Introductory page displayed at the start -->
      <introductory-page v-if="currentPage === 0" :quiz="quiz" @start-quiz="startQuiz"></introductory-page>
  
      <!-- Question page displayed when a question is being answered -->
      <question-page
        v-if="currentPage > 0 && currentPage <= questions.length"
        :index="currentPage - 1"
        :question="questions[currentPage - 1]"
        :userAnswers="userAnswers"
        @answer="handleAnswer"
        @next-page="nextPage"
      ></question-page>
  
      <!-- Score page displayed after all questions are answered -->
      <score-page
        v-if="currentPage === questions.length + 1"
        :questions="questions"
        :userAnswers="userAnswers"
        :quizId="quizId"
        @go-to-summary="goToSummary"
      ></score-page>
  
      <!-- Summary page displayed at the end -->
      <summary-page
        v-if="currentPage === questions.length + 2"
        :questions="questions"
        :userAnswers="userAnswers"
        @restart="restartQuiz"
      ></summary-page>
    </div>
  </template>
  
  <script>
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
    props: ['quizId'], // Receive quizId as a prop from the parent component (or directly in Blade)
    data() {
      return {
        quiz: {}, // The quiz information
        questions: [], // List of questions
        currentPage: 0, // The current page in the quiz process
        userAnswers: [], // The user's answers
        correctAnswers: 0, // The number of correct answers
        timer: null,
        timeRemaining: 7 * 60, // Set to 7 minutes (or customize based on quiz time limit)
      };
    },
    async mounted() {
      await this.fetchQuiz(); // Fetch the quiz data
      await this.fetchQuestions(); // Fetch the questions
    },
    computed: {
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
        return (this.timeRemaining / (7 * 60)) * 100; // Update to match time limit
      },
    },
    methods: {
      // Fetch quiz details based on quizId
      async fetchQuiz() {
        try {
          const response = await fetch(`/quizzes/${this.quizId}`);
          if (!response.ok) throw new Error('Failed to fetch quiz');
          this.quiz = await response.json();
        } catch (error) {
          console.error('Error fetching quiz:', error);
        }
      },
      // Fetch the list of questions based on quizId
      async fetchQuestions() {
        try {
          const response = await fetch(`/quizzes/${this.quizId}/questions`);
          if (!response.ok) throw new Error('Failed to fetch questions');
          const data = await response.json();
          // Ensure answers is an array for each question
          this.questions = data.map((question) => ({
            ...question,
            answers: Array.isArray(question.answers) ? question.answers : [],
          }));
        } catch (error) {
          console.error('Error fetching questions:', error);
        }
      },
      handleAnswer({ index, answer }) {
        this.userAnswers[index] = answer;
      },
      nextPage() {
        if (this.currentPage < this.questions.length) {
          this.currentPage++;
        } else {
          this.calculateScore();
          this.currentPage++;
        }
      },
      calculateScore() {
        this.correctAnswers = this.questions.reduce((count, question, index) => {
          const correctAnswer = this.getCorrectAnswer(question);
          const userAnswer = this.userAnswers[index] || '';
          return correctAnswer === userAnswer ? count + 1 : count;
        }, 0);
      },
      getCorrectAnswer(question) {
        // Check if the answers array is properly structured
        if (!Array.isArray(question.answers)) {
          console.error(`Invalid answers format for question: ${question.text}`);
          return '';
        }
        const correctAnswer = question.answers.find((answer) => answer.correct);
        return correctAnswer ? correctAnswer.text : '';
      },
      goToSummary() {
        this.currentPage++;
      },
      restartQuiz() {
        this.currentPage = 0;
        this.userAnswers = [];
        this.correctAnswers = 0;
        this.timeRemaining = 7 * 60; // Reset timer
        this.startTimer();
      },
      startQuiz() {
        this.startTimer();
        this.currentPage = 1;
      },
      startTimer() {
        if (this.timer) clearInterval(this.timer);
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
        this.userAnswers = this.userAnswers.map((answer) =>
          answer === null || (Array.isArray(answer) && answer.length === 0)
            ? null
            : answer
        );
        this.currentPage = this.questions.length + 1; // Move to score page
      },
    },
  };
  </script>
  
  <style scoped>
  .quiz-page-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  
  .top-bar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .progress-bar-container {
    width: 80%;
    background-color: #f3f3f3;
    height: 10px;
    border-radius: 5px;
    overflow: hidden;
  }
  
  .progress-bar .progress {
    height: 100%;
    background-color: #005f73; /* Dark blue color */
  }
  
  .timer-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: absolute;
    top: 10px;
    right: 20px;
  }
  
  .circle-timer {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 10px;
  }
  
  .timer-text {
    font-size: 18px;
    color: #333;
  }
  
  .button {
    background-color: #005f73;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
  }
  
  .button:hover {
    background-color: #003b4a;
  }
  
  /* Centering for question content */
  .question-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
  }
  </style>
  