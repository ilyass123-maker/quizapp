<template>
  <div class="container">
    <h2>Create a New Quiz</h2>

    <form @submit.prevent="submitQuiz">
      <div class="form-group">
        <label for="quiz-title">Quiz Title</label>
        <input
          type="text"
          v-model="quizTitle"
          id="quiz-title"
          class="form-control"
          placeholder="Enter quiz title"
          required
        />
      </div>

      <!-- Time Limit Input -->
      <div class="form-group">
        <label for="quiz-time-limit">Time Limit (in minutes)</label>
        <input
          type="number"
          v-model="quizTimeLimit"
          id="quiz-time-limit"
          class="form-control"
          placeholder="Enter time limit"
          min="1"
          required
        />
      </div>

      <div v-for="(question, index) in questions" :key="index" class="question">
        <h3>Question {{ index + 1 }}</h3>
        <div class="form-group">
          <label :for="'question-text-' + index">Question Text</label>
          <input
            type="text"
            v-model="question.text"
            :id="'question-text-' + index"
            class="form-control"
            placeholder="Enter question text"
            required
          />
        </div>

        <div class="form-group">
          <label :for="'question-type-' + index">Question Type</label>
          <select
            v-model="question.type"
            :id="'question-type-' + index"
            class="form-control"
            required
          >
            <option value="single-choice">Single Choice</option>
            <option value="multi-choice">Multiple Choice</option>
            <option value="typing">Typing</option>
          </select>
        </div>

        <!-- Display correct answer input for typing questions -->
        <div v-if="question.type === 'typing'" class="form-group">
          <label>Correct Answer</label>
          <input
            type="text"
            v-model="question.correctAnswer"
            class="form-control"
            placeholder="Enter the correct answer"
            required
          />
        </div>

        <!-- Display possible answers for non-typing questions -->
        <div v-if="question.type !== 'typing'" class="form-group">
          <label>Possible Answers</label>
          <div v-for="(answer, ansIndex) in question.answers" :key="ansIndex" class="form-group">
            <input
              type="text"
              v-model="question.answers[ansIndex]"
              class="form-control"
              placeholder="Enter answer text"
            />
            <label>
              <input type="radio" v-model="question.correctAnswer" :value="ansIndex" /> Correct
            </label>
          </div>
          <button
            type="button"
            class="btn btn-primary"
            @click="addAnswer(index)"
          >
            Add Another Answer
          </button>
        </div>

        <button
          type="button"
          class="btn btn-danger"
          @click="removeQuestion(index)"
        >
          Remove Question
        </button>
      </div>

      <button type="button" class="btn btn-primary" @click="addQuestion">
        Add Another Question
      </button>
      <button type="submit" class="btn btn-success">Submit Quiz</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quizTitle: '',
      quizTimeLimit: 7, // Default time limit (can be dynamically changed)
      questions: [
        {
          text: '',
          type: 'single-choice',
          answers: ['', '', '', ''], // Pre-define 4 answer slots
          correctAnswer: null, // This will hold the correct answer (index or value depending on type)
        },
      ],
    };
  },
  methods: {
    addQuestion() {
      this.questions.push({
        text: '',
        type: 'single-choice',
        answers: ['', '', '', ''], // Add 4 empty answers by default
        correctAnswer: null, // Reset correct answer
      });
    },
    removeQuestion(index) {
      this.questions.splice(index, 1);
    },
    addAnswer(questionIndex) {
      this.questions[questionIndex].answers.push(''); // Add an empty answer field
    },
    async submitQuiz() {
      // Prepare form data to submit
      const formData = {
        title: this.quizTitle,
        time_limit: this.quizTimeLimit || 7,  // Default to 7 if not set
        number_of_questions: this.questions.length,
        questions: this.questions.map(question => {
          return {
            ...question,
            correct: question.type === 'typing' 
              ? question.correctAnswer // Use string for typing questions
              : parseInt(question.correctAnswer), // Ensure integer for non-typing questions
          };
        }),
      };

      console.log('Submitting form data:', formData);

      try {
        const response = await fetch('/teacher/create-quiz', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute('content'),
          },
          body: JSON.stringify(formData),
        });

        if (response.ok) {
          const responseData = await response.json();
          alert(responseData.message);
        } else {
          const errorData = await response.json();
          console.error('Error creating quiz:', errorData);
          alert('Error creating quiz: ' + errorData.message);
        }
      } catch (error) {
        console.error('Submission error:', error);
        alert('Error submitting quiz');
      }
    },
  },
};
</script>

<style scoped>
/* Add any relevant styling */
</style>
