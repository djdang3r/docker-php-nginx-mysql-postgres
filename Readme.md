# 🚀 docker-compiler-nginx

[![Docker](https://img.shields.io/badge/Docker-20.10%2B-blue?logo=docker)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4.8-purple?logo=php)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)](https://mysql.com/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green?logo=nginx)](https://nginx.org/)

> **Entorno de desarrollo Dockerizado para aplicaciones PHP modernas con Nginx, MySQL, Xdebug y phpMyAdmin.**  
> Ideal para proyectos **Laravel**, **CodeIgniter** y otros frameworks PHP.

---

## 📦 Estructura del repositorio

```
/
├── docker-mi-proyecto/   # Configuración principal de Docker, Nginx, PHP, MySQL y docs
├── (código fuente)      # Tu aplicación PHP (por defecto en la raíz)
```

- **docker-mi-proyecto/**  
  Configuración principal de Docker Compose, archivos de entorno, Nginx, PHP, MySQL y documentación detallada.
- **(código fuente de tu aplicación)**  
  Por defecto, tu código debe estar en la raíz del repositorio. Puedes ajustar la configuración para usar otra carpeta (ver documentación interna).

---

## 🚀 Primeros pasos rápidos

1. 📖 Lee el archivo [`docker-mi-proyecto/readme.md`](docker-mi-proyecto/readme.md) para instrucciones detalladas.
2. 📝 Copia `.env.example` a `.env` y personaliza tus variables.
3. 🌐 Crea la red externa de Docker si es la primera vez:
    ```bash
    docker network create mi_proyecto_network_nginx
    ```
4. 🏗️ Levanta el entorno:
    ```bash
    cd docker-mi-proyecto
    docker compose up --build -d
    ```

---

## 📚 Más información

Consulta la documentación completa en [`docker-mi-proyecto/readme.md`](docker-mi-proyecto/readme.md) para detalles sobre personalización, uso de múltiples proyectos, debugging y más.

---

## 👨‍💻 Autor

**Antonio Salcedo**  
_Desarrollador Full Stack_

---

**¡Feliz desarrollo!** 🚀

> _Este README está en constante evolución. Si encuentras algún error o tienes sugerencias, no dudes en abrir un issue o contribuir con mejoras._
