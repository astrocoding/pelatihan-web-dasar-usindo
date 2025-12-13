// ============================================
// FIBONACCI FUNCTIONS - REUSABLE & EFFICIENT
// Senior Web Developer Implementation
// ============================================

/**
 * METODE 1: Fibonacci Iteratif (RECOMMENDED)
 * Time Complexity: O(n)
 * Space Complexity: O(1)
 * 
 * Paling efisien untuk nilai n yang besar
 * Tidak ada risk stack overflow
 * 
 * @param {number} n - Posisi bilangan Fibonacci (0-based index)
 * @returns {number} Nilai Fibonacci ke-n
 */
function fibonacci(n) {
    if (n < 0) return null;
    if (n === 0) return 0;
    if (n === 1) return 1;
    
    let prev = 0;
    let current = 1;
    
    for (let i = 2; i <= n; i++) {
        const next = prev + current;
        prev = current;
        current = next;
    }
    
    return current;
}

/**
 * METODE 2: Fibonacci Rekursif Sederhana
 * Time Complexity: O(2^n) - SANGAT LAMBAT untuk n besar
 * Space Complexity: O(n)
 * 
 * Elegant tapi tidak efisien
 * Hanya untuk nilai n kecil (< 40)
 * 
 * @param {number} n - Posisi bilangan Fibonacci
 * @returns {number} Nilai Fibonacci ke-n
 */
function fibonacciRecursive(n) {
    if (n < 0) return null;
    if (n === 0) return 0;
    if (n === 1) return 1;
    
    return fibonacciRecursive(n - 1) + fibonacciRecursive(n - 2);
}

/**
 * METODE 3: Fibonacci dengan Memoization (BEST OF BOTH WORLDS)
 * Time Complexity: O(n)
 * Space Complexity: O(n)
 * 
 * Rekursif tapi efisien dengan caching
 * Cocok untuk perhitungan berulang
 */
const fibonacciMemo = (() => {
    const cache = {};
    
    return function fib(n) {
        if (n < 0) return null;
        if (n === 0) return 0;
        if (n === 1) return 1;
        
        // Cek cache terlebih dahulu
        if (cache[n]) return cache[n];
        
        // Hitung dan simpan ke cache
        cache[n] = fib(n - 1) + fib(n - 2);
        return cache[n];
    };
})();

/**
 * METODE 4: Generate Array Fibonacci
 * Menghasilkan array berisi n bilangan Fibonacci pertama
 * 
 * @param {number} count - Jumlah bilangan Fibonacci yang diinginkan
 * @returns {number[]} Array bilangan Fibonacci
 */
function fibonacciSequence(count) {
    if (count <= 0) return [];
    if (count === 1) return [0];
    
    const sequence = [0, 1];
    
    for (let i = 2; i < count; i++) {
        sequence.push(sequence[i - 1] + sequence[i - 2]);
    }
    
    return sequence;
}

/**
 * METODE 5: Fibonacci dengan Generator (ES6+)
 * Memory efficient untuk iterasi
 * 
 * @param {number} count - Jumlah bilangan yang akan di-generate
 */
function* fibonacciGenerator(count = Infinity) {
    let prev = 0;
    let current = 1;
    let counter = 0;
    
    while (counter < count) {
        yield prev;
        [prev, current] = [current, prev + current];
        counter++;
    }
}

/**
 * UTILITY: Cek apakah suatu bilangan adalah Fibonacci
 * 
 * @param {number} num - Bilangan yang akan dicek
 * @returns {boolean} True jika bilangan adalah Fibonacci
 */
function isFibonacci(num) {
    // Sebuah bilangan adalah Fibonacci jika salah satu dari:
    // 5*n^2 + 4 atau 5*n^2 - 4 adalah perfect square
    const isPerfectSquare = (x) => {
        const sqrt = Math.sqrt(x);
        return sqrt === Math.floor(sqrt);
    };
    
    return isPerfectSquare(5 * num * num + 4) || 
           isPerfectSquare(5 * num * num - 4);
}

/**
 * UTILITY: Cari index dari bilangan Fibonacci
 * 
 * @param {number} value - Nilai Fibonacci
 * @returns {number} Index dari bilangan Fibonacci tersebut
 */
function findFibonacciIndex(value) {
    if (value === 0) return 0;
    if (value === 1) return 1;
    
    let prev = 0;
    let current = 1;
    let index = 1;
    
    while (current < value) {
        [prev, current] = [current, prev + current];
        index++;
    }
    
    return current === value ? index : -1;
}

// ============================================
// DEMONSTRASI PENGGUNAAN
// ============================================

console.log("=== FIBONACCI CALCULATOR ===\n");

// 1. Fibonacci Iteratif (Recommended)
console.log("1. Fibonacci Iteratif:");
console.log("fib(0) =", fibonacci(0));   // 0
console.log("fib(1) =", fibonacci(1));   // 1
console.log("fib(5) =", fibonacci(5));   // 5
console.log("fib(10) =", fibonacci(10)); // 55
console.log("fib(20) =", fibonacci(20)); // 6765
console.log("");

