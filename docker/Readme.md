# 🚀 Docker My Project Stack

> 🇪🇸 **¿Hablas español?**  
> You can find a fully translated and detailed version of this internal documentation in [Spanish](./Readme.es.md), including all configuration steps and usage tips.  
> _Switch to Spanish for a more comfortable reading experience!_

Complete development environment for modern web applications using **Docker Compose**. Optimized for frameworks like **Laravel** and **CodeIgniter** with integrated development tools.

[![Docker](https://img.shields.io/badge/Docker-20.10+-blue.svg)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-purple.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://mysql.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue.svg)](https://postgresql.org/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green.svg)](https://nginx.org/)

---

## 📋 Table of Contents

### 🚀 [Quick Start](#-quick-start-1)

-   [✨ Features](#-features)
-   [🔧 Requirements](#-requirements)
-   [⚡ Quick Installation](#-quick-installation)
-   [🧩 Included Services](#-included-services)

### ⚙️ [Configuration](#️-configuration-1)

-   [📁 Project Structure](#-project-structure)
-   [🔧 Environment Variables](#-environment-variables)
-   [🎯 Framework Configuration](#-framework-configuration)
-   [🔒 SSL Certificates](#-ssl-certificates)

### 💻 [Daily Development](#-daily-development-1)

-   [👨‍💻 Basic Commands](#-basic-commands)
-   [🐞 Debugging with Xdebug](#-debugging-with-xdebug)
-   [📑 Log Management](#-log-management)
-   [🔧 Advanced Commands](#-advanced-commands)

### 🗄️ [Database Management](#️-database-management-1)

-   [💾 MySQL](#-mysql)
-   [🐘 PostgreSQL](#-postgresql)
-   [🔄 Automatic Backups](#-automatic-backups)
-   [🗄️ Shared Database](#️-shared-database)

### 🔧 [Advanced Configuration](#-advanced-configuration-1)

-   [🔄 Multiple Projects](#-multiple-projects)
-   [⚡ Performance Optimization](#-performance-optimization)
-   [🚨 Troubleshooting](#-troubleshooting)

### 📚 [Additional Resources](#-additional-resources-1)

-   [🤝 Contributions](#-contributions)
-   [👨‍💻 Author](#-author)

---

## 🚀 Quick Start

### ✨ Features

-   🐳 **Fully dockerized environment** - No local dependencies
-   🔧 **Automatic configuration** - Ready to use in minutes
-   🐞 **Integrated debugging** - Xdebug preconfigured
-   🔄 **Automatic backups** - MySQL and PostgreSQL with daily backup
-   🔒 **Local HTTPS** - Self-signed SSL certificates
-   📊 **Visual management** - phpMyAdmin and pgAdmin included
-   🎯 **Multi-framework** - Laravel, CodeIgniter 3/4
-   🚀 **High performance** - Optimized Nginx + PHP-FPM
-   🗄️ **Multiple databases** - MySQL and PostgreSQL available
-   🔗 **Shared MySQL** - One MySQL server for multiple projects

### 🔧 Requirements

-   **Docker** (version 20.10 or higher)
-   **Docker Compose** (version 2.0 or higher)
-   **Git**
-   **VS Code** (recommended for debugging)

#### Verify installation

```bash
docker --version
docker compose version
```

### ⚡ Quick Installation

#### 1. Clone and configure

```bash
# Clone repository
git clone https://github.com/Jsrivero22/docker-php-nginx-mysql-postgres

# Copy environment variables
cp .env.example .env
```

#### 2. Create external network (first time only)

> ⚠️ **Important:**  
> If your `docker-compose.yaml` uses an external network (e.g., `networks: default: external: name: my_project_network_mysql`), **you must create it manually before running `docker compose up` or `build`**.  
> If you don't, Docker will show an error and won't start the services.  
> If you don't define an external network, Docker will automatically create a default internal network.

```bash
docker network create my_project_network_mysql
```

> **💡 Note:** You only need to do this once, even if you have multiple projects.

#### 3. Customize configuration (optional)

Edit the `.env` file to change ports, passwords, or service names according to your needs.

#### 4. Start the environment

```bash
# First time (builds images)
docker compose up --build -d

# Verify everything is working
docker compose ps
```

#### 5. Access services

-   **🌐 Application:** [http://localhost:8001](http://localhost:8001)
-   **🔒 HTTPS Application:** [https://localhost:8441](https://localhost:8441)
-   **📊 phpMyAdmin:** [http://localhost:8081](http://localhost:8081)
-   **🐘 pgAdmin:** [http://localhost:8082](http://localhost:8082)

### 🧩 Included Services

| Service               | Version | Port      | Description                                     |
| --------------------- | ------- | --------- | ----------------------------------------------- |
| **PHP-FPM**           | 8.1.32  | -         | Backend with extensions for Laravel/CodeIgniter |
| **Nginx**             | 1.28    | 8001/8441 | High-performance web server (HTTP/HTTPS)        |
| **MySQL**             | 8.0     | 3306      | Relational database                             |
| **PostgreSQL**        | 15      | 5432      | Advanced relational database                    |
| **phpMyAdmin**        | Latest  | 8081      | Web interface for MySQL                         |
| **pgAdmin**           | Latest  | 8082      | Web interface for PostgreSQL                    |
| **MySQL Backup**      | -       | -         | Daily automatic backups                         |
| **PostgreSQL Backup** | -       | -         | Daily automatic backups                         |

#### 🔧 Included PHP extensions

-   **Xdebug** - Debugging and profiling
-   **PDO MySQL/PostgreSQL** - Database connection
-   **Composer** - Dependency manager
-   **GD, ZIP, CURL** - Essential utilities
-   And many more...

---

## ⚙️ Configuration

### 📁 Project Structure

```
docker-compiler-nginx-mysql/
│
├── docker/         # Docker configuration
│   ├── docker-compose.yaml     # Service orchestration
│   ├── .env.example            # Example environment variables
│   ├── .env                    # Environment variables (local)
│   │
│   ├── nginx/                  # Nginx configuration
│   │   ├── nginx.conf          # Main configuration
│   │   └── certs/              # SSL certificates
│   │       ├── localhost.crt
│   │       └── localhost.key
│   │
│   ├── php/                    # PHP configuration
│   │   └── DockerFile          # Custom PHP image
│   │
│   ├── mysql/                  # MySQL configuration
│   │   ├── init.sql            # Initialization script
│   │   └── backups/            # Automatic backups
│   │       └── *.sql.gz
│   │
│   ├── postgresql/             # PostgreSQL configuration
│   │   ├── init.sql            # Initialization script
│   │   └── backups/            # Automatic backups
│   │       └── *.sql
│   │
│   └── readme.md               # This file
│
├── (source code in root)
│   ├── index.php               # For CodeIgniter 3
│   ├── public/                 # For Laravel/CodeIgniter 4
│   │   └── index.php
│   ├── .vscode/                # VS Code configuration for debugging
│   │   └── launch.json
│   └── ...
```

### 🔧 Environment Variables

#### Main variables from `.env` file

```env
# === APPLICATION ===
APP_SERVICE_NAME=my-project-nginx-app

# === PORTS ===
NGINX_PORT=8001
NGINX_SSL_PORT=8441
PHPMYADMIN_PORT=8081
PGADMIN_PORT=8082

# === MYSQL ===
MYSQL_HOST=mysql
MYSQL_ROOT_PASSWORD=password
MYSQL_USER=adminmysqldocker
MYSQL_PASSWORD=password_enviroment
MYSQL_DATABASE=my_project

# === POSTGRESQL ===
POSTGRES_HOST=postgresql
POSTGRES_USER=adminpostgresdocker
POSTGRES_PASSWORD=password_enviroment
POSTGRES_DB=my-project

# === XDEBUG ===
XDEBUG_MODE=develop,debug
XDEBUG_CLIENT_PORT=9003
```

## 🚀 PHP Framework Installation in Docker

> ⚠️ **IMPORTANT:**  
> Do not install PHP, Composer, or Laravel installer on your local machine.  
> Everything should be done **inside the Docker container** to keep your environment clean and reproducible.

### Laravel

1. **Start containers (if you haven't already):**

    ```bash
    docker compose up -d
    ```

2. **Access PHP container:**

    ```bash
    docker compose exec app bash
    ```

3. **Install Laravel in desired folder (e.g., `testing_laravel`):**

    ```bash
    composer create-project laravel/laravel testing_laravel
    ```

    > If you want to install Laravel in the project root, use a dot:
    >
    > ```bash
    > composer create-project laravel/laravel .
    > ```

4. **Adjust Nginx root:**  
   If you installed Laravel in a subfolder, edit `nginx/nginx.conf`:

    ```nginx
    root /var/www/testing_laravel/public;
    ```

    If it's in the root:

    ```nginx
    root /var/www/public;
    ```

5. **Restart Nginx to apply changes:**

    ```bash
    docker compose restart nginx
    ```

6. **Access your application:**
    - HTTP: [http://localhost:8001](http://localhost:8001)
    - HTTPS: [https://localhost:8441](https://localhost:8441)

---

### CodeIgniter 4

1. **Start containers (if you haven't already):**

    ```bash
    docker compose up -d
    ```

2. **Access PHP container:**

    ```bash
    docker compose exec app bash
    ```

3. **Install CodeIgniter 4 in desired folder (e.g., `ci4`):**

    ```bash
    composer create-project codeigniter4/appstarter ci4
    ```

4. **Adjust Nginx root:**  
   If you installed CodeIgniter in a subfolder, edit `nginx/nginx.conf`:

    ```nginx
    root /var/www/ci4/public;
    ```

    If it's in the root:

    ```nginx
    root /var/www/public;
    ```

5. **Restart Nginx to apply changes:**

    ```bash
    docker compose restart nginx
    ```

6. **Access your application:**
    - HTTP: [http://localhost:8001](http://localhost:8001)
    - HTTPS: [https://localhost:8441](https://localhost:8441)

---

### Additional notes

-   **Don't use `laravel new` or Laravel global installer** inside Docker. Always use `composer create-project`.
-   **Files created inside the container will appear in your local folder** thanks to Docker volumes.
-   If you need to compile frontend assets (Vite, npm), install Node inside the container or use a separate container for frontend.

---

> For more details about folder structure and Nginx configuration, check the [Framework Configuration](#-framework-configuration) and [Project Structure](#-project-structure) sections.

### 🎯 Framework Configuration

> ⚠️ **IMPORTANT:**  
> If you use CodeIgniter 3 or any framework that has `index.php` in the project root (not in `/public`), you must edit `nginx/nginx.conf` and change the line:
>
> ```
> root /var/www/public;
> ```
>
> to:
>
> ```
> root /var/www;
> ```
>
> Otherwise, your application will not be served correctly.

#### CodeIgniter 3

```nginx
# In nginx.conf
root /var/www;
index index.php;
```

**Expected structure:**

```
├── application/
├── system/
├── index.php          # In the root
└── ...
```

#### CodeIgniter 4 / Laravel

```nginx
# In nginx.conf
root /var/www/public;
index index.php;
```

**Expected structure:**

```
├── app/
├── public/
│   └── index.php      # Entry point
├── vendor/
└── ...
```

#### 📁 Code in subfolder

If your source code **is not in the repository root**:

1. **Edit volume in `docker-compose.yaml`:**

    ```yaml
    # If your code is in src/
    volumes:
        - ../src:/var/www/
    ```

2. **Adjust `root` directive in `nginx.conf`:**
    - For Laravel in `src/`: `root /var/www/public;`
    - For Laravel in `src/public`: `root /var/www/src/public;`

**Apply changes:**

```bash
docker compose restart nginx
```

### 🔒 SSL Certificates

#### Generate self-signed certificate

```bash
# 1. Create directory for certificates
cd docker/nginx
mkdir -p certs

# 2. Generate certificate and private key
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout certs/localhost.key \
  -out certs/localhost.crt \
  -subj "/C=US/ST=State/L=City/O=Dev/OU=Dev/CN=localhost"

# 3. (Optional) Generate Diffie-Hellman parameters
openssl dhparam -out certs/dhparam.pem 2048
```

#### Configure Nginx

Make sure your `nginx.conf` includes:

```nginx
server {
    listen 443 ssl http2;
    server_name localhost;

    ssl_certificate     /etc/nginx/certs/localhost.crt;
    ssl_certificate_key /etc/nginx/certs/localhost.key;

    # Modern SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # ... rest of configuration
}
```

**Access:** [https://localhost:8441](https://localhost:8441)

> **Note:** Browser will show security warning (normal for self-signed certificates).

---

## 💻 Daily Development

### 👨‍💻 Basic Commands

```bash
# Start services
docker compose up -d

# Stop services
docker compose down

# Restart services
docker compose restart

# View container status
docker compose ps

# View logs in real time
docker compose logs -f
```

### 🐞 Debugging with Xdebug

#### VS Code Configuration

1. **Install extension:** PHP Debug by Xdebug
2. **Create `.vscode/launch.json` file:**

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www": "${workspaceFolder}"
            },
            "ignore": ["**/vendor/**/*.php"]
        }
    ]
}
```

#### Using Xdebug

1. **Place breakpoints** in your PHP code
2. **Start debugger** in VS Code (F5)
3. **Access your application** in browser
4. **Debugger will activate** automatically

#### ⚠️ Multiple Projects and Xdebug

If you have several projects running simultaneously, use **different ports**:

**In your `.env`:**

```env
XDEBUG_CLIENT_PORT=9004
```

**In `php/xdebug/xdebug.ini`:**

```ini
xdebug.client_port=9004
```

### 📑 Log Management

#### View logs

```bash
# All services logs
docker compose logs -f

# Specific service logs
docker compose logs -f nginx
docker compose logs -f app
docker compose logs -f mysql

# Logs with timestamps
docker compose logs -f -t nginx
```

#### Nginx logs

```bash
# Real-time logs
docker compose exec nginx tail -f /var/log/nginx/access.log
docker compose exec nginx tail -f /var/log/nginx/error.log

# Search for specific errors
docker compose exec nginx grep "ERROR" /var/log/nginx/error.log

# Clear logs (development)
docker compose exec nginx sh -c "truncate -s 0 /var/log/nginx/*.log"
```

#### Export logs

```bash
# Download logs to your machine
docker compose cp nginx:/var/log/nginx/error.log ./nginx-error.log

# Logs with specific date
docker compose logs --since "2024-01-01" --until "2024-01-02" > logs_january.txt
```

### 🔧 Advanced Commands

#### Container management

```bash
# Enter PHP container
docker compose exec app sh

# Enter MySQL container
docker compose exec mysql bash

# Install/update dependencies
docker compose exec app composer install
docker compose exec app composer update

# Laravel commands
docker compose exec app php artisan migrate
docker compose exec app php artisan cache:clear

# CodeIgniter 4 commands
docker compose exec app php spark migrate
docker compose exec app php spark cache:clear
```

#### File and permission management

```bash
# Fix permissions
sudo chown -R $USER:$USER .

# Change permissions inside container
docker compose exec app chown -R www-data:www-data /var/www/storage
docker compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
```

#### Cleanup and maintenance

```bash
# Rebuild containers
docker compose build --no-cache
docker compose up --build -d

# Clean volumes (⚠️ Deletes DB data)
docker compose down -v

# Clean unused images
docker image prune -f
```

---

## 🗄️ Database Management

### 💾 MySQL

#### 🟢 Activate optional services

To use MySQL and phpMyAdmin:

1. Uncomment the `mysql` and `phpmyadmin` blocks in `docker-compose.yaml`.
2. Start services:
    ```bash
    docker compose up -d
    ```

#### Access via phpMyAdmin

-   **URL:** [http://localhost:8081](http://localhost:8081)
-   **User:** `root`
-   **Password:** `password`

#### Command line access

```bash
# Access as root
docker compose exec mysql mysql -uroot -ppassword my_project

# Access as regular user
docker compose exec mysql mysql -uadminmysqldocker -ppassword_enviroment my_project
```

### 🐘 PostgreSQL

#### Access via pgAdmin

-   **URL:** [http://localhost:8082](http://localhost:8082)
-   **Email:** `admin@admin.com`
-   **Password:** `admin123`

#### Register PostgreSQL server in pgAdmin

-   **Host name/address:** `postgresql`
-   **Port:** `5432`
-   **Maintenance database:** `postgres` or `my-project`
-   **Username:** `adminpostgresdocker`
-   **Password:** `password_enviroment`

#### Command line access

```bash
# Direct access
docker compose exec postgresql psql -U adminpostgresdocker -d my-project
```

### 🔄 Automatic Backups

#### MySQL - Automatic backups

Backups are created automatically every day at **5:00 PM**.

**Location:** `docker/mysql/backups/`  
**Format:** `YYYYMMDDHHMM.databasename.sql.gz`

##### Create manual backup

```bash
# Complete backup
docker compose run --rm mysql-backup /backup.sh

# Specific backup
docker compose exec mysql mysqldump -uroot -ppassword my_project | gzip > manual_backup.sql.gz
```

##### Restore backup

```bash
# 1. Decompress file
gunzip docker/mysql/backups/202506090224.my_project.sql.gz

# 2. Restore to database
docker compose exec -T mysql mysql -uroot -ppassword my_project < docker/mysql/backups/202506090224.my_project.sql

# 3. Verify restoration
docker compose exec mysql mysql -uroot -ppassword -e "SHOW TABLES;" my_project
```

#### PostgreSQL - Automatic backups

Backups are created automatically every day at **5:00 PM**.

**Location:** `docker/postgresql/backups/`  
**Format:** `YYYYMMDDHHMM.my-project.sql.gz`

##### Create manual backup

```bash
docker compose exec postgresql pg_dump -U adminpostgresdocker -d my-project > ./postgresql/backups/manual-backup.sql
```

##### Restore backup

```bash
# Decompress if necessary
gunzip docker/postgresql/backups/202506211700.my-project.sql.gz

# Restore
docker compose exec -T postgresql psql -U adminpostgresdocker -d my-project < docker/postgresql/backups/202506211700.my-project.sql
```

### 🗄️ Shared Database

If you have **multiple projects** that need access to the **same MySQL database**, you can share the container:

> 💾 **Note about persistence:**  
> If you want MySQL data to persist between restarts, uncomment the volumes section in the `mysql` block of `docker-compose.yaml`:
>
> ```yaml
> volumes:
>     - ${MYSQL_DATA_VOLUME}:/var/lib/mysql
> ```

#### Configuration for shared MySQL

##### 1. Only one main project

-   Define `mysql`, `phpmyadmin`, `mysql-backup` services only in one "main" project
-   Other projects should NOT declare the `mysql` service

##### 2. Shared external network

```bash
# Create network (only once)
docker network create my_project_network_mysql
```

In each `docker-compose.yaml`:

```yaml
networks:
    default:
        external:
            name: my_project_network_mysql
```

##### 3. Configure host in all projects

In all `.env` files:

```env
MYSQL_HOST=mysql
```

##### 4. Separate databases

Each project can use its own database:

```env
MYSQL_DATABASE=my_database_name
```

#### Advantages of shared MySQL

-   **Resource savings** - Single MySQL container
-   **Shared data** - Easy access between projects
-   **Centralized management** - Single phpMyAdmin and backups
-   **No port conflicts** - Avoids configuration issues

---

## 🔧 Advanced Configuration

### 🔄 Multiple Projects

#### Variables to change

```env
# Service names (avoid conflicts)
APP_SERVICE_NAME=new-project
NGINX_SERVICE_NAME=nginx-new-project

# Ports (avoid conflicts)
NGINX_PORT=8002
NGINX_SSL_PORT=8442
PHPMYADMIN_PORT=8082

# Database
MYSQL_DATABASE=new_project_db

# Xdebug (if you have multiple projects)
XDEBUG_CLIENT_PORT=9004
```

#### Multiple project management

```bash
# View all containers
docker ps -a

# Stop specific project
cd docker && docker compose down

# List Docker networks
docker network ls

# Clean unused resources
docker system prune -f
```

### ⚡ Performance Optimization

#### PHP-FPM configuration

```ini
# Optimize for development
pm.max_children = 10
pm.start_servers = 4
pm.min_spare_servers = 2
pm.max_spare_servers = 6
```

#### MySQL configuration

```cnf
# my.cnf basic optimizations
innodb_buffer_pool_size = 256M
query_cache_size = 32M
max_connections = 100
```

#### Resource monitoring

```bash
# View resource usage
docker stats

# View specific usage per container
docker stats docker-my-project-app-1
```

### 🚨 Troubleshooting

#### 🔌 Port occupied

```bash
# Error: "port is already allocated"
# Solution: Change ports in .env
NGINX_PORT=8002
NGINX_SSL_PORT=8442

# Check which process uses the port
sudo lsof -i :8001
```

#### 📁 File permissions

```bash
# Problem: "Permission denied"
# Solution: Fix permissions
sudo chown -R $USER:$USER .
docker compose exec app chown -R www-data:www-data /var/www/storage
```

#### 🗄️ Database connection error

```bash
# MySQL - Verify it's running
docker compose exec mysql mysqladmin ping -h localhost

# PostgreSQL - Verify connection
docker compose exec postgresql pg_isready -U adminpostgresdocker

# View database logs
docker compose logs mysql
docker compose logs postgresql

# Recreate containers (⚠️ Deletes data)
docker compose down -v
docker compose up -d
```

#### 🐞 Xdebug not working

```bash
# Verify configuration
docker compose exec app php -i | grep xdebug

# Check available port
sudo lsof -i :9003

# Restart PHP service
docker compose restart app
```

#### 🌐 Nginx won't start

```bash
# Verify configuration syntax
docker compose exec nginx nginx -t

# View detailed logs
docker compose logs nginx

# Validate SSL certificates
openssl x509 -in nginx/certs/localhost.crt -text -noout
```

#### 🔍 Diagnostic commands

```bash
# General system status
docker system df
docker system events

# Detailed container information
docker compose exec app php --ini
docker compose exec mysql mysql --version
docker compose exec nginx nginx -V

# Verify connectivity between services
docker compose exec app ping mysql
docker compose exec app ping postgresql
```

#### 🔄 Recreate complete environment

```bash
# Steps to start from scratch (⚠️ Deletes all data)
docker compose down -v
docker image prune -a -f
docker volume prune -f
docker network prune -f

# Rebuild everything
docker compose build --no-cache
docker compose up -d
```

---

### ⚠️ Special Note: File Permissions on Windows (Laravel & SQLite)

If you use **Windows + Docker Desktop** for Laravel, you may encounter "Permission denied" or "readonly database" errors, even if everything works fine on Linux.

#### Common errors

-   `file_put_contents(...): Failed to open stream: Permission denied`
-   `SQLSTATE[HY000]: General error: 8 attempt to write a readonly database`

#### Why does this happen?

-   On **Linux**, file permissions are preserved between your host and the container.
-   On **Windows**, Docker mounts volumes differently, and permissions may not be correctly mapped for the `www-data` user (used by PHP-FPM).

#### Solution for Laravel (storage/cache)

Inside the PHP container, run:

```sh
cd /var/www/your_project
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

#### Solution for SQLite

1. Check the path to your SQLite file (usually `database/database.sqlite`).
2. Inside the PHP container, run:

```sh
cd /var/www/your_project
touch database/database.sqlite
chown -R www-data:www-data database
chmod -R 775 database
```

#### If you are on Windows and still have issues:

-   Make sure your editor or antivirus is **not locking files**.
-   Ensure Docker Desktop has **full access** to your project folder.
-   As a last resort (for development only), you can use `chmod -R 777` on the affected folders.

#### Solution for CodeIgniter 4 (`writable/`)

If you use CodeIgniter 4, the `writable/` folder **must be owned by `www-data` and writable**. On Windows + Docker, this can fail and cause 500 errors or issues saving files/logs.

Inside the PHP container, run:

```sh
cd /var/www/your_project
chown -R www-data:www-data writable
chmod -R 775 writable
```

> **Note:** On Ubuntu/Linux this is usually not needed, but on Windows it is essential to avoid permission errors.

---

**Summary:**  
If you see permission errors, always check and fix permissions inside the container.  
This is a common issue on Windows, but easily solved with the above commands.

---

## 📚 Additional Resources

> **Important note:**  
> Ports `8081` (phpMyAdmin) and `8082` (pgAdmin) are reserved for MySQL and PostgreSQL web administration interfaces, respectively.  
> It's most recommended that your environment uses **only one of the database engines** (MySQL or PostgreSQL) and its respective administration tool.  
> If you decide to run both services simultaneously, make sure your project really requires working with both databases, as this may consume more resources and complicate management.
