# docker-compiler-nginx

Entorno de desarrollo Dockerizado para aplicaciones PHP modernas con Nginx, MySQL, Xdebug y phpMyAdmin.  
Ideal para proyectos Laravel, CodeIgniter y otros frameworks PHP.

## 📦 Estructura del repositorio

-   **docker-mi-proyecto/**  
    Contiene la configuración principal de Docker Compose, archivos de entorno, configuración de Nginx, PHP y MySQL, así como la documentación detallada para personalizar y usar el stack.

-   **(código fuente de tu aplicación)**  
    Por defecto, el código fuente de tu proyecto debe estar en la raíz del repositorio o puedes ajustar la configuración para usar otra carpeta (ver documentación interna).

## 🚀 Primeros pasos rápidos

1. Lee el archivo `docker-mi-proyecto/readme.md` para instrucciones detalladas.
2. Copia `.env.example` a `.env` y personaliza tus variables.
3. Crea la red externa de Docker si es la primera vez:
    ```bash
    docker network create mi_proyecto_network_nginx
    ```
4. Levanta el entorno:
    ```bash
    cd docker-mi-proyecto
    docker compose up --build -d
    ```

## 📚 Más información

Consulta la documentación completa en `docker-mi-proyecto/readme.md` para detalles sobre personalización, uso de múltiples proyectos, debugging y más.

---

## 👨‍💻 Autor

**Antonio Salcedo**  
_Desarrollador Full Stack_

---

**¡Feliz desarrollo! 🚀**

> **Nota:** Este README está en constante evolución. Si encuentras algún error o tienes sugerencias, no dudes en abrir un issue o contribuir con mejoras.
