-- Script SQL untuk membuat database dan tabel
-- Jalankan script ini di phpMyAdmin

-- Membuat database
CREATE DATABASE IF NOT EXISTS inventaris_db;

-- Menggunakan database
USE inventaris_db;

-- Membuat tabel barang
CREATE TABLE IF NOT EXISTS items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    lokasi VARCHAR(100) NOT NULL,
    jumlah INT(11) NOT NULL,
    kondisi VARCHAR(20) NOT NULL,
    tanggal_masuk DATE NOT NULL
);

-- Contoh data (opsional)
INSERT INTO items (kode_barang, nama_barang, kategori, lokasi, jumlah, kondisi, tanggal_masuk) VALUES
('BRG001', 'Laptop Dell', 'Elektronik', 'Gudang A', 10, 'Baik', '2026-01-05'),
('BRG002', 'Meja Kantor', 'Furniture', 'Gudang B', 25, 'Baik', '2026-01-06'),
('BRG003', 'Kursi Roda', 'Peralatan', 'Gudang A', 5, 'Rusak', '2026-01-07');
