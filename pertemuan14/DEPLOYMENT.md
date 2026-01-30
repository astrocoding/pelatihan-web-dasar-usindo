# PHP Native Inventory System Deployment Guide

**Tech Stack**
- PHP 8.2 (Native)
- Nginx
- MariaDB / MySQL
- HTML5, CSS3
- Ubuntu Linux (VPS)

Deployment dilakukan **tanpa Docker**, fokus pada **cara paling mudah, stabil, dan production-ready**.

---

## 1. Prasyarat
- VPS Ubuntu 20.04/22.04
- SSH root/sudo
- Domain & subdomain aktif (misal: inventaris.example.com, pma.example.com)

## 2. Update Sistem
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install curl unzip software-properties-common -y
```

## 3. Install Nginx
```bash
sudo apt install nginx -y
sudo systemctl enable nginx
sudo systemctl start nginx
```
Cek: http://IP_VPS

## 4. Install PHP 8.2 + Extensions
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.2-fpm php8.2-cli php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip -y
php -v
```

## 5. Install MariaDB
```bash
sudo apt install mariadb-server mariadb-client -y
sudo systemctl enable mariadb
sudo systemctl start mariadb
sudo mysql_secure_installation
```
Ikuti rekomendasi keamanan (set root password, hapus user anonymous, dsb).

## 6. Buat Database & User
```sql
sudo mysql -u root -p
CREATE DATABASE inventaris_db;
CREATE USER 'inventaris_user'@'localhost' IDENTIFIED BY 'password_kuat';
GRANT ALL PRIVILEGES ON inventaris_db.* TO 'inventaris_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## 7. Import Database
```bash
mysql -u inventaris_user -p inventaris_db < /path/to/inventaris_db.sql
```

## 8. Install phpMyAdmin
```bash
sudo apt install phpmyadmin -y
```
- Web server selection: none
- Configure database: YES

## 9. Struktur Project
```bash
sudo mkdir -p /var/www/inventaris
sudo chown -R $USER:www-data /var/www/inventaris
sudo chmod -R 755 /var/www/inventaris
```
Copy semua file project ke /var/www/inventaris

## 10. Konfigurasi Database PHP
Edit file koneksi.php sesuai user/password/database yang dibuat.

## 11. Konfigurasi Nginx (Aplikasi)
Buat file konfigurasi:
```bash
sudo nano /etc/nginx/sites-available/inventaris.example.com
```
Isi:
```
server {
    listen 80;
    server_name inventaris.example.com;

    root /var/www/inventaris;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```
Aktifkan:
```bash
sudo ln -s /etc/nginx/sites-available/inventaris.example.com /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 12. Konfigurasi Nginx (phpMyAdmin Subdomain)
Buat file konfigurasi:
```bash
sudo nano /etc/nginx/sites-available/pma.example.com
```
Isi:
```
server {
    listen 80;
    server_name pma.example.com;

    root /usr/share/phpmyadmin;
    index index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
}
```
Aktifkan:
```bash
sudo ln -s /etc/nginx/sites-available/pma.example.com /etc/nginx/sites-enabled/
sudo systemctl reload nginx
```

## 13. DNS Setup
Tambahkan A Record:
- inventaris.example.com → IP_VPS
- pma.example.com → IP_VPS

## 14. SSL (HTTPS) dengan Certbot
Install certbot:
```bash
sudo apt install certbot python3-certbot-nginx -y
```
Generate SSL untuk domain dan subdomain:
```bash
sudo certbot --nginx -d inventaris.example.com -d pma.example.com
```
- Ikuti instruksi, pilih redirect HTTP ke HTTPS jika diminta.

Test auto-renewal:
```bash
sudo certbot renew --dry-run
```

## 15. Firewall
```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

---

Setelah semua langkah di atas, aplikasi dan phpMyAdmin akan bisa diakses secara publik melalui subdomain masing-masing dengan HTTPS. Jika ada kendala spesifik, silakan tanyakan!
