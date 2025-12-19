// let nomor = [1, 2, 3, 4, 5];
// console.log(nomor);
// console.log(nomor[3]);

// let buah = ["jeruk", "mangga", "pisang", "apel"];
// console.log(buah);
// console.log(buah[1]);

// buah.push("semangka") // menambah item di akhir array
// console.log(buah);

// // Perulangan pada array dengan for
// for (let i = 0; i < buah.length; i++) {
//   console.log("Buah ke-" + i + " adalah " + buah[i]);
// }

// FUNGSI SEDERHANA
function sapa() { // parameter kosong
  console.log("Halo, selamat datang!"); // tanpa return
}

sapa();

function tambah(a, b) { // dengan parameter
  return a + b; // dengan return
}

let hasil = tambah(5, 10); // parameter diisi argumen
console.log("Hasil penjumlahan: " + hasil);
console.log("Hasil penjumlahan langsung: " + tambah(20, 30));
let hasil2 = tambah("2", 5);
console.log("Hasil penjumlahan string dan number: " + hasil2);