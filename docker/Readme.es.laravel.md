# 🚀 Docker PHP Nginx MySQL PostgreSQL Environment for Laravel 12

> Este repositorio proporciona un entorno Docker preconfigurado para desarrollar aplicaciones PHP (Laravel) con Nginx, MySQL y PostgreSQL.  
> Hemos preparado una versión completamente traducida y detallada de esta documentación en [inglés](./Readme.md), para que sigas cada paso, consejo y buena práctica en tu idioma preferido.  
> _¡Cámbiate al inglés si te resulta más cómodo!_

[![Docker](https://img.shields.io/badge/Docker-20.10%2B-blue?logo=docker)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-purple?logo=php)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)](https://mysql.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-blue?logo=postgresql)](https://postgresql.org/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green?logo=nginx)](https://nginx.org/)

> **Stack de desarrollo Dockerizado para aplicaciones PHP modernas con Nginx, MySQL, PostgreSQL, Xdebug, phpMyAdmin y pgAdmin.**  
> Soporta proyectos **Laravel**, **CodeIgniter 3/4** y otros frameworks PHP. Ideal para entornos multi-proyecto y pruebas de stack.


## Prerrequisitos
- Docker instalado en tu sistema
- Docker Compose (normalmente viene con Docker Desktop)

## Instalación y Configuración

Sigue estos pasos para configurar tu entorno de desarrollo:
1. **Clonar el repositorio:**

```bash
git clone https://github.com/Jsrivero22/docker-php-nginx-mysql-postgres.git
```
```bash
cd docker-php-nginx-mysql-postgres
```

2. **Crear la red de Docker (solo primera vez):**
```bash
docker network create my_project_network_mysql
```

3. **Construir y levantar los contenedores (solo primera vez):**
```bash
docker compose up --build -d
```
Para ejecuciones posteriores:
```bash
docker compose up -d
```

4. **Verificar el estado de los contenedores:**
```bash
docker compose ps
```

5. **Acceder al contenedor de la aplicación:**
```bash
docker compose exec app bash
```

6. **Dentro del contenedor, crear un nuevo proyecto Laravel o clonar uno existente:**
```bash
# Crear nuevo proyecto
laravel new nombre-proyecto

# O clonar proyecto existente
git clone https://github.com/tu-usuario/tu-proyecto.git
cd tu-proyecto
```

7. **Configurar el archivo .env:**
Edita el archivo .env con estas configuraciones:

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=my_project
DB_USERNAME=root
DB_PASSWORD=password

# Para PostgreSQL
# DB_CONNECTION=pgsql
# DB_HOST=postgres
# DB_PORT=5432
# DB_DATABASE=my_project
# DB_USERNAME=postgres
# DB_PASSWORD=password
```

8. **Ejecutar migraciones:**
```bash
php artisan migrate
```

9. **Ejecutar migraciones:**
```bash
exit
```

10. **Configurar Nginx:**
Edita docker/nginx/nginx.conf para apuntar a tu proyecto:

```bash
server {
    listen 80;
    index index.php index.html;
    root /var/www/nombre-proyecto/public;  # Actualiza esta línea
}
```

**Luego reinicia Nginx:**
```bash
docker compose restart nginx
```

---

11. **Acceder a tu aplicación:**
Abre tu navegador en http://localhost:8000

# Problemas Comunes

## Permisos de archivos:
```bash
docker compose exec app bash
cd /var/www/nombre-proyecto
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Reiniciar servicios:
```bash
docker compose restart nginx
docker compose restart app
```

## Ver logs:
```bash
docker compose logs nginx
docker compose logs app
docker compose logs mysql
docker compose logs postgres
```
