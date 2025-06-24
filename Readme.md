# 🚀 docker-php-nginx-mysql-postgres

> 🇪🇸 **¿Hablas español?**  
> We have prepared a fully translated and detailed version of this documentation in [Spanish](./Readme.es.md), so you can follow every step, tip, and best practice in your native language.  
> _Switch to Spanish for a more comfortable reading experience!_

[![Docker](https://img.shields.io/badge/Docker-20.10%2B-blue?logo=docker)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4-purple?logo=php)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)](https://mysql.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-blue?logo=postgresql)](https://postgresql.org/)
[![Nginx](https://img.shields.io/badge/Nginx-1.28-green?logo=nginx)](https://nginx.org/)

> **Dockerized development stack for modern PHP applications with Nginx, MySQL, PostgreSQL, Xdebug, phpMyAdmin and pgAdmin.**  
> Supports **Laravel**, **CodeIgniter 3/4** projects and other PHP frameworks. Ideal for multi-project environments and stack testing.

---

> ⚠️ **Important note:**  
> Ports `8081` (phpMyAdmin) and `8082` (pgAdmin) are reserved for the MySQL and PostgreSQL web administration interfaces, respectively.  
> It is most recommended to use **only one of the database engines** and its respective administration tool, unless your project explicitly requires both.

---

## 📦 Repository structure

```
/
├── docker/   # Main Docker configuration, Nginx, PHP, MySQL, PostgreSQL and docs
├── (source code)        # Your PHP application (by default in the root)
```

-   **docker/**  
    Main Docker Compose configuration, environment files, Nginx, PHP, MySQL, PostgreSQL and detailed documentation.
-   **(your application source code)**  
    By default, your code should be in the repository root. You can adjust the configuration to use another folder (see internal documentation).

---

## 🚀 Quick start

1. 📖 Read [`docker/readme.md`](docker/Readme.md) for complete instructions and customization.
2. 📝 Copy `.env.example` to `.env` and customize your variables.
3. 🌐 (Only the first time) Create the external Docker network:
    ```bash
    docker network create my_project_network_nginx
    ```
4. 🏗️ Start the environment:
    ```bash
    cd docker
    docker compose up --build -d
    ```

---

## ⚡ Technologies and support

-   **PHP-FPM 8.1+** (extensions for Laravel, CodeIgniter, etc.)
-   **Nginx 1.28** (local HTTP/HTTPS)
-   **MySQL 8.0** and **PostgreSQL 16** (choose one or both)
-   **phpMyAdmin** and **pgAdmin** (visual database management)
-   **Xdebug** (integrated debugging for VS Code)
-   **Automatic backups** daily for MySQL and PostgreSQL
-   **SSL certificates** self-signed for secure development
-   **Multi-framework support:** Laravel, CodeIgniter 3/4, legacy and modern projects
-   **Multi-project:** You can clone and run multiple stacks in parallel by changing names and ports in `.env`

---

> 🗄️ **By default this environment uses MySQL as the main database**  
> If you prefer to use PostgreSQL, simply comment out the `mysql` and `phpmyadmin` services in the `docker-compose.yaml` file and uncomment the `postgresql` and `pgadmin` services.  
> This way you can easily change the database stack according to your project needs.

---

## 📚 More information

Check the complete documentation at [`docker/readme.md`](docker/Readme.md) for details on customization, debugging, advanced usage, multiple projects and troubleshooting.

---

### 🤝 Contributions

Contributions are welcome! If you find any errors, have improvement suggestions or want to add new features:

1. **Fork** this repository
2. **Create a branch** for your feature (`git checkout -b feature/new-feature`)
3. **Commit** your changes (`git commit -am 'Add new feature'`)
4. **Push** to the branch (`git push origin feature/new-feature`)
5. **Open a Pull Request**

#### Ideas for contributing

-   Support for other frameworks (Symfony, CakePHP, etc.)
-   Configurations for different PHP versions
-   Integration with other services (Redis, Elasticsearch, etc.)
-   Documentation improvements
-   Additional automation scripts

### 👨‍💻 Author

**Antonio Salcedo**  
_Full Stack Developer_

## 📄 License

This project is licensed under the **MIT** license. See the [LICENSE](LICENSE) file for more details.

---

**Happy development! 🚀**

> **Note:** This README is constantly evolving. If you find any errors or have suggestions, don't hesitate to open an issue or contribute with improvements.

> _This README is brief and only covers the essentials. If you have questions, check the internal documentation or open an issue._
