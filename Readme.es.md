# 🚀 docker-php-nginx-mysql-postgres

> 🇬🇧 **Prefer English?**  
> Hemos preparado una versión completamente traducida y detallada de esta documentación en [inglés](./Readme.md), para que sigas cada paso, consejo y buena práctica en tu idioma preferido.  
> _¡Cámbiate al inglés si te resulta más cómodo!_

[![Docker](https://img.shields.io/badge/Docker-20.10%2B-blue?logo=docker)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-purple?logo=php)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)](https://mysql.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-blue?logo=postgresql)](https://postgresql.org/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green?logo=nginx)](https://nginx.org/)

> **Stack de desarrollo Dockerizado para aplicaciones PHP modernas con Nginx, MySQL, PostgreSQL, Xdebug, phpMyAdmin y pgAdmin.**  
> Soporta proyectos **Laravel**, **CodeIgniter 3/4** y otros frameworks PHP. Ideal para entornos multi-proyecto y pruebas de stack.

---

> ⚠️ **Nota importante:**  
> Los puertos `8081` (phpMyAdmin) y `8082` (pgAdmin) están reservados para las interfaces web de administración de MySQL y PostgreSQL, respectivamente.  
> Lo más recomendable es utilizar **solo uno de los motores de base de datos** y su respectiva herramienta de administración, salvo que tu proyecto requiera explícitamente ambos.

---

## 📦 Estructura del repositorio

```
/
├── docker/   # Configuración principal de Docker, Nginx, PHP, MySQL, PostgreSQL y docs
├── (código fuente)      # Tu aplicación PHP (por defecto en la raíz)
```

-   **docker/**  
    Configuración principal de Docker Compose, archivos de entorno, Nginx, PHP, MySQL, PostgreSQL y documentación detallada.
-   **(código fuente de tu aplicación)**  
    Por defecto, tu código debe estar en la raíz del repositorio. Puedes ajustar la configuración para usar otra carpeta (ver documentación interna).

---

## 🚀 Primeros pasos rápidos

1. 📖 Lee [`docker/Readme.es.md`](docker/Readme.es.md) para instrucciones completas y personalización.
2. 📝 Copia `.env.example` a `.env` y personaliza tus variables.
3. 🌐 (Solo la primera vez) Crea la red externa de Docker:
    ```bash
    docker network create my_project_network_nginx
    ```
4. 🏗️ Levanta el entorno:
    ```bash
    cd docker
    docker compose up --build -d
    ```

---

## ⚡ Tecnologías y soporte

-   **PHP-FPM 8.1+** (extensiones para Laravel, CodeIgniter, etc.)
-   **Nginx 1.28** (HTTP/HTTPS local)
-   **MySQL 8.0** y **PostgreSQL 16** (elige uno o ambos)
-   **phpMyAdmin** y **pgAdmin** (gestión visual de bases de datos)
-   **Xdebug** (debugging integrado para VS Code)
-   **Backups automáticos** diarios para MySQL y PostgreSQL
-   **Certificados SSL** autofirmados para desarrollo seguro
-   **Soporte multi-framework:** Laravel, CodeIgniter 3/4, proyectos legacy y modernos
-   **Multi-proyecto:** Puedes clonar y levantar varios stacks en paralelo cambiando nombres y puertos en `.env`

---

> 🗄️ **Por defecto este entorno utiliza MySQL como base de datos principal**  
> Si prefieres usar PostgreSQL, simplemente comenta los servicios de `mysql` y `phpmyadmin` en el archivo `docker-compose.yaml` y descomenta los servicios de `postgresql` y `pgadmin`.  
> Así puedes cambiar fácilmente el stack de base de datos según las necesidades de tu proyecto.

---

## 📚 Más información

Consulta la documentación completa en [`docker/readme.md`](docker/readme.md) para detalles sobre personalización, debugging, uso avanzado, múltiples proyectos y solución de problemas.

---

### 🤝 Contribuciones

¡Las contribuciones son bienvenidas! Si encuentras algún error, tienes sugerencias de mejora o quieres agregar nuevas características:

1. **Fork** este repositorio
2. **Crea una rama** para tu feature (`git checkout -b feature/nueva-caracteristica`)
3. **Commit** tus cambios (`git commit -am 'Agregar nueva característica'`)
4. **Push** a la rama (`git push origin feature/nueva-caracteristica`)
5. **Abre un Pull Request**

#### Ideas para contribuir

-   Soporte para otros frameworks (Symfony, CakePHP, etc.)
-   Configuraciones para diferentes versiones de PHP
-   Integración con otros servicios (Redis, Elasticsearch, etc.)
-   Mejoras en la documentación
-   Scripts de automatización adicionales

### 👨‍💻 Autor

**Antonio Salcedo**  
_Desarrollador Full Stack_

## 📄 License

This project is licensed under the **MIT** license. See the [LICENSE](LICENSE) file for more details.

---

**¡Feliz desarrollo! 🚀**

> **Nota:** Este README está en constante evolución. Si encuentras algún error o tienes sugerencias, no dudes en abrir un issue o contribuir con mejoras.

> _Este README es breve y solo cubre lo esencial. Si tienes dudas, revisa la documentación interna o abre un issue._
