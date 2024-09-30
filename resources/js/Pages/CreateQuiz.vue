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
                <input type="radio" v-model="question.correct" :value="ansIndex" /> Correct
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
        questions: [
          {
            text: '',
            type: 'single-choice',
            answers: ['', '', '', ''], // Pre-define 4 answer slots
            correct: null, // Index of correct answer
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
          correct: null, // Reset correct answer
        });
      },
      removeQuestion(index) {
        this.questions.splice(index, 1);
      },
      addAnswer(questionIndex) {
        this.questions[questionIndex].answers.push(''); // Add an empty answer field
      },
      async submitQuiz() {
        const formData = {
          title: this.quizTitle,
          questions: this.questions,
        };
  
        // Log the entire formData object to the console for inspection
        console.log('Form Data to be sent:', JSON.stringify(formData, null, 2));
  
        // Check if the 'questions' array has all required 'text' fields populated
        this.questions.forEach((question, index) => {
          if (!question.text) {
            console.error(`Question ${index + 1} is missing text!`);
          } else {
            console.log(`Question ${index + 1}: Text is set to "${question.text}"`);
          }
        });
  
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
            alert('Quiz created successfully!');
          } else {
            const errorData = await response.json();
            console.error('Error creating quiz:', errorData);
            alert('Error creating quiz');
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
  