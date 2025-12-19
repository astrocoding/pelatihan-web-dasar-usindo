const taskInput = document.getElementById('taskInput');
const addButton = document.getElementById('addButton');
const taskList = document.querySelector('.task-list');

function addTask() {
  const taskText = taskInput.value.trim();

  if (taskText === '') {
    alert('Tolong tulis tugasnya!');
    return;
  }

  const taskItem = document.createElement('div');
  taskItem.className = 'task-item';

  const taskTextElement = document.createElement('span');
  taskTextElement.className = 'task-text';
  taskTextElement.textContent = taskText;

  const deleteButton = document.createElement('button');
  deleteButton.className = 'delete-button';
  deleteButton.textContent = 'Hapus';

  deleteButton.addEventListener('click', function() {
    deleteTask(taskItem);
  });

  taskItem.appendChild(taskTextElement);
  taskItem.appendChild(deleteButton);

  taskList.appendChild(taskItem);

  taskInput.value = '';
  taskInput.focus();
}

function deleteTask(taskItem) {
  const confirmDelete = confirm('Yakin ingin menghapus tugas ini?');

  if (confirmDelete) {
    taskItem.remove();
  }
}

addButton.addEventListener('click', addTask);

taskInput.addEventListener('keypress', function(event) {
  if (event.key === 'Enter') {
    addTask();
  }
});