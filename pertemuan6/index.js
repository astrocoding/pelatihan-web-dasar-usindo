let angka1;
angka1 = "Nama saya";
console.log(angka1);
angka1 = 100;
angka1 = true;
console.log(angka1);

let nama = "Zaenal"; // ES6 = EcmaScript 6
var fullName = "Alfian";
function name() {
  // nama = "ZEN";
  fullName = "Zaenal Alfian";
  console.log(fullName);
}
console.log(nama);
console.log(fullName);
name();


// PERULANGAN FOR
for (let i = 5; i >= 1; i--) {
  console.log("Perulangan ke-" + i);
}

// while
let x = 1;
while (x <= 5) {
  console.log("While ke-" + x);
  x++; // increment
}

do {
  console.log("Do While ke-" + x);
  x++;
} while (x <= 5);