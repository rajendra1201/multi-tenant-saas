# Installation Guide

Follow these steps to set up the Multi-Tenant SaaS application on your local machine.

## System Requirements

- **PHP**: 8.2 or higher
- **Database**: MySQL 5.7+ or PostgreSQL 10+
- **Web Server**: Apache or Nginx
- **Memory**: Minimum 512MB RAM
- **Storage**: At least 1GB free space

## Quick Start

### 1. Extract and Navigate
```bash
# Extract the downloaded zip file
unzip multi-tenant-saas.zip
cd multi-tenant-saas
```

### 2. Install Dependencies
```bash
# Install Composer dependencies
composer install

# Install NPM dependencies (if using frontend build tools)
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

#### Create Database
```sql
CREATE DATABASE multi_tenant_saas;
```

#### Configure .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multi_tenant_saas
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
# Run central database migrations
php artisan migrate

# Install tenancy package
composer require stancl/tenancy
php artisan tenancy:install
```

### 6. Storage and Cache
```bash
# Create storage link
php artisan storage:link

# Clear and cache config
php artisan config:cache
php artisan route:cache
```

### 7. Start Services
```bash
# Start development server
php artisan serve

# Start queue worker (in another terminal)
php artisan queue:work
```

## Production Deployment

### 1. Server Requirements
- PHP 8.2+ with required extensions
- MySQL 8.0+ or PostgreSQL 12+
- Nginx or Apache web server
- SSL certificate for HTTPS

### 2. Environment Setup
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Configure database
DB_HOST=your_production_host
DB_DATABASE=your_production_db
DB_USERNAME=your_production_user
DB_PASSWORD=your_secure_password
```

### 3. Optimize for Production
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 4. Web Server Configuration

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com *.yourdomain.com;
    root /path/to/multi-tenant-saas/public;

    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### Apache
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias *.yourdomain.com
    DocumentRoot /path/to/multi-tenant-saas/public

    <Directory /path/to/multi-tenant-saas/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 5. Queue Worker (Production)
```bash
# Install supervisor
sudo apt install supervisor

# Create supervisor config
sudo nano /etc/supervisor/conf.d/multi-tenant-saas.conf
```

```ini
[program:multi-tenant-saas-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/multi-tenant-saas/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/multi-tenant-saas/storage/logs/worker.log
```

```bash
# Start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start multi-tenant-saas-worker:*
```

## Troubleshooting

### Permission Issues
```bash
# Set correct permissions
sudo chown -R www-data:www-data /path/to/multi-tenant-saas
sudo chmod -R 755 /path/to/multi-tenant-saas
sudo chmod -R 775 /path/to/multi-tenant-saas/storage
sudo chmod -R 775 /path/to/multi-tenant-saas/bootstrap/cache
```

### Database Connection
```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Clear Cache Issues
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Subdomain Issues
Ensure your DNS is configured to handle wildcard subdomains:
```
A    yourdomain.com    your.server.ip
A    *.yourdomain.com  your.server.ip
```

## Additional Configuration

### OpenAI Integration (Optional)
```env
OPENAI_API_KEY=your-openai-api-key
```

### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### Redis (Optional)
```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

Your application should now be running successfully!
