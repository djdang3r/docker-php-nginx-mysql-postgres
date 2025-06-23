# 🚀 Docker Mi Proyecto Stack

> 🇬🇧 **Prefer English?**  
> Puedes consultar una versión completamente traducida y detallada de esta documentación interna en [inglés](./Readme.md), con todos los pasos de configuración y consejos de uso.  
> _¡Cámbiate al inglés si te resulta más cómodo!_

Entorno de desarrollo completo para aplicaciones web modernas usando **Docker Compose**. Optimizado para frameworks como **Laravel** y **CodeIgniter** con herramientas de desarrollo integradas.

[![Docker](https://img.shields.io/badge/Docker-20.10+-blue.svg)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4.8-purple.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://mysql.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue.svg)](https://postgresql.org/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green.svg)](https://nginx.org/)

---

## 📋 Tabla de Contenidos

### 🚀 [Inicio Rápido](#-inicio-rápido-1)

-   [✨ Características](#-características)
-   [🔧 Requisitos](#-requisitos)
-   [⚡ Instalación Rápida](#-instalación-rápida)
-   [🧩 Servicios Incluidos](#-servicios-incluidos)

### ⚙️ [Configuración](#️-configuración-1)

-   [📁 Estructura del Proyecto](#-estructura-del-proyecto)
-   [🔧 Variables de Entorno](#-variables-de-entorno)
-   [🎯 Configuración por Framework](#-configuración-por-framework)
-   [🔒 Certificados SSL](#-certificados-ssl)

### 💻 [Desarrollo Diario](#-desarrollo-diario-1)

-   [👨‍💻 Comandos Básicos](#-comandos-básicos)
-   [🐞 Debugging con Xdebug](#-debugging-con-xdebug)
-   [📑 Gestión de Logs](#-gestión-de-logs)
-   [🔧 Comandos Avanzados](#-comandos-avanzados)

### 🗄️ [Gestión de Bases de Datos](#️-gestión-de-bases-de-datos-1)

-   [💾 MySQL](#-mysql)
-   [🐘 PostgreSQL](#-postgresql)
-   [🔄 Backups Automáticos](#-backups-automáticos)
-   [🗄️ Base de Datos Compartida](#️-base-de-datos-compartida)

### 🔧 [Configuración Avanzada](#-configuración-avanzada-1)

-   [🔄 Múltiples Proyectos](#-múltiples-proyectos)
-   [⚡ Optimización de Rendimiento](#-optimización-de-rendimiento)
-   [🚨 Solución de Problemas](#-solución-de-problemas)

### 📚 [Recursos Adicionales](#-recursos-adicionales-1)

-   [🤝 Contribuciones](#-contribuciones)
-   [👨‍💻 Autor](#-autor)

---

## 🚀 Inicio Rápido

### ✨ Características

-   🐳 **Entorno completamente dockerizado** - Sin dependencias locales
-   🔧 **Configuración automática** - Listo para usar en minutos
-   🐞 **Debugging integrado** - Xdebug preconfigurado
-   🔄 **Backups automáticos** - MySQL y PostgreSQL con respaldo diario
-   🔒 **HTTPS local** - Certificados SSL autofirmados
-   📊 **Gestión visual** - phpMyAdmin y pgAdmin incluidos
-   🎯 **Multi-framework** - Laravel, CodeIgniter 3/4
-   🚀 **Alto rendimiento** - Nginx + PHP-FPM optimizado
-   🗄️ **Bases de datos múltiples** - MySQL y PostgreSQL disponibles
-   🔗 **MySQL compartido** - Un servidor MySQL para múltiples proyectos

### 🔧 Requisitos

-   **Docker** (versión 20.10 o superior)
-   **Docker Compose** (versión 2.0 o superior)
-   **Git**
-   **VS Code** (recomendado para debugging)

#### Verificar instalación

```bash
docker --version
docker compose version
```

### ⚡ Instalación Rápida

#### 1. Clonar y configurar

```bash
# Clonar el repositorio
git clone <URL_DEL_REPO>
cd docker-compiler-nginx-mysql/docker-my-project

# Copiar variables de entorno
cp .env.example .env
```

#### 2. Crear la red externa (solo la primera vez)

```bash
docker network create my_project_network_mysql
```

> **💡 Nota:** Solo necesitas hacer esto una vez, incluso si tienes múltiples proyectos.

#### 3. Personalizar configuración (opcional)

Edita el archivo `.env` para cambiar puertos, contraseñas o nombres de servicios según tus necesidades.

#### 4. Levantar el entorno

```bash
# Primera vez (construye las imágenes)
docker compose up --build -d

# Verificar que todo está funcionando
docker compose ps
```

#### 5. Acceder a los servicios

-   **🌐 Aplicación:** [http://localhost:8001](http://localhost:8001)
-   **🔒 Aplicación HTTPS:** [https://localhost:8441](https://localhost:8441)
-   **📊 phpMyAdmin:** [http://localhost:8081](http://localhost:8081)
-   **🐘 pgAdmin:** [http://localhost:8082](http://localhost:8082)

### 🧩 Servicios Incluidos

| Servicio              | Versión | Puerto    | Descripción                                      |
| --------------------- | ------- | --------- | ------------------------------------------------ |
| **PHP-FPM**           | 8.1.32  | -         | Backend con extensiones para Laravel/CodeIgniter |
| **Nginx**             | 1.28    | 8001/8441 | Servidor web de alto rendimiento (HTTP/HTTPS)    |
| **MySQL**             | 8.0     | 3306      | Base de datos relacional                         |
| **PostgreSQL**        | 15      | 5432      | Base de datos relacional avanzada                |
| **phpMyAdmin**        | Latest  | 8081      | Interfaz web para MySQL                          |
| **pgAdmin**           | Latest  | 8082      | Interfaz web para PostgreSQL                     |
| **MySQL Backup**      | -       | -         | Backups automáticos diarios                      |
| **PostgreSQL Backup** | -       | -         | Backups automáticos diarios                      |

#### 🔧 Extensiones PHP incluidas

-   **Xdebug** - Debugging y profiling
-   **PDO MySQL/PostgreSQL** - Conexión a bases de datos
-   **Composer** - Gestor de dependencias
-   **GD, ZIP, CURL** - Utilidades esenciales
-   Y muchas más...

---

## ⚙️ Configuración

### 📁 Estructura del Proyecto

```
docker-compiler-nginx-mysql/
│
├── docker-my-project/         # Configuración Docker
│   ├── docker-compose.yaml     # Orquestación de servicios
│   ├── .env.example            # Variables de entorno de ejemplo
│   ├── .env                    # Variables de entorno (local)
│   │
│   ├── nginx/                  # Configuración Nginx
│   │   ├── nginx.conf          # Configuración principal
│   │   └── certs/              # Certificados SSL
│   │       ├── localhost.crt
│   │       └── localhost.key
│   │
│   ├── php/                    # Configuración PHP
│   │   └── DockerFile          # Imagen PHP personalizada
│   │
│   ├── mysql/                  # Configuración MySQL
│   │   ├── init.sql            # Script de inicialización
│   │   └── backups/            # Backups automáticos
│   │       └── *.sql.gz
│   │
│   ├── postgresql/             # Configuración PostgreSQL
│   │   ├── init.sql            # Script de inicialización
│   │   └── backups/            # Backups automáticos
│   │       └── *.sql
│   │
│   └── readme.md               # Este archivo
│
├── (código fuente en la raíz)
│   ├── index.php               # Para CodeIgniter 3
│   ├── public/                 # Para Laravel/CodeIgniter 4
│   │   └── index.php
│   ├── .vscode/                # Configuración VS Code para debugging
│   │   └── launch.json
│   └── ...
```

### 🔧 Variables de Entorno

#### Variables principales del archivo `.env`

```env
# === APLICACIÓN ===
APP_SERVICE_NAME=my-project-nginx-app

# === PUERTOS ===
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

## 🚀 Instalación de Frameworks PHP en Docker

> ⚠️ **IMPORTANTE:**  
> No instales PHP, Composer ni el instalador de Laravel en tu máquina local.  
> Todo debe hacerse **dentro del contenedor Docker** para mantener tu entorno limpio y reproducible.

### Laravel

1. **Levanta los contenedores (si aún no lo hiciste):**

    ```bash
    docker compose up -d
    ```

2. **Accede al contenedor PHP:**

    ```bash
    docker compose exec app bash
    ```

3. **Instala Laravel en la carpeta deseada (por ejemplo, `testing_laravel`):**

    ```bash
    composer create-project laravel/laravel testing_laravel
    ```

    > Si quieres instalar Laravel en la raíz del proyecto, usa un punto:
    >
    > ```bash
    > composer create-project laravel/laravel .
    > ```

4. **Ajusta el root de Nginx:**  
   Si instalaste Laravel en una subcarpeta, edita `nginx/nginx.conf`:

    ```nginx
    root /var/www/testing_laravel/public;
    ```

    Si está en la raíz:

    ```nginx
    root /var/www/public;
    ```

5. **Reinicia Nginx para aplicar cambios:**

    ```bash
    docker compose restart nginx
    ```

6. **Accede a tu aplicación:**
    - HTTP: [http://localhost:8001](http://localhost:8001)
    - HTTPS: [https://localhost:8441](https://localhost:8441)

---

### CodeIgniter 4

1. **Levanta los contenedores (si aún no lo hiciste):**

    ```bash
    docker compose up -d
    ```

2. **Accede al contenedor PHP:**

    ```bash
    docker compose exec app bash
    ```

3. **Instala CodeIgniter 4 en la carpeta deseada (por ejemplo, `ci4`):**

    ```bash
    composer create-project codeigniter4/appstarter ci4
    ```

4. **Ajusta el root de Nginx:**  
   Si instalaste CodeIgniter en una subcarpeta, edita `nginx/nginx.conf`:

    ```nginx
    root /var/www/ci4/public;
    ```

    Si está en la raíz:

    ```nginx
    root /var/www/public;
    ```

5. **Reinicia Nginx para aplicar cambios:**

    ```bash
    docker compose restart nginx
    ```

6. **Accede a tu aplicación:**
    - HTTP: [http://localhost:8001](http://localhost:8001)
    - HTTPS: [https://localhost:8441](https://localhost:8441)

---

### Notas adicionales

-   **No uses `laravel new` ni el instalador global de Laravel** dentro de Docker. Usa siempre `composer create-project`.
-   **Los archivos creados dentro del contenedor aparecerán en tu carpeta local** gracias al volumen Docker.
-   Si necesitas compilar assets frontend (Vite, npm), instala Node dentro del contenedor o usa un contenedor aparte para frontend.

---

> Para más detalles sobre la estructura de carpetas y configuración de Nginx, revisa las secciones [Configuración por Framework](#-configuración-por-framework) y [Estructura del Proyecto](#-estructura-del-proyecto).

### 🎯 Configuración por Framework

> ⚠️ **IMPORTANTE:**  
> Si usas CodeIgniter 3 o cualquier framework que tenga `index.php` en la raíz del proyecto (no en `/public`), debes editar `nginx/nginx.conf` y cambiar la línea:
>
> ```
> root /var/www/public;
> ```
>
> por:
>
> ```
> root /var/www;
> ```
>
> De lo contrario, tu aplicación no será servida correctamente.

#### CodeIgniter 3

```nginx
# En nginx.conf
root /var/www;
index index.php;
```

**Estructura esperada:**

```
├── application/
├── system/
├── index.php          # En la raíz
└── ...
```

#### CodeIgniter 4 / Laravel

```nginx
# En nginx.conf
root /var/www/public;
index index.php;
```

**Estructura esperada:**

```
├── app/
├── public/
│   └── index.php      # Punto de entrada
├── vendor/
└── ...
```

#### 📁 Código en subcarpeta

Si tu código fuente **no está en la raíz** del repositorio:

1. **Editar el volumen en `docker-compose.yaml`:**

    ```yaml
    # Si tu código está en src/
    volumes:
        - ../src:/var/www/
    ```

2. **Ajustar la directiva `root` en `nginx.conf`:**
    - Para Laravel en `src/`: `root /var/www/public;`
    - Para Laravel en `src/public`: `root /var/www/src/public;`

**Aplicar cambios:**

```bash
docker compose restart nginx
```

### 🔒 Certificados SSL

#### Generar certificado autofirmado

```bash
# 1. Crear directorio para certificados
cd docker-my-project/nginx
mkdir -p certs

# 2. Generar certificado y clave privada
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout certs/localhost.key \
  -out certs/localhost.crt \
  -subj "/C=CO/ST=Risaralda/L=Dosquebradas/O=Dev/OU=Dev/CN=localhost"

# 3. (Opcional) Generar parámetros Diffie-Hellman
openssl dhparam -out certs/dhparam.pem 2048
```

#### Configurar Nginx

Asegúrate de que tu `nginx.conf` incluya:

```nginx
server {
    listen 443 ssl http2;
    server_name localhost;

    ssl_certificate     /etc/nginx/certs/localhost.crt;
    ssl_certificate_key /etc/nginx/certs/localhost.key;

    # Configuración SSL moderna
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # ... resto de configuración
}
```

**Acceso:** [https://localhost:8441](https://localhost:8441)

> **Nota:** El navegador mostrará advertencia de seguridad (es normal para certificados autofirmados).

---

## 💻 Desarrollo Diario

### 👨‍💻 Comandos Básicos

```bash
# Iniciar servicios
docker compose up -d

# Detener servicios
docker compose down

# Reiniciar servicios
docker compose restart

# Ver estado de contenedores
docker compose ps

# Ver logs en tiempo real
docker compose logs -f
```

### 🐞 Debugging con Xdebug

#### Configuración VS Code

1. **Instalar extensión:** PHP Debug de Xdebug
2. **Crear archivo `.vscode/launch.json`:**

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

#### Usar Xdebug

1. **Colocar breakpoints** en tu código PHP
2. **Iniciar el debugger** en VS Code (F5)
3. **Acceder a tu aplicación** en el navegador
4. **El debugger se activará** automáticamente

#### ⚠️ Múltiples proyectos y Xdebug

Si tienes varios proyectos corriendo simultáneamente, usa **puertos diferentes**:

**En tu `.env`:**

```env
XDEBUG_CLIENT_PORT=9004
```

**En `php/xdebug/xdebug.ini`:**

```ini
xdebug.client_port=9004
```

### 📑 Gestión de Logs

#### Ver logs

```bash
# Logs de todos los servicios
docker compose logs -f

# Logs de un servicio específico
docker compose logs -f nginx
docker compose logs -f app
docker compose logs -f mysql

# Logs con timestamps
docker compose logs -f -t nginx
```

#### Logs de Nginx

```bash
# Logs en tiempo real
docker compose exec nginx tail -f /var/log/nginx/access.log
docker compose exec nginx tail -f /var/log/nginx/error.log

# Buscar errores específicos
docker compose exec nginx grep "ERROR" /var/log/nginx/error.log

# Limpiar logs (desarrollo)
docker compose exec nginx sh -c "truncate -s 0 /var/log/nginx/*.log"
```

#### Exportar logs

```bash
# Descargar logs a tu máquina
docker compose cp nginx:/var/log/nginx/error.log ./nginx-error.log

# Logs con fecha específica
docker compose logs --since "2024-01-01" --until "2024-01-02" > logs_enero.txt
```

### 🔧 Comandos Avanzados

#### Gestión de contenedores

```bash
# Entrar al contenedor PHP
docker compose exec app sh

# Entrar al contenedor MySQL
docker compose exec mysql bash

# Instalar/actualizar dependencias
docker compose exec app composer install
docker compose exec app composer update

# Comandos Laravel
docker compose exec app php artisan migrate
docker compose exec app php artisan cache:clear

# Comandos CodeIgniter 4
docker compose exec app php spark migrate
docker compose exec app php spark cache:clear
```

#### Gestión de archivos y permisos

```bash
# Arreglar permisos
sudo chown -R $USER:$USER .

# Cambiar permisos dentro del contenedor
docker compose exec app chown -R www-data:www-data /var/www/storage
docker compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
```

#### Limpieza y mantenimiento

```bash
# Reconstruir contenedores
docker compose build --no-cache
docker compose up --build -d

# Limpiar volúmenes (⚠️ Elimina datos de BD)
docker compose down -v

# Limpiar imágenes no utilizadas
docker image prune -f
```

---

## 🗄️ Gestión de Bases de Datos

### 💾 MySQL

#### 🟢 Activar servicios opcionales

Para usar MySQL y phpMyAdmin:

1. Descomenta los bloques `mysql` y `phpmyadmin` en `docker-compose.yaml`.
2. Levanta los servicios:
    ```bash
    docker compose up -d
    ```

#### Acceso vía phpMyAdmin

-   **URL:** [http://localhost:8081](http://localhost:8081)
-   **Usuario:** `root`
-   **Contraseña:** `password`

#### Acceso vía línea de comandos

```bash
# Acceso como root
docker compose exec mysql mysql -uroot -ppassword my_project

# Acceso como usuario regular
docker compose exec mysql mysql -uadminmysqldocker -ppassword_enviroment my_project
```

### 🐘 PostgreSQL

#### Acceso vía pgAdmin

-   **URL:** [http://localhost:8082](http://localhost:8082)
-   **Email:** `admin@admin.com`
-   **Contraseña:** `admin123`

#### Registrar servidor PostgreSQL en pgAdmin

-   **Host name/address:** `postgresql`
-   **Port:** `5432`
-   **Maintenance database:** `postgres` o `my-project`
-   **Username:** `adminpostgresdocker`
-   **Password:** `password_enviroment`

#### Acceso vía línea de comandos

```bash
# Acceso directo
docker compose exec postgresql psql -U adminpostgresdocker -d my-project
```

### 🔄 Backups Automáticos

#### MySQL - Backups automáticos

Los backups se crean automáticamente todos los días a las **17:00**.

**Ubicación:** `docker-my-project/mysql/backups/`  
**Formato:** `YYYYMMDDHHMM.nombredb.sql.gz`

##### Crear backup manual

```bash
# Backup completo
docker compose run --rm mysql-backup /backup.sh

# Backup específico
docker compose exec mysql mysqldump -uroot -ppassword my_project | gzip > backup_manual.sql.gz
```

##### Restaurar backup

```bash
# 1. Descomprimir archivo
gunzip docker-my-project/mysql/backups/202506090224.my_project.sql.gz

# 2. Restaurar a la base de datos
docker compose exec -T mysql mysql -uroot -ppassword my_project < docker-my-project/mysql/backups/202506090224.my_project.sql

# 3. Verificar restauración
docker compose exec mysql mysql -uroot -ppassword -e "SHOW TABLES;" my_project
```

#### PostgreSQL - Backups automáticos

Los backups se crean automáticamente todos los días a las **17:00**.

**Ubicación:** `docker-my-project/postgresql/backups/`  
**Formato:** `YYYYMMDDHHMM.my-project.sql.gz`

##### Crear backup manual

```bash
docker compose exec postgresql pg_dump -U adminpostgresdocker -d my-project > ./postgresql/backups/backup-manual.sql
```

##### Restaurar backup

```bash
# Descomprimir si es necesario
gunzip docker-my-project/postgresql/backups/202506211700.my-project.sql.gz

# Restaurar
docker compose exec -T postgresql psql -U adminpostgresdocker -d my-project < docker-my-project/postgresql/backups/202506211700.my-project.sql
```

### 🗄️ Base de Datos Compartida

Si tienes **varios proyectos** que necesitan acceder a la **misma base de datos MySQL**, puedes compartir el contenedor:

> 💾 **Nota sobre persistencia:**  
> Si quieres que los datos de MySQL se conserven entre reinicios, descomenta la sección de volúmenes en el bloque `mysql` de `docker-compose.yaml`:
>
> ```yaml
> volumes:
>     - ${MYSQL_DATA_VOLUME}:/var/lib/mysql
> ```

#### Configuración para MySQL compartido

##### 1. Solo un proyecto principal

-   Define los servicios `mysql`, `phpmyadmin`, `mysql-backup` solo en un proyecto "principal"
-   Los demás proyectos NO deben declarar el servicio `mysql`

##### 2. Red externa compartida

```bash
# Crear la red (solo una vez)
docker network create my_project_network_mysql
```

En cada `docker-compose.yaml`:

```yaml
networks:
    default:
        external:
            name: my_project_network_mysql
```

##### 3. Configurar host en todos los proyectos

En todos los archivos `.env`:

```env
MYSQL_HOST=mysql
```

##### 4. Bases de datos separadas

Cada proyecto puede usar su propia base de datos:

```env
MYSQL_DATABASE=nombre_de_mi_base
```

#### Ventajas del MySQL compartido

-   **Ahorro de recursos** - Un solo contenedor MySQL
-   **Datos compartidos** - Fácil acceso entre proyectos
-   **Gestión centralizada** - Un solo phpMyAdmin y backups
-   **Sin conflictos de puertos** - Evita problemas de configuración

---

## 🔧 Configuración Avanzada

### 🔄 Múltiples Proyectos

#### Método rápido

```bash
# 1. Copiar el directorio
cp -r docker-my-project docker-nuevo-proyecto

# 2. Actualizar variables en .env
cd docker-nuevo-proyecto
nano .env
```

#### Variables a cambiar

```env
# Nombres de servicios (evita conflictos)
APP_SERVICE_NAME=nuevo-proyecto
NGINX_SERVICE_NAME=nginx-nuevo-proyecto

# Puertos (evita conflictos)
NGINX_PORT=8002
NGINX_SSL_PORT=8442
PHPMYADMIN_PORT=8082

# Base de datos
MYSQL_DATABASE=nuevo_proyecto_db

# Xdebug (si tienes múltiples proyectos)
XDEBUG_CLIENT_PORT=9004
```

#### Gestión de múltiples proyectos

```bash
# Ver todos los contenedores
docker ps -a

# Detener proyecto específico
cd docker-my-project && docker compose down

# Listar redes de Docker
docker network ls

# Limpiar recursos no utilizados
docker system prune -f
```

### ⚡ Optimización de Rendimiento

#### Configuración de PHP-FPM

```ini
# Optimizar para desarrollo
pm.max_children = 10
pm.start_servers = 4
pm.min_spare_servers = 2
pm.max_spare_servers = 6
```

#### Configuración de MySQL

```cnf
# my.cnf optimizaciones básicas
innodb_buffer_pool_size = 256M
query_cache_size = 32M
max_connections = 100
```

#### Monitoreo de recursos

```bash
# Ver uso de recursos
docker stats

# Ver uso específico por contenedor
docker stats docker-my-project-app-1
```

### 🚨 Solución de Problemas

#### 🔌 Puerto ocupado

```bash
# Error: "port is already allocated"
# Solución: Cambiar puertos en .env
NGINX_PORT=8002
NGINX_SSL_PORT=8442

# Verificar qué proceso usa el puerto
sudo lsof -i :8001
```

#### 📁 Permisos de archivos

```bash
# Problema: "Permission denied"
# Solución: Arreglar permisos
sudo chown -R $USER:$USER .
docker compose exec app chown -R www-data:www-data /var/www/storage
```

#### 🗄️ Error de conexión a base de datos

```bash
# MySQL - Verificar que está corriendo
docker compose exec mysql mysqladmin ping -h localhost

# PostgreSQL - Verificar conexión
docker compose exec postgresql pg_isready -U adminpostgresdocker

# Ver logs de base de datos
docker compose logs mysql
docker compose logs postgresql

# Recrear contenedores (⚠️ Elimina datos)
docker compose down -v
docker compose up -d
```

#### 🐞 Xdebug no funciona

```bash
# Verificar configuración
docker compose exec app php -i | grep xdebug

# Verificar puerto disponible
sudo lsof -i :9003

# Reiniciar servicio PHP
docker compose restart app
```

#### 🌐 Nginx no inicia

```bash
# Verificar sintaxis de configuración
docker compose exec nginx nginx -t

# Ver logs detallados
docker compose logs nginx

# Validar certificados SSL
openssl x509 -in nginx/certs/localhost.crt -text -noout
```

#### 🔍 Comandos de diagnóstico

```bash
# Estado general del sistema
docker system df
docker system events

# Información detallada de contenedores
docker compose exec app php --ini
docker compose exec mysql mysql --version
docker compose exec nginx nginx -V

# Verificar conectividad entre servicios
docker compose exec app ping mysql
docker compose exec app ping postgresql
```

#### 🔄 Recrear entorno completo

```bash
# Pasos para empezar de cero (⚠️ Elimina todos los datos)
docker compose down -v
docker image prune -a -f
docker volume prune -f
docker network prune -f

# Reconstruir todo
docker compose build --no-cache
docker compose up -d
```

---

## 📚 Recursos Adicionales

> **Nota importante:**  
> Los puertos `8081` (phpMyAdmin) y `8082` (pgAdmin) están reservados para las interfaces web de administración de MySQL y PostgreSQL, respectivamente.  
> Lo más recomendable es que tu entorno utilice **solo uno de los motores de base de datos** (MySQL o PostgreSQL) y su respectiva herramienta de administración.  
> Si decides levantar ambos servicios a la vez, asegúrate de que tu proyecto realmente requiere trabajar con ambas bases de datos, ya que esto puede consumir más recursos y complicar la gestión.