// 2. Fibonacci Rekursif (Untuk nilai kecil)
console.log("2. Fibonacci Rekursif:");
console.log("fibRecursive(5) =", fibonacciRecursive(5));   // 5
console.log("fibRecursive(10) =", fibonacciRecursive(10)); // 55
console.log("");

// 3. Fibonacci dengan Memoization
console.log("3. Fibonacci Memoization:");
console.log("fibMemo(20) =", fibonacciMemo(20)); // 6765
console.log("fibMemo(30) =", fibonacciMemo(30)); // 832040
console.log("");

// 4. Generate Sequence
console.log("4. Fibonacci Sequence:");
console.log("First 10:", fibonacciSequence(10));
console.log("First 15:", fibonacciSequence(15));
console.log("");

// 5. Generator
console.log("5. Fibonacci Generator:");
const gen = fibonacciGenerator(10);
const first10 = [];
for (const num of gen) {
    first10.push(num);
}
console.log("First 10 using generator:", first10);
console.log("");

// 6. Utility Functions
console.log("6. Utility Functions:");
console.log("Is 8 Fibonacci?", isFibonacci(8));     // true
console.log("Is 10 Fibonacci?", isFibonacci(10));   // false
console.log("Is 21 Fibonacci?", isFibonacci(21));   // true
console.log("Index of 13:", findFibonacciIndex(13)); // 7
console.log("Index of 89:", findFibonacciIndex(89)); // 11
console.log("");

// ============================================
// PERFORMANCE COMPARISON
// ============================================

console.log("=== PERFORMANCE COMPARISON ===\n");

function measureTime(fn, ...args) {
    const start = performance.now();
    const result = fn(...args);
    const end = performance.now();
    return { result, time: (end - start).toFixed(4) };
}

const n = 30;

console.log(`Calculating Fibonacci(${n}):\n`);

const iterative = measureTime(fibonacci, n);
console.log("Iteratif:", iterative.result, `(${iterative.time}ms)`);

const memo = measureTime(fibonacciMemo, n);
console.log("Memoization:", memo.result, `(${memo.time}ms)`);

// Rekursif terlalu lambat untuk n=30, gunakan n=20
const nSmall = 20;
const recursive = measureTime(fibonacciRecursive, nSmall);
console.log(`Rekursif (n=${nSmall}):`, recursive.result, `(${recursive.time}ms)`);
console.log("");

// ============================================
// USE CASES & EXAMPLES
// ============================================

console.log("=== PRACTICAL USE CASES ===\n");

// Use Case 1: Membuat pola visual Fibonacci
function createFibonacciPattern(count) {
    const sequence = fibonacciSequence(count);
    return sequence.map((num, idx) => `F(${idx}) = ${num}`).join(", ");
}

console.log("Pattern:", createFibonacciPattern(10));
console.log("");

// Use Case 2: Sum of Fibonacci numbers
function sumFibonacci(n) {
    return fibonacciSequence(n).reduce((sum, num) => sum + num, 0);
}

console.log("Sum of first 10 Fibonacci:", sumFibonacci(10)); // 88
console.log("");

// Use Case 3: Even Fibonacci numbers (Problem Euler #2)
function evenFibonacciSum(max) {
    let sum = 0;
    let prev = 0;
    let current = 1;
    
    while (current <= max) {
        if (current % 2 === 0) {
            sum += current;
        }
        [prev, current] = [current, prev + current];
    }
    
    return sum;
}

console.log("Sum of even Fibonacci <= 4000000:", evenFibonacciSum(4000000));
console.log("");

// Use Case 4: Fibonacci dengan custom starting values
function generalizedFibonacci(n, a = 0, b = 1) {
    if (n === 0) return a;
    if (n === 1) return b;
    
    for (let i = 2; i <= n; i++) {
        [a, b] = [b, a + b];
    }
    
    return b;
}

console.log("Standard Fibonacci(10):", generalizedFibonacci(10));      // 55
console.log("Start with (2,1):", generalizedFibonacci(10, 2, 1));       // 123
console.log("Lucas Numbers(10):", generalizedFibonacci(10, 2, 1));      // 123
console.log("");

// ============================================
// BEST PRACTICES & RECOMMENDATIONS
// ============================================

console.log("=== BEST PRACTICES ===\n");
console.log("✅ Use fibonacci() (iterative) for single calculations");
console.log("✅ Use fibonacciMemo() for repeated calculations");
console.log("✅ Use fibonacciSequence() to generate multiple values");
console.log("✅ Use fibonacciGenerator() for memory-efficient iteration");
console.log("❌ Avoid fibonacciRecursive() for n > 40 (too slow)");
console.log("");

// ============================================
// EXPORTS (untuk module usage)
// ============================================

// Jika menggunakan Node.js modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        fibonacci,
        fibonacciRecursive,
        fibonacciMemo,
        fibonacciSequence,
        fibonacciGenerator,
        isFibonacci,
        findFibonacciIndex,
        generalizedFibonacci,
        evenFibonacciSum,
        sumFibonacci
    };
}

console.log("=== SELESAI ===");
console.log("Semua fungsi Fibonacci siap digunakan! 🚀");
