// ============================================
// JAVASCRIPT DOM - SAMPEL LENGKAP
// ============================================

console.log("DOM Manipulation Samples Loaded!");

// ============================================
// 1. AKSES ELEMEN DOM
// ============================================

function aksesElemen() {
    console.log("\n=== AKSES ELEMEN DOM ===");
    
    // 1.1 getElementById - mengambil elemen berdasarkan ID
    const elById = document.getElementById('elementById');
    console.log("getElementById:", elById);
    
    // 1.2 getElementsByClassName - mengambil elemen berdasarkan class (mengembalikan HTMLCollection)
    const elsByClass = document.getElementsByClassName('elementByClass');
    console.log("getElementsByClassName:", elsByClass);
    console.log("Jumlah elemen dengan class 'elementByClass':", elsByClass.length);
    
    // 1.3 getElementsByTagName - mengambil elemen berdasarkan tag name
    const elsByTag = document.getElementsByTagName('p');
    console.log("getElementsByTagName('p'):", elsByTag);
    
    // 1.4 querySelector - mengambil elemen PERTAMA yang cocok dengan CSS selector
    const elQuery = document.querySelector('.elementByClass');
    console.log("querySelector('.elementByClass'):", elQuery);
    
    // 1.5 querySelectorAll - mengambil SEMUA elemen yang cocok dengan CSS selector (mengembalikan NodeList)
    const elsQueryAll = document.querySelectorAll('.demo-box');
    console.log("querySelectorAll('.demo-box'):", elsQueryAll);
    
    // 1.6 Akses elemen dengan attribute selector
    const elByAttr = document.querySelector('[data-info="test"]');
    console.log("querySelector dengan data attribute:", elByAttr);
    
    // 1.7 Akses elemen dengan kombinasi selector
    const elComplex = document.querySelector('div.section > .demo-box');
    console.log("Selector kompleks:", elComplex);
    
    alert("Cek console untuk hasil akses elemen!");
}

// ============================================
// 2. MENGUBAH ISI KONTEN ELEMEN
// ============================================

function ubahKonten() {
    console.log("\n=== MENGUBAH ISI KONTEN ===");
    
    // 2.1 textContent - mengubah teks konten (tidak memparsing HTML)
    const textEl = document.getElementById('contentText');
    textEl.textContent = "Teks sudah diubah dengan textContent";
    console.log("textContent diubah");
    
    // 2.2 innerHTML - mengubah konten HTML (memparsing HTML)
    const htmlEl = document.getElementById('contentHTML');
    htmlEl.innerHTML = "<strong>HTML sudah diubah</strong> dengan <em>innerHTML</em>";
    console.log("innerHTML diubah");
    
    // 2.3 innerText - mirip textContent tapi mempertimbangkan styling CSS
    // textEl.innerText = "Diubah dengan innerText";
    
    // 2.4 value - mengubah nilai input field
    const inputEl = document.getElementById('inputValue');
    inputEl.value = "Nilai input sudah diubah";
    console.log("value input diubah");
    
    // 2.5 outerHTML - mengubah elemen termasuk tag-nya sendiri
    // htmlEl.outerHTML = "<p>Element diganti sepenuhnya</p>";
}

// ============================================
// 3. MENGUBAH STYLING LANGSUNG
// ============================================

function ubahStyle() {
    console.log("\n=== MENGUBAH STYLE LANGSUNG ===");
    
    const box = document.getElementById('styleBox');
    
    // 3.1 Mengubah satu properti CSS
    box.style.backgroundColor = "#ff6b6b";
    box.style.color = "white";
    box.style.padding = "30px";
    box.style.fontSize = "20px";
    box.style.fontWeight = "bold";
    box.style.border = "3px solid #c92a2a";
    box.style.borderRadius = "10px";
    box.style.transition = "all 0.3s ease";
    
    // 3.2 Mengubah transform
    box.style.transform = "rotate(2deg) scale(1.05)";
    
    // 3.3 Mengubah dengan cssText (multiple properties sekaligus)
    // box.style.cssText = "background: blue; color: white; padding: 20px;";
    
    console.log("Style diubah!");
}

function resetStyle() {
    const box = document.getElementById('styleBox');
    
    // 3.4 Menghapus style inline (kembali ke CSS default)
    box.style.cssText = "";
    // Atau: box.removeAttribute('style');
    
    console.log("Style direset!");
}

// ============================================
// 4. PENGGUNAAN CLASSLIST
// ============================================

function tambahClass() {
    const box = document.getElementById('classListBox');
    
    // 4.1 add() - menambahkan satu atau lebih class
    box.classList.add('highlight');
    // Bisa juga menambahkan multiple: box.classList.add('class1', 'class2', 'class3');
    
    console.log("Class 'highlight' ditambahkan");
    console.log("Semua class:", box.classList);
}

function hapusClass() {
    const box = document.getElementById('classListBox');
    
    // 4.2 remove() - menghapus satu atau lebih class
    box.classList.remove('highlight');
    // Bisa juga: box.classList.remove('class1', 'class2');
    
    console.log("Class 'highlight' dihapus");
}

function toggleClass() {
    const box = document.getElementById('classListBox');
    
    // 4.3 toggle() - menambahkan class jika tidak ada, menghapus jika ada
    box.classList.toggle('active');
    
    // toggle() juga bisa menerima parameter kedua (force)
    // box.classList.toggle('active', true);  // force add
    // box.classList.toggle('active', false); // force remove
    
    console.log("Class 'active' di-toggle");
}

function replaceClass() {
    const box = document.getElementById('classListBox');
    
    // 4.4 replace() - mengganti satu class dengan class lain
    if (box.classList.contains('demo-box')) {
        box.classList.replace('demo-box', 'highlight');
        console.log("Class 'demo-box' diganti dengan 'highlight'");
    } else if (box.classList.contains('highlight')) {
        box.classList.replace('highlight', 'demo-box');
        console.log("Class 'highlight' diganti dengan 'demo-box'");
    }
}

function cekClass() {
    const box = document.getElementById('classListBox');
    
    // 4.5 contains() - mengecek apakah elemen memiliki class tertentu
    const hasHighlight = box.classList.contains('highlight');
    const hasActive = box.classList.contains('active');
    
    alert(`Contains 'highlight': ${hasHighlight}\nContains 'active': ${hasActive}`);
    
    // 4.6 item() - mendapatkan class berdasarkan index
    console.log("Class pertama:", box.classList.item(0));
    
    // 4.7 length - jumlah class
    console.log("Jumlah class:", box.classList.length);
    
    // 4.8 Iterasi semua class
    console.log("Semua class:");
    box.classList.forEach(className => {
        console.log("-", className);
    });
}

// ============================================
// 5. EVENT LISTENER
// ============================================

// 5.1 CLICK EVENTS
const btnClick = document.getElementById('btnClick');
const btnDoubleClick = document.getElementById('btnDoubleClick');
const clickResult = document.getElementById('clickResult');

// addEventListener() - menambahkan event listener
btnClick.addEventListener('click', function(event) {
    clickResult.textContent = "Button di-click! Time: " + new Date().toLocaleTimeString();
    console.log("Click event object:", event);
    console.log("Target:", event.target);
    console.log("Type:", event.type);
});

// Double click event
btnDoubleClick.addEventListener('dblclick', function(e) {
    clickResult.textContent = "Button di-double-click!";
    console.log("Double click event!");
});

// 5.2 MOUSE EVENTS
const mouseBox = document.getElementById('mouseBox');
const mouseResult = document.getElementById('mouseResult');

// mouseenter - mouse masuk ke elemen
mouseBox.addEventListener('mouseenter', function() {
    this.style.backgroundColor = 'lightcoral';
    mouseResult.textContent = "Mouse entered!";
});

// mouseleave - mouse keluar dari elemen
mouseBox.addEventListener('mouseleave', function() {
    this.style.backgroundColor = 'lightblue';
    mouseResult.textContent = "Mouse left!";
});

// mousemove - mouse bergerak di dalam elemen
mouseBox.addEventListener('mousemove', function(e) {
    mouseResult.textContent = `Mouse position: X=${e.offsetX}, Y=${e.offsetY}`;
});

// mouseover vs mouseenter (mouseover juga trigger untuk child elements)
// mouseout vs mouseleave (mouseout juga trigger untuk child elements)

// 5.3 KEYBOARD EVENTS
const keyInput = document.getElementById('keyInput');
const keyResult = document.getElementById('keyResult');

// keydown - tombol keyboard ditekan
keyInput.addEventListener('keydown', function(e) {
    console.log("Key down:", e.key, "Code:", e.code);
});

// keyup - tombol keyboard dilepas
keyInput.addEventListener('keyup', function(e) {
    keyResult.textContent = `Key pressed: ${e.key} | Input value: ${this.value}`;
});

// keypress - deprecated, gunakan keydown sebagai gantinya

// 5.4 FORM EVENTS
const demoForm = document.getElementById('demoForm');
const formInput = document.getElementById('formInput');
const formResult = document.getElementById('formResult');

// submit - form di-submit
demoForm.addEventListener('submit', function(e) {
    e.preventDefault(); // mencegah form submit default (reload page)
    formResult.textContent = `Form submitted! Value: ${formInput.value}`;
    console.log("Form submitted");
});

// change - nilai input berubah dan kehilangan focus
formInput.addEventListener('change', function(e) {
    console.log("Input changed:", this.value);
});

// input - nilai input berubah (real-time)
formInput.addEventListener('input', function(e) {
    console.log("Input event (real-time):", this.value);
});

// 5.5 FOCUS EVENTS
const focusInput = document.getElementById('focusInput');
const focusResult = document.getElementById('focusResult');

// focus - elemen mendapat focus
focusInput.addEventListener('focus', function() {
    this.style.backgroundColor = '#fff3cd';
    focusResult.textContent = "Input is focused!";
});

// blur - elemen kehilangan focus
focusInput.addEventListener('blur', function() {
    this.style.backgroundColor = '';
    focusResult.textContent = "Input lost focus!";
});

// 5.6 MULTIPLE LISTENERS & REMOVE
const multiBtn = document.getElementById('multiBtn');
const multiResult = document.getElementById('multiResult');

// Fungsi yang akan di-attach dan di-remove
function handleClick1() {
    multiResult.textContent = "Handler 1 triggered!";
}

function handleClick2() {
    console.log("Handler 2 triggered!");
}

function handleClick3() {
    alert("Handler 3 triggered!");
}

// Menambahkan multiple listeners ke satu elemen
multiBtn.addEventListener('click', handleClick1);
multiBtn.addEventListener('click', handleClick2);
multiBtn.addEventListener('click', handleClick3);

// Fungsi untuk remove semua listeners
function removeListeners() {
    multiBtn.removeEventListener('click', handleClick1);
    multiBtn.removeEventListener('click', handleClick2);
    multiBtn.removeEventListener('click', handleClick3);
    multiResult.textContent = "All listeners removed!";
    console.log("Listeners removed");
}

// 5.7 EVENT DELEGATION (best practice untuk dynamic elements)
document.querySelector('body').addEventListener('click', function(e) {
    // Cek apakah yang di-klik adalah button
    if (e.target.matches('button')) {
        console.log("Button clicked via delegation:", e.target.textContent);
    }
});

// 5.8 EVENT OPTIONS
// addEventListener() bisa menerima options sebagai parameter ketiga
const scrollElement = document.querySelector('body');
scrollElement.addEventListener('scroll', function() {
    console.log("Scrolling...");
}, {
    passive: true,  // meningkatkan performa scroll
    capture: false, // fase event (false = bubbling, true = capturing)
    once: false     // listener hanya dijalankan sekali
});

// ============================================
// 6. MANIPULASI ATRIBUT
// ============================================

function ubahAtribut() {
    const img = document.getElementById('demoImage');
    
    // 6.1 setAttribute() - set/ubah atribut
    img.setAttribute('src', 'https://via.placeholder.com/200');
    img.setAttribute('alt', 'Updated Image');
    img.setAttribute('width', '200');
    
    // 6.2 getAttribute() - ambil nilai atribut
    const src = img.getAttribute('src');
    console.log("Image src:", src);
    
    // 6.3 Akses atribut langsung (untuk atribut standar)
    img.title = "This is a demo image";
    img.alt = "Demo";
    
    // 6.4 hasAttribute() - cek apakah atribut ada
    console.log("Has 'title':", img.hasAttribute('title'));
    
    // 6.5 Data attributes
    img.setAttribute('data-custom', 'value123');
    // Atau menggunakan dataset:
    img.dataset.custom = 'value123';
    img.dataset.userId = '456';
    console.log("Data attributes:", img.dataset);
}

function hapusAtribut() {
    const img = document.getElementById('demoImage');
    
    // 6.6 removeAttribute() - hapus atribut
    img.removeAttribute('width');
    img.removeAttribute('title');
    console.log("Attributes removed");
}

// ============================================
// 7. MEMBUAT & MENGHAPUS ELEMEN
// ============================================

function tambahElemen() {
    const container = document.getElementById('container');
    
    // 7.1 createElement() - membuat elemen baru
    const newDiv = document.createElement('div');
    
    // 7.2 Mengisi konten
    newDiv.textContent = `Element ${container.children.length + 1}`;
    
    // 7.3 Menambahkan class dan style
    newDiv.classList.add('demo-box');
    newDiv.style.backgroundColor = '#' + Math.floor(Math.random()*16777215).toString(16);
    newDiv.style.margin = '5px 0';
    newDiv.style.cursor = 'pointer';
    
    // 7.4 appendChild() - menambahkan elemen ke akhir parent
    container.appendChild(newDiv);
    
    // Metode lain untuk menambahkan elemen:
    // 7.5 insertBefore() - menambahkan sebelum elemen tertentu
    // container.insertBefore(newDiv, container.firstChild);
    
    // 7.6 append() - bisa menambahkan multiple nodes/strings sekaligus
    // container.append(newDiv, 'Text', anotherElement);
    
    // 7.7 prepend() - menambahkan di awal
    // container.prepend(newDiv);
    
    // 7.8 insertAdjacentHTML() - insert HTML ke posisi tertentu
    // container.insertAdjacentHTML('beforeend', '<div>New HTML</div>');
    // Positions: 'beforebegin', 'afterbegin', 'beforeend', 'afterend'
    
    // 7.9 insertAdjacentElement() - insert element ke posisi tertentu
    // container.insertAdjacentElement('beforeend', newDiv);
    
    console.log("Element added");
}

function hapusElemen() {
    const container = document.getElementById('container');
    
    if (container.children.length > 0) {
        // 7.10 removeChild() - hapus child element
        container.removeChild(container.lastChild);
        
        // 7.11 remove() - hapus elemen itu sendiri (modern way)
        // container.lastChild.remove();
        
        // 7.12 replaceChild() - ganti child element
        // container.replaceChild(newElement, oldElement);
        
        console.log("Element removed");
    } else {
        alert("Tidak ada element untuk dihapus");
    }
}

// ============================================
// 8. TRAVERSING DOM (NAVIGASI)
// ============================================

function traverseDOM() {
    const target = document.getElementById('targetChild');
    const result = document.getElementById('traverseResult');
    let output = [];
    
    // 8.1 parentElement / parentNode - akses parent
    const parent = target.parentElement;
    output.push(`Parent ID: ${parent.id}`);
    
    // 8.2 children - akses semua child elements (HTMLCollection)
    const parentChildren = parent.children;
    output.push(`Parent has ${parentChildren.length} children`);
    
    // 8.3 childNodes - akses semua child nodes termasuk text nodes (NodeList)
    // const allNodes = parent.childNodes;
    
    // 8.4 firstElementChild / lastElementChild
    output.push(`First child: ${parent.firstElementChild.textContent}`);
    output.push(`Last child: ${parent.lastElementChild.textContent}`);
    
    // 8.5 nextElementSibling / previousElementSibling
    if (target.previousElementSibling) {
        output.push(`Previous sibling: ${target.previousElementSibling.textContent}`);
    }
    if (target.nextElementSibling) {
        output.push(`Next sibling: ${target.nextElementSibling.textContent}`);
    }
    
    // 8.6 closest() - cari parent terdekat yang match selector
    const closestSection = target.closest('.section');
    output.push(`Closest .section found: ${closestSection ? 'Yes' : 'No'}`);
    
    // 8.7 matches() - cek apakah element match selector
    output.push(`Target matches '.child': ${target.matches('.child')}`);
    
    result.innerHTML = output.join('<br>');
    console.log("DOM Traversing:", output);
}

// ============================================
// BONUS: CONTOH PRAKTIS
// ============================================

// Window load event
window.addEventListener('load', function() {
    console.log("Page fully loaded!");
});

// DOMContentLoaded - DOM sudah loaded (lebih cepat dari 'load')
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM Content Loaded!");
});

// Prevent default examples
document.addEventListener('contextmenu', function(e) {
    // Uncomment to disable right-click
    // e.preventDefault();
    // console.log("Right-click disabled");
});

// Stop propagation example
document.querySelector('.section').addEventListener('click', function(e) {
    // e.stopPropagation(); // menghentikan event bubbling
    console.log("Section clicked");
});

console.log("\n=== DOM Samples Ready! ===");
console.log("Klik button-button di halaman untuk melihat demo");
