<template>
  <div class="page-content">
    <div class="container">
      <div class="row">
        <!-- Main Quiz Content -->
        <div class="col-md-12">
          <div class="settings-widget">
            <div class="settings-inner-blk p-0">
              <div class="sell-course-head comman-space">
                <h3>Quizzes</h3>
                <p>Start and manage your quizzes here.</p>
              </div> 

              <!-- List of available quizzes -->
              <div v-if="quizzes.length > 0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Quiz Title</th>
                      <th>Time Limit</th>
                      <th>Number of Questions</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="quiz in quizzes" :key="quiz.id">
                      <td>{{ quiz.title }}</td>
                      <td>{{ quiz.timeLimit }} minutes</td>
                      <td>{{ quiz.questionsCount }}</td>
                      <td>
                        <a :href="`/quiz/${quiz.id}`" class="btn btn-primary"> <!-- Blade route link -->
                          Start Quiz
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- If no quizzes available -->
              <div v-else>
                <p>No quizzes available.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quizzes: [] // List of quizzes
    };
  },
  mounted() {
    // Fetch the quizzes using the actual API logic
    this.fetchQuizzes();
  },
  methods: {
    async fetchQuizzes() {
      try {
        const response = await fetch(`/quizzes`);

        if (!response.ok) {
          throw new Error('Failed to fetch quizzes');
        }

        const data = await response.json();
        this.quizzes = data; // Assuming the API returns a list of quizzes
      } catch (error) {
        console.error('Failed to fetch quizzes:', error);
      }
    }
  }
};
</script>


<style scoped>
.table {
  width: 100%;
  margin-top: 20px;
}
</style>
