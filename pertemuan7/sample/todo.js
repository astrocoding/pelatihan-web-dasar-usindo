// ==========================================
// APLIKASI TO-DO LIST SEDERHANA
// ==========================================

// === 1. AMBIL ELEMEN HTML ===
// Kita ambil elemen-elemen yang akan kita manipulasi
const taskInput = document.getElementById('taskInput');
const addButton = document.getElementById('addButton');
const taskList = document.querySelector('.task-list');

// === 2. FUNGSI UNTUK MENAMBAH TUGAS ===
function addTask() {
    // Ambil nilai dari input
    const taskText = taskInput.value.trim();
    
    // Validasi: cek apakah input kosong
    if (taskText === '') {
        alert('Tolong tulis tugas terlebih dahulu!');
        return;
    }
    
    // Buat elemen div untuk item tugas baru
    const taskItem = document.createElement('div');
    taskItem.className = 'task-item';
    
    // Buat elemen span untuk teks tugas
    const taskTextElement = document.createElement('span');
    taskTextElement.className = 'task-text';
    taskTextElement.textContent = taskText;
    
    // Buat tombol hapus
    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.textContent = 'Hapus';
    
    // Tambahkan event listener untuk tombol hapus
    deleteButton.addEventListener('click', function() {
        deleteTask(taskItem);
    });
    
    // Masukkan elemen teks dan tombol ke dalam task item
    taskItem.appendChild(taskTextElement);
    taskItem.appendChild(deleteButton);
    
    // Tambahkan task item ke dalam daftar tugas
    taskList.appendChild(taskItem);
    
    // Kosongkan input setelah menambah tugas
    taskInput.value = '';
    
    // Fokus kembali ke input
    taskInput.focus();
}

// === 3. FUNGSI UNTUK MENGHAPUS TUGAS ===
function deleteTask(taskItem) {
    // Tambahkan konfirmasi sebelum menghapus
    const confirmDelete = confirm('Yakin ingin menghapus tugas ini?');
    
    if (confirmDelete) {
        // Hapus elemen dari DOM
        taskItem.remove();
    }
}

// === 4. EVENT LISTENERS ===
// Event listener untuk tombol tambah
addButton.addEventListener('click', addTask);

// Event listener untuk tombol Enter pada keyboard
taskInput.addEventListener('keypress', function(event) {
    // Cek apakah tombol yang ditekan adalah Enter (kode 13)
    if (event.key === 'Enter') {
        addTask();
    }
});

// === 5. PESAN KETIKA HALAMAN DIMUAT ===
console.log('Aplikasi To-Do List siap digunakan!');
console.log('Silakan tambahkan tugas-tugas Anda.');