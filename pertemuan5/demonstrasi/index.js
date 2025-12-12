console.log('Halo, ini adalah file index.js');
let namaLengkap = 'Zaenal Alfian';
console.log(namaLengkap);
var namaLengkap2 = 'Alfian';
console.log(namaLengkap2);
namaLengkap2 = 'Zaenal';
namaLengkap = 'Alfian Zaenal';
console.log(namaLengkap2);
console.log(namaLengkap);

const PHI = 3.14;
console.log(PHI);

let konfirmasi = true;
console.log(konfirmasi);
konfirmasi = false;
console.log(konfirmasi);

let nomor1 = 10; // ini operator assignment (penugasan)
let nomor2 = 2;
let hasil = nomor1 % nomor2; // modulus: sisa bagi
console.log(hasil);
/*
10 dibagi 2 = 5 sisa 0
13 dibagi 4 = 3 sisa 1
 */

nomor1 = 13;
hasil = nomor1 % nomor2;
console.log(hasil);

nomor1 += 5; // nomor1 = nomor1 + 5
console.log(nomor1);
nomor1 %= nomor2; // nomor1 = nomor1 % 4

let x = 10;
let y = 5;

// operator perbandingan
let lebihBesar = x > y;
console.log(lebihBesar); // true
let banding = x >= y;
console.log(banding);

let nilai = lebihBesar && banding; // operator logika AND
console.log(nilai);
let nilai2 = lebihBesar || banding; // operator logika OR
console.log(nilai2);

// CONCATENATION
let kalimat1 = 'Halo';
let kalimat2 = namaLengkap;
let concat = kalimat1 + ', ' + kalimat2;
console.log(concat);

// CONTROL FLOW
let angka = 7;
if (angka % 2 === 0) {
    console.log(angka + ' adalah bilangan genap');
} else {
    console.log(angka + ' adalah bilangan ganjil');
}

nilai = 40;
if (nilai >= 90 && nilai <= 100) {
    console.log('Nilai A');
} else if (nilai >= 80 && nilai < 90) {
    console.log('Nilai B');
} else if (nilai >= 70 && nilai < 80) {
    console.log('Nilai C');
} else if (nilai >= 60 && nilai < 70) {
    console.log('Nilai D');
} else {
    console.log('Nilai E');
}

let hari = 7;
switch (hari) {
    case 1: // FALSE
      console.log('Senin');
    break;
    case 2: // FALSE
      console.log('Selasa');
    break;
    case 3: // FALSE
      console.log('Rabu');
    break;
    case 4: // FALSE
      console.log('Kamis');
    break;
    case 5: // FALSE
      console.log('Jumat');
    break;
    case 6: // FALSE
      console.log('Sabtu');
    break;
    case 7: // TRUE
      console.log('Minggu');
    break;
    default:
      console.log('Hari tidak valid');
}
