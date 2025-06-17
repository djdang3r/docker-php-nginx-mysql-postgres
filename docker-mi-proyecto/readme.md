# 🚀 Docker Mi Proyecto Stack

Entorno de desarrollo completo para aplicaciones web modernas usando **Docker Compose**. Optimizado para frameworks como **Laravel** y **CodeIgniter** con herramientas de desarrollo integradas.

[![Docker](https://img.shields.io/badge/Docker-20.10+-blue.svg)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4.8-purple.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://mysql.com/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green.svg)](https://nginx.org/)

---

## 📋 Tabla de Contenidos

- [✨ Características](#✨-características)
- [🔧 Requisitos](#🔧-requisitos)
- [⚡ Instalación Rápida](#⚡-instalación-rápida)
- [🧩 Servicios Incluidos](#🧩-servicios-incluidos)
- [📁 Estructura del Proyecto](#📁-estructura-del-proyecto)
- [⚙️ Configuración](#⚙️-configuración)
- [🎯 Configuración por Framework](#🎯-configuración-por-framework)
- [👨‍💻 Desarrollo](#👨‍💻-desarrollo)
- [💾 Gestión de Base de Datos](#💾-gestión-de-base-de-datos)
- [🔒 Certificado SSL para HTTPS Local](#🔒-certificado-ssl-para-https-local)
- [📑 Gestión de Logs](#📑-gestión-de-logs)
- [🔄 Personalización para Otros Proyectos](#🔄-personalización-para-otros-proyectos)
- [🗄️ Base de Datos MySQL Compartida](#🗄️-base-de-datos-mysql-compartida)
- [🚨 Solución de Problemas](#🚨-solución-de-problemas)
- [🤝 Contribuciones](#🤝-contribuciones)

---

## ✨ Características

- 🐳 **Entorno completamente dockerizado** - Sin dependencias locales
- 🔧 **Configuración automática** - Listo para usar en minutos
- 🐞 **Debugging integrado** - Xdebug preconfigurado
- 🔄 **Backups automáticos** - MySQL con respaldo diario
- 🔒 **HTTPS local** - Certificados SSL autofirmados
- 📊 **Gestión visual** - phpMyAdmin incluido
- 🎯 **Multi-framework** - Laravel, CodeIgniter 3/4
- 🚀 **Alto rendimiento** - Nginx + PHP-FPM optimizado
- 🗄️ **MySQL compartido** - Un servidor MySQL para múltiples proyectos

---

## 🔧 Requisitos

- **Docker** (versión 20.10 o superior)
- **Docker Compose** (versión 2.0 o superior)
- **Git**
- **VS Code** (recomendado para debugging)

### Verificar instalación

```bash
docker --version
docker compose version
```

---

## ⚡ Instalación Rápida

### 1. Clonar y configurar

```bash
# Clonar el repositorio
git clone <URL_DEL_REPO>
cd docker-compiler-nginx-mysql/docker-mi-proyecto

# Copiar variables de entorno
cp .env.example .env
```

### 2. Crear la red externa (solo la primera vez)

Antes de levantar los servicios, crea la red externa que usará MySQL:

```bash
docker network create mi_proyecto_network_mysql
```

> **💡 Nota:** Solo necesitas hacer esto una vez, incluso si tienes múltiples proyectos.

### 3. Personalizar configuración (opcional)

Edita el archivo `.env` para cambiar puertos, contraseñas o nombres de servicios según tus necesidades.

### 4. Levantar el entorno

```bash
# Primera vez (construye las imágenes)
docker compose up --build -d

# Verificar que todo está funcionando
docker compose ps
```

### 5. Acceder a los servicios

- **🌐 Aplicación:** [http://localhost:8001](http://localhost:8001)
- **🔒 Aplicación HTTPS:** [https://localhost:8441](https://localhost:8441)
- **📊 phpMyAdmin:** [http://localhost:8081](http://localhost:8081)

---

## 🧩 Servicios Incluidos

| Servicio         | Versión | Puerto    | Descripción                                      |
|------------------|---------|-----------|--------------------------------------------------|
| **PHP-FPM**      | 8.4.8   | -         | Backend con extensiones para Laravel/CodeIgniter |
| **Nginx**        | 1.28    | 8001/8441 | Servidor web de alto rendimiento (HTTP/HTTPS)    |
| **MySQL**        | 8.0     | 3306      | Base de datos relacional                         |
| **phpMyAdmin**   | Latest  | 8081      | Interfaz web para MySQL                          |
| **MySQL Backup** | -       | -         | Backups automáticos diarios                      |

### 🔧 Extensiones PHP incluidas

- **Xdebug** - Debugging y profiling
- **Imagick** - Manipulación de imágenes
- **PDO MySQL** - Conexión a base de datos
- **Composer** - Gestor de dependencias
- **GD, ZIP, CURL** - Utilidades esenciales
- Y muchas más...

---

## 📁 Estructura del Proyecto

```
docker-compiler-nginx-mysql/
│
├── docker-mi-proyecto/         # Configuración Docker
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

---

## ⚙️ Configuración

### Variables de entorno principales

```env
# Aplicación
APP_SERVICE_NAME=mi-proyecto-nginx-app

# Puertos
NGINX_PORT=8001
NGINX_SSL_PORT=8441
PHPMYADMIN_PORT=8081

# MySQL
MYSQL_HOST=mysql
MYSQL_ROOT_PASSWORD=password
MYSQL_USER=adminmysqldocker
MYSQL_PASSWORD=qwerty123456
MYSQL_DATABASE=mi_proyecto

# Xdebug
XDEBUG_MODE=develop,debug
XDEBUG_CLIENT_PORT=9003
```

---

## 🎯 Configuración por Framework

### CodeIgniter 3

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

### CodeIgniter 4 / Laravel

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

### 📁 Código en subcarpeta (ej: `src/`)

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

---

## 👨‍💻 Desarrollo

### 📋 Uso Diario

```bash
# Iniciar servicios
docker compose up -d

# Detener servicios
docker compose down
# o también
docker compose stop

# Reiniciar servicios
docker compose restart

# Ver logs en tiempo real
docker compose logs -f

# Ver estado de contenedores
docker compose ps

# Verificar salud de servicios
docker compose exec app php -v
docker compose exec mysql mysql --version
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
2. **Iniciar el debugger** en VS Code (F5 o Run > Start Debugging)
3. **Acceder a tu aplicación** en el navegador
4. **El debugger se activará** automáticamente en los breakpoints

#### Verificar Xdebug

```bash
# Verificar que Xdebug está activo
docker compose exec app php -m | grep -i xdebug

# Ver configuración de Xdebug
docker compose exec app php -i | grep -i xdebug
```

#### ⚠️ Xdebug y múltiples proyectos

Si tienes **varios proyectos corriendo simultáneamente**, debes usar **puertos diferentes para Xdebug** en cada uno para evitar conflictos.

**No basta con cambiar el puerto en el archivo `.env`**, **también debes cambiarlo en el archivo `php/xdebug/xdebug.ini`** de cada proyecto.

**Ejemplo:**

En tu `.env`:
```env
XDEBUG_CLIENT_PORT=9004
```

En `php/xdebug/xdebug.ini`:
```ini
xdebug.client_port=9004
```

### 🔧 Comandos Útiles

#### Gestión de contenedores

```bash
# Entrar al contenedor PHP
docker compose exec app sh

# Entrar al contenedor MySQL
docker compose exec mysql bash

# Instalar/actualizar dependencias
docker compose exec app composer install
docker compose exec app composer update

# Ejecutar comandos Artisan (Laravel)
docker compose exec app php artisan migrate
docker compose exec app php artisan cache:clear

# Ejecutar comandos CI4 (CodeIgniter 4)
docker compose exec app php spark migrate
docker compose exec app php spark cache:clear
```

#### Gestión de archivos y permisos

```bash
# Arreglar permisos (si es necesario)
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

## 💾 Gestión de Base de Datos

### Acceso a MySQL

#### Vía phpMyAdmin

- **URL:** [http://localhost:8081](http://localhost:8081)
- **Usuario:** `root`
- **Contraseña:** `password`

#### Vía línea de comandos

```bash
# Acceso como root
docker compose exec mysql mysql -uroot -ppassword mi_proyecto

# Acceso como usuario regular
docker compose exec mysql mysql -uadminmysqldocker -pqwerty123456 mi_proyecto
```

### 🔄 Backups Automáticos

Los backups se crean automáticamente todos los días a las **05:00 PM** en formato comprimido.

**Ubicación:** `docker-mi-proyecto/mysql/backups/`  
**Formato:** `YYYYMMDDHHMM.nombredb.sql.gz`

#### Crear backup manual

```bash
# Backup completo
docker compose run --rm mysql-backup /backup.sh

# Backup específico
docker compose exec mysql mysqldump -uroot -ppassword mi_proyecto | gzip > backup_manual.sql.gz
```

#### Restaurar backup

```bash
# 1. Descomprimir archivo
gunzip docker-mi-proyecto/mysql/backups/202506090224.mi_proyecto.sql.gz

# 2. Restaurar a la base de datos
docker compose exec -T mysql mysql -uroot -ppassword mi_proyecto < docker-mi-proyecto/mysql/backups/202506090224.mi_proyecto.sql

# 3. Verificar restauración
docker compose exec mysql mysql -uroot -ppassword -e "SHOW TABLES;" mi_proyecto
```

> **💡 Tip:** Siempre usa el usuario `root` para operaciones de backup/restore para evitar problemas de permisos.

---

## 🔒 Certificado SSL para HTTPS Local

### Generar certificado autofirmado

```bash
# 1. Crear directorio para certificados
cd docker-mi-proyecto/nginx
mkdir -p certs

# 2. Generar certificado y clave privada
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout certs/localhost.key \
  -out certs/localhost.crt \
  -subj "/C=CO/ST=Risaralda/L=Dosquebradas/O=Dev/OU=Dev/CN=localhost"

# 3. (Opcional) Generar parámetros Diffie-Hellman
openssl dhparam -out certs/dhparam.pem 2048
```

### Configurar Nginx

Asegúrate de que tu `nginx.conf` incluya:

```nginx
server {
    listen 443 ssl http2;
    server_name localhost;

    ssl_certificate     /etc/nginx/certs/localhost.crt;
    ssl_certificate_key /etc/nginx/certs/localhost.key;
    # ssl_dhparam         /etc/nginx/certs/dhparam.pem;

    # Configuración SSL moderna
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # ... resto de configuración
}
```

### Aplicar cambios

```bash
# Reiniciar Nginx
docker compose restart nginx

# Verificar certificado
openssl x509 -in docker-mi-proyecto/nginx/certs/localhost.crt -text -noout
```

**Acceso:** [https://localhost:8441](https://localhost:8441)

> **Nota:** El navegador mostrará advertencia de seguridad (es normal para certificados autofirmados).

---

## 📑 Gestión de Logs

### Logs de aplicación

```bash
# Ver logs de todos los servicios
docker compose logs -f

# Ver logs de un servicio específico
docker compose logs -f nginx
docker compose logs -f app
docker compose logs -f mysql

# Ver logs con timestamps
docker compose logs -f -t nginx
```

### Logs de Nginx

```bash
# Logs en tiempo real
docker compose exec nginx tail -f /var/log/nginx/access.log
docker compose exec nginx tail -f /var/log/nginx/error.log

# Buscar errores específicos
docker compose exec nginx grep "ERROR" /var/log/nginx/error.log

# Limpiar logs (desarrollo)
docker compose exec nginx sh -c "truncate -s 0 /var/log/nginx/*.log"
```

### Exportar logs

```bash
# Descargar logs a tu máquina
docker compose cp nginx:/var/log/nginx/error.log ./nginx-error.log
docker compose cp nginx:/var/log/nginx/access.log ./nginx-access.log

# Logs con fecha específica
docker compose logs --since "2024-01-01" --until "2024-01-02" > logs_enero.txt
```

---

## 🔄 Personalización para Otros Proyectos

### Método rápido (recomendado)

```bash
# 1. Copiar el directorio docker-mi-proyecto
cp -r docker-mi-proyecto docker-nuevo-proyecto

# 2. Actualizar variables en .env
cd docker-nuevo-proyecto
nano .env
```

### Variables a cambiar

```env
# Nombres de servicios (evita conflictos)
APP_SERVICE_NAME=nuevo-proyecto
NGINX_SERVICE_NAME=nginx-nuevo-proyecto
MYSQL_SERVICE_NAME=mysql-nuevo-proyecto
PHPMYADMIN_SERVICE_NAME=phpmyadmin-nuevo-proyecto

# Puertos (evita conflictos)
NGINX_PORT=8002
NGINX_SSL_PORT=8442
PHPMYADMIN_PORT=8082

# Base de datos
MYSQL_DATABASE=nuevo_proyecto_db

# Xdebug (si tienes múltiples proyectos)
XDEBUG_CLIENT_PORT=9004
```

### Aplicar cambios

```bash
# Levantar el nuevo stack
docker compose up --build -d

# Verificar que no hay conflictos de puertos
docker compose ps
```

### Gestión de múltiples proyectos

```bash
# Ver todos los contenedores
docker ps -a

# Detener proyecto específico
cd docker-mi-proyecto && docker compose down

# Listar redes de Docker
docker network ls

# Limpiar recursos no utilizados
docker system prune -f
```

---

## 🗄️ Base de Datos MySQL Compartida

Si tienes **varios proyectos** que necesitan acceder a la **misma base de datos MySQL** (para compartir datos o consultar diferentes bases en el mismo servidor), puedes hacerlo fácilmente siguiendo estos pasos:

### 🔗 ¿Cómo compartir el contenedor MySQL?

#### 1. Solo un proyecto debe tener el servicio `mysql`

- Elige uno de tus proyectos como el "principal" y **solo ahí define los servicios `mysql`, `phpmyadmin`, `mysql-backup`** en el `docker-compose.yaml`.
- Los demás proyectos **NO deben declarar el servicio `mysql`**.

#### 2. Usa una red externa compartida

- Crea una red de Docker que usarán todos los proyectos:
  ```bash
  docker network create mi_proyecto_network_mysql
  ```
  
- Al final de cada `docker-compose.yaml` (de todos los proyectos que compartirán MySQL), agrega:
  ```yaml
  networks:
      default:
          external:
              name: mi_proyecto_network_mysql
  ```

#### 3. Configura el host de la base de datos

- En el archivo `.env` de **todos los proyectos** (incluyendo el principal):
  ```env
  MYSQL_HOST=mysql
  ```
  
- Así, todos los servicios PHP/APP de los proyectos podrán conectarse al mismo contenedor MySQL usando el hostname `mysql`.

#### 4. Cada proyecto puede usar su propia base de datos

- Puedes crear varias bases de datos en el mismo contenedor MySQL.
- En el `.env` de cada proyecto, especifica el nombre de la base de datos correspondiente:
  ```env
  MYSQL_DATABASE=nombre_de_mi_base
  ```

#### 5. Ejemplo de configuración para un proyecto secundario

```yaml
services:
    app:
        image: mi-app
        environment:
            - MYSQL_HOST=mysql
            - MYSQL_DATABASE=otra_base
            - MYSQL_USER=adminmysqldocker
            - MYSQL_PASSWORD=qwerty123456
        # ...otros servicios...
        # NO declarar servicios mysql, phpmyadmin, mysql-backup aquí

networks:
    default:
        external:
            name: mi_proyecto_network_mysql
```

### 📝 Ventajas de compartir MySQL

- **Ahorro de recursos** - Un solo contenedor MySQL para múltiples proyectos
- **Datos compartidos** - Fácil acceso entre proyectos
- **Gestión centralizada** - Un solo phpMyAdmin y sistema de backups
- **Sin conflictos de puertos** - Evita problemas de configuración

---

## 🚨 Solución de Problemas

### Problemas comunes y soluciones

#### 🔌 Puerto ocupado

```bash
# Error: "port is already allocated"
# Solución: Cambiar puertos en .env
NGINX_PORT=8002
NGINX_SSL_PORT=8442
PHPMYADMIN_PORT=8082

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

#### 🗄️ Error de conexión a MySQL

```bash
# Problema: "Connection refused"
# Verificar que MySQL está corriendo
docker compose exec mysql mysqladmin ping -h localhost

# Verificar logs de MySQL
docker compose logs mysql

# Recrear contenedor MySQL (⚠️ Elimina datos)
docker compose down
docker volume rm $(docker volume ls -q | grep mysql)
docker compose up -d
```

#### 🐞 Xdebug no funciona

```bash
# Verificar configuración
docker compose exec app php -i | grep xdebug

# Verificar pathMappings en VS Code
# Debe coincidir: "/var/www": "${workspaceFolder}"

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

#### ⚡ Problemas de rendimiento

```bash
# Verificar recursos del sistema
docker stats

# Limpiar imágenes no utilizadas
docker image prune -f

# Incrementar límites de memoria para Docker
# Docker Desktop > Settings > Resources > Advanced
```

### 🔍 Comandos de diagnóstico

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
docker compose exec app ping nginx
```

### 🔄 Recrear entorno completo

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

## 🤝 Contribuciones

¡Las contribuciones son bienvenidas! Si encuentras algún error, tienes sugerencias de mejora o quieres agregar nuevas características:

1. **Fork** este repositorio
2. **Crea una rama** para tu feature (`git checkout -b feature/nueva-caracteristica`)
3. **Commit** tus cambios (`git commit -am 'Agregar nueva característica'`)
4. **Push** a la rama (`git push origin feature/nueva-caracteristica`)
5. **Abre un Pull Request**

### Ideas para contribuir

- Soporte para otros frameworks (Symfony, CakePHP, etc.)
- Configuraciones para diferentes versiones de PHP
- Integración con otros servicios (Redis, Elasticsearch, etc.)
- Mejoras en la documentación
- Scripts de automatización adicionales

---

## 👨‍💻 Autor

**Antonio Salcedo**  
_Desarrollador Full Stack_

---

**¡Feliz desarrollo! 🚀**

> **Nota:** Este README está en constante evolución. Si encuentras algún error o tienes sugerencias, no dudes en abrir un issue o contribuir con mejoras.

---