# Panduan Deployment Sistem Akademik Kampus

## Daftar Isi
1. [Persiapan Server](#persiapan-server)
2. [Instalasi Software](#instalasi-software)
3. [Konfigurasi Web Server](#konfigurasi-web-server)
4. [Deployment Aplikasi](#deployment-aplikasi)
5. [Konfigurasi Database](#konfigurasi-database)
6. [SSL/HTTPS Setup](#sslhttps-setup)
7. [Monitoring & Maintenance](#monitoring--maintenance)
8. [Backup & Recovery](#backup--recovery)

## Persiapan Server

### Requirements Server
- **OS**: Ubuntu 20.04 LTS / CentOS 8 / Debian 11
- **RAM**: Minimum 2GB (Recommended 4GB+)
- **Storage**: Minimum 20GB (Recommended 50GB+)
- **CPU**: 2 cores minimum
- **Network**: Stable internet connection

### Update System
```bash
# Ubuntu/Debian
sudo apt update && sudo apt upgrade -y

# CentOS/RHEL
sudo yum update -y
```

## Instalasi Software

### 1. Install PHP 8.2+
```bash
# Ubuntu/Debian
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-sqlite3 php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath php8.2-intl php8.2-cli

# CentOS/RHEL
sudo yum install epel-release
sudo yum install php php-fpm php-mysql php-xml php-mbstring php-curl php-zip php-gd php-bcmath php-intl
```

### 2. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 3. Install MySQL/MariaDB
```bash
# Ubuntu/Debian
sudo apt install mysql-server

# CentOS/RHEL
sudo yum install mariadb-server mariadb
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

### 4. Install Nginx
```bash
# Ubuntu/Debian
sudo apt install nginx

# CentOS/RHEL
sudo yum install nginx
sudo systemctl start nginx
sudo systemctl enable nginx
```

### 5. Install Git
```bash
# Ubuntu/Debian
sudo apt install git

# CentOS/RHEL
sudo yum install git
```

## Konfigurasi Web Server

### 1. Konfigurasi Nginx
Buat file konfigurasi Nginx:
```bash
sudo nano /etc/nginx/sites-available/sistem-akademik
```

Isi dengan konfigurasi berikut:
```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/sistem-akademik/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan site:
```bash
sudo ln -s /etc/nginx/sites-available/sistem-akademik /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 2. Konfigurasi PHP-FPM
Edit file PHP-FPM:
```bash
sudo nano /etc/php/8.2/fpm/php.ini
```

Ubah konfigurasi berikut:
```ini
upload_max_filesize = 64M
post_max_size = 64M
memory_limit = 256M
max_execution_time = 300
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

## Deployment Aplikasi

### 1. Clone Repository
```bash
cd /var/www
sudo git clone https://github.com/username/sistem-akademik.git
sudo chown -R www-data:www-data sistem-akademik
```

### 2. Install Dependencies
```bash
cd sistem-akademik
composer install --optimize-autoloader --no-dev
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
APP_NAME="Sistem Akademik Kampus"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_akademik
DB_USERNAME=sistem_akademik_user
DB_PASSWORD=strong_password_here

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 5. Setup Database
```bash
# Buat database dan user
mysql -u root -p
```

```sql
CREATE DATABASE sistem_akademik;
CREATE USER 'sistem_akademik_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON sistem_akademik.* TO 'sistem_akademik_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 6. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=MataKuliahSeeder
```

### 7. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/sistem-akademik
sudo chmod -R 755 /var/www/sistem-akademik
sudo chmod -R 775 /var/www/sistem-akademik/storage
sudo chmod -R 775 /var/www/sistem-akademik/bootstrap/cache
```

### 8. Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## SSL/HTTPS Setup

### 1. Install Certbot
```bash
# Ubuntu/Debian
sudo apt install certbot python3-certbot-nginx

# CentOS/RHEL
sudo yum install certbot python3-certbot-nginx
```

### 2. Generate SSL Certificate
```bash
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

### 3. Auto-renewal
```bash
sudo crontab -e
```

Tambahkan baris berikut:
```
0 12 * * * /usr/bin/certbot renew --quiet
```

## Monitoring & Maintenance

### 1. Setup Log Rotation
```bash
sudo nano /etc/logrotate.d/sistem-akademik
```

Isi dengan:
```
/var/www/sistem-akademik/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
}
```

### 2. Setup Cron Jobs
```bash
crontab -e
```

Tambahkan:
```
* * * * * cd /var/www/sistem-akademik && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Monitor Application
```bash
# Check application status
php artisan about

# Check queue status
php artisan queue:work --timeout=60

# Monitor logs
tail -f storage/logs/laravel.log
```

### 4. Performance Monitoring
Install monitoring tools:
```bash
# Install htop
sudo apt install htop

# Install netdata (optional)
bash <(curl -Ss https://my-netdata.io/kickstart.sh)
```

## Backup & Recovery

### 1. Database Backup
Buat script backup:
```bash
sudo nano /root/backup-database.sh
```

Isi dengan:
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/database"
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u sistem_akademik_user -p'strong_password_here' sistem_akademik > $BACKUP_DIR/sistem_akademik_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/sistem_akademik_$DATE.sql

# Keep only last 7 days
find $BACKUP_DIR -name "*.sql.gz" -mtime +7 -delete

echo "Backup completed: sistem_akademik_$DATE.sql.gz"
```

Buat executable dan setup cron:
```bash
chmod +x /root/backup-database.sh
crontab -e
```

Tambahkan:
```
0 2 * * * /root/backup-database.sh
```

### 2. Application Backup
```bash
sudo nano /root/backup-application.sh
```

Isi dengan:
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/application"
SOURCE_DIR="/var/www/sistem-akademik"

mkdir -p $BACKUP_DIR

# Backup application files
tar -czf $BACKUP_DIR/sistem_akademik_$DATE.tar.gz -C /var/www sistem-akademik

# Keep only last 7 days
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Application backup completed: sistem_akademik_$DATE.tar.gz"
```

### 3. Recovery Process
```bash
# Restore database
mysql -u sistem_akademik_user -p sistem_akademik < backup_file.sql

# Restore application
tar -xzf backup_file.tar.gz -C /var/www/
```

## Security Hardening

### 1. Firewall Setup
```bash
# Ubuntu/Debian
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw enable

# CentOS/RHEL
sudo firewall-cmd --permanent --add-service=ssh
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload
```

### 2. Fail2ban Setup
```bash
sudo apt install fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 3. Regular Updates
```bash
# Setup automatic security updates
sudo apt install unattended-upgrades
sudo dpkg-reconfigure -plow unattended-upgrades
```

## Troubleshooting

### Common Issues

#### 1. Permission Denied
```bash
sudo chown -R www-data:www-data /var/www/sistem-akademik
sudo chmod -R 755 /var/www/sistem-akademik
```

#### 2. Database Connection Error
```bash
# Check MySQL status
sudo systemctl status mysql

# Check connection
mysql -u sistem_akademik_user -p -h localhost
```

#### 3. Nginx 502 Bad Gateway
```bash
# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check Nginx error logs
sudo tail -f /var/log/nginx/error.log
```

#### 4. Application Errors
```bash
# Check Laravel logs
tail -f /var/www/sistem-akademik/storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Performance Optimization

### 1. OPcache Configuration
```bash
sudo nano /etc/php/8.2/fpm/conf.d/10-opcache.ini
```

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

### 2. Redis Setup (Optional)
```bash
sudo apt install redis-server
sudo systemctl enable redis-server
```

Update `.env`:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 3. CDN Setup
Untuk static assets, gunakan CDN seperti Cloudflare atau AWS CloudFront.

## Support & Maintenance

### Contact Information
- **Technical Support**: admin@kampus.com
- **Emergency Contact**: +62 812-3456-7890
- **Documentation**: https://docs.kampus.com

### Maintenance Schedule
- **Weekly**: Security updates, log rotation
- **Monthly**: Performance review, backup verification
- **Quarterly**: Full system audit, dependency updates

### Monitoring Tools
- **Server Monitoring**: Netdata, htop
- **Application Monitoring**: Laravel Telescope (development)
- **Error Tracking**: Laravel Logs, custom error reporting 