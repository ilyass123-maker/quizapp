document.addEventListener('DOMContentLoaded', function() {
    let questionIndex = 1;
    
    document.getElementById('add-question').addEventListener('click', function() {
        const questionContainer = document.createElement('div');
        questionContainer.classList.add('question');
        questionContainer.setAttribute('data-index', questionIndex);

        questionContainer.innerHTML = `
            <h3>Question ${questionIndex + 1}</h3>
            <div class="form-group">
                <label for="question-text-${questionIndex}">Question Text</label>
                <input type="text" id="question-text-${questionIndex}" name="questions[${questionIndex}][text]" class="form-control" placeholder="Enter question text" required>
            </div>
            
            <div class="form-group">
                <label for="question-type-${questionIndex}">Question Type</label>
                <select id="question-type-${questionIndex}" name="questions[${questionIndex}][type]" class="form-control" required>
                    <option value="single-choice">Single Choice</option>
                    <option value="multi-choice">Multiple Choice</option>
                    <option value="typing">Typing</option>
                </select>
            </div>
            
            <div id="answers-container-${questionIndex}" class="answers-container" style="display:none;">
                <div class="form-group">
                    <label for="answers-${questionIndex}">Possible Answers</label>
                    <textarea id="answers-${questionIndex}" name="questions[${questionIndex}][answers]" class="form-control" placeholder="Enter possible answers (comma separated)" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="correct-${questionIndex}">Correct Answer(s)</label>
                    <input type="text" id="correct-${questionIndex}" name="questions[${questionIndex}][correct]" class="form-control" placeholder="Enter correct answer(s) (comma separated)">
                </div>
            </div>
            
            <div id="typing-answer-container-${questionIndex}" class="typing-answer-container" style="display:none;">
                <div class="form-group">
                    <label for="correct-${questionIndex}">Correct Answer</label>
                    <input type="text" id="correct-${questionIndex}" name="questions[${questionIndex}][correct]" class="form-control" placeholder="Enter correct answer">
                </div>
            </div>
        `;
        
        document.getElementById('questions').appendChild(questionContainer);
        
        // Add event listener to the new select element
        document.getElementById(`question-type-${questionIndex}`).addEventListener('change', function() {
            const value = this.value;
            document.getElementById(`answers-container-${questionIndex}`).style.display = (value === 'single-choice' || value === 'multi-choice') ? 'block' : 'none';
            document.getElementById(`typing-answer-container-${questionIndex}`).style.display = value === 'typing' ? 'block' : 'none';
        });

        questionIndex++;
    });
    
    document.querySelectorAll('select[name$="[type]"]').forEach((select, index) => {
        select.addEventListener('change', function() {
            const value = this.value;
            document.querySelector(`#answers-container-${index}`).style.display = (value === 'single-choice' || value === 'multi-choice') ? 'block' : 'none';
            document.querySelector(`#typing-answer-container-${index}`).style.display = value === 'typing' ? 'block' : 'none';
        });
    });
});
