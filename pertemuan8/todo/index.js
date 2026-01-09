const taskInput = document.getElementById('taskInput');
const addButton = document.getElementById('addButton');
const taskList = document.querySelector('.task-list');

function addTask() {
  const taskText = taskInput.value.trim();

  if (taskText === '') {
    alert('Tolong tulis tugasnya!');
    return;
  }

  const itemTugas = document.createElement('div');
  itemTugas.className = 'task-item';

  const teksTugas = document.createElement('span');
  teksTugas.className = 'task-text';
  teksTugas.textContent = taskText;

  const tombolHapus = document.createElement('button');
  tombolHapus.className = 'delete-button';
  tombolHapus.textContent = 'Hapus';

  tombolHapus.addEventListener('click', function() {
    hapusTugas(itemTugas)
  });

  itemTugas.appendChild(teksTugas);
  itemTugas.appendChild(tombolHapus);

  taskList.appendChild(itemTugas);

  taskInput.value = '';
  taskInput.focus();
}

function hapusTugas(itemTugas) {
  const konfirmasiHapus = confirm('Yakin ingin menghapus tugas ini?');

  if (konfirmasiHapus) {
    itemTugas.remove();
  }
}

addButton.addEventListener('click', addTask);

