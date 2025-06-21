<?php

function loadEnv($envPath)
{
    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (!strpos($line, '=')) continue;
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if (!getenv($name)) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

$envPath = __DIR__ . '/../docker-mi-proyecto/.env';
loadEnv($envPath);

// index.php

// Incluimos el archivo de comprobación de servicios
require_once 'service_checker.php';

// Si se solicita el phpinfo completo, lo mostramos y terminamos la ejecución
if (isset($_GET['phpinfo']) && $_GET['phpinfo'] == '1') {
    phpinfo();
    exit();
}

// Recopilación del estado de los servicios
$services = [];

$mysqlInfo = ServiceChecker::checkMySQL();
// var_dump($mysqlInfo); // Para depuración, puedes eliminar esta línea después

if ($mysqlInfo['status'] !== null) { // Solo añadir si hay configuración (MYSQL_HOST está definido)
    $services['MySQL'] = $mysqlInfo;
}

$pgsqlInfo = ServiceChecker::checkPostgreSQL();
if ($pgsqlInfo['status'] !== null) { // Solo añadir si hay configuración (POSTGRES_HOST está definido)
    $services['PostgreSQL'] = $pgsqlInfo;
}

$nginxPort = getenv('NGINX_PORT') ?: '80';
$nginxSslPort = getenv('NGINX_SSL_PORT') ?: '443';
$phpmyadminPort = getenv('PHPMYADMIN_PORT') ?: null;
$pgadminPort = getenv('PGADMIN_PORT') ?: null;
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Docker PHP-Nginx-MySQL Starter - ¡Listo para Desarrollar!</title>
    <meta name="description" content="Página de inicio rápido para un entorno de desarrollo Dockerizado con PHP, Nginx, MySQL y PostgreSQL. Verifica el estado, obtén información del proyecto y los próximos pasos.">
    <meta name="keywords" content="Docker, PHP, Nginx, MySQL, PostgreSQL, desarrollo, stack web, kit de inicio, entorno local">
    <meta name="author" content="Antonio Salcedo">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="dashboard container-fluid px-0" role="main">
        <header class="panel header-section d-flex flex-column flex-md-row align-items-center text-center text-md-start p-4 p-md-5">
            <img class="docker-logo me-md-4 mb-3 mb-md-0" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg" alt="Logo de Docker, un diseño estilizado de una ballena azul">
            <div>
                <h1 class="mb-2">¡Docker PHP Stack Listo!</h1>
                <p class="subtitle mb-0">
                    <span class="status-dot success me-2"></span>
                    ¡Sistema en marcha! Tu entorno es moderno, rápido y seguro.
                </p>
            </div>
        </header>

        <section class="panel status-info-section p-4 p-md-5" aria-labelledby="status-heading">
            <h2 id="status-heading" class="mb-4 pb-2 border-bottom">Estado de los Servicios</h2>
            <div class="status-list row g-3 mb-4">
                <?php if (count($services)): ?>
                    <?php foreach ($services as $name => $info): ?>
                        <?php if ($info['status']): ?>
                            <div class="status-item d-flex align-items-center justify-content-between p-3 rounded-3 <?php echo !$info['status'] ? 'danger-status-item' : ''; ?>">
                                <span class="status-dot <?php echo $info['status'] ? 'success' : 'danger'; ?> me-3 flex-shrink-0"></span>
                                <strong class="flex-grow-1"><?php echo htmlspecialchars($name); ?><?php if (!empty($info['version'])): ?> <small class="text-secondary">(<?php echo htmlspecialchars($info['version']); ?>)</small><?php endif; ?>:</strong>
                                <span class="status-message text-end ms-4">
                                    <?php echo $info['status'] ? 'Conectado' : 'Error de Conexión'; ?>
                                    <br>
                                    <small class="text-muted"><?php echo htmlspecialchars($info['message']); ?></small>
                                </span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="status-item p-3 rounded-3">
                        <span class="status-dot warning me-3"></span>
                        <strong>Sin servicios de base de datos configurados.</strong>
                        <span class="status-message text-muted ms-4">
                            No se detectaron variables de entorno para MySQL ni PostgreSQL.<br>
                            Revisa tu archivo <code>.env</code> y <code>docker-compose.yaml</code>.
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <h2 class="visually-hidden">Información del Proyecto</h2>
            <div class="info-grid row row-cols-1 row-cols-md-1 row-cols-lg-2 g-3 mt-4">
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Ruta Raíz:</strong>
                        <code class="d-block">/var/www/html</code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Directorio Público:</strong>
                        <code class="d-block">/var/www/html/public</code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Página por Defecto:</strong>
                        <code class="d-block">index.php</code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Versión de PHP:</strong>
                        <code class="d-block"><?php echo phpversion(); ?></code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">IP del Servidor:</strong>
                        <code class="d-block"><?php echo $_SERVER['SERVER_ADDR'] ?? 'N/A'; ?></code>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel stack-section p-4 p-md-5" aria-labelledby="technologies-heading">
            <h2 id="technologies-heading" class="mb-4 pb-2 border-bottom">Tecnologías Incluidas</h2>
            <div class="stack-list d-flex justify-content-center flex-wrap gap-3 mt-4">
                <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="PHP <?php echo phpversion(); ?>: El lenguaje de programación que potencia tu aplicación web.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="Icono de PHP">
                    PHP <?php echo phpversion(); ?>
                </div>
                <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="Nginx 1.28: Servidor web de alto rendimiento para servir tus archivos.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nginx/nginx-original.svg" alt="Icono de Nginx">
                    Nginx 1.28
                </div>
                <?php if (extension_loaded('xdebug')): ?>
                    <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="Xdebug: Herramienta esencial para depuración y análisis de rendimiento de PHP.">
                        <img src="https://www.xdebug.org/images/xdebug-logo.svg" alt="Icono de Xdebug" style="width: 40px; height: 40px; margin-top: 4px;">
                        Xdebug
                    </div>
                <?php endif; ?>
                <?php if (isset($services['MySQL']) && $services['MySQL']['status']): ?>
                    <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="MySQL <?php echo htmlspecialchars($services['MySQL']['version'] ?? ''); ?>: Base de datos relacional popular para tu aplicación.">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="Icono de MySQL">
                        MySQL
                        <?php
                        $mysqlVersion = $services['MySQL']['version'] ?? '';
                        echo htmlspecialchars($mysqlVersion);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($services['PostgreSQL']) && $services['PostgreSQL']['status']): ?>
                    <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="PostgreSQL: Sistema de gestión de bases de datos objeto-relacionales avanzado.">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg" alt="Icono de PostgreSQL">
                        PostgreSQL
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="panel actions-links-section p-4 p-md-5" aria-labelledby="actions-heading">
            <h2 id="actions-heading" class="mb-4 pb-2 border-bottom">Acciones Rápidas y Recursos</h2>
            <div class="quick-actions d-flex flex-wrap justify-content-center gap-3">
                <button type="button" class="action-button d-flex align-items-center gap-2" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Actualizar Estado
                </button>
                <button type="button" class="action-button d-flex align-items-center gap-2" onclick="window.open('https://github.com/jsrivero22/docker-config', '_blank')">
                    <i class="fab fa-github"></i> Repositorio GitHub
                </button>
                <button type="button" class="action-button d-flex align-items-center gap-2" onclick="alert('Para obtener ayuda, consulta los enlaces de documentación a continuación o el README del repositorio.')">
                    <i class="fas fa-question-circle"></i> Ayuda
                </button>
            </div>
            <nav class="links-grid d-flex flex-wrap justify-content-center gap-3 mt-4" aria-label="Enlaces de Documentación Relacionados">
                <a href="https://docs.docker.com/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                    <i class="fab fa-docker"></i> Docs Docker
                </a>
                <a href="https://www.php.net/manual/en/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                    <i class="fas fa-book-open"></i> Docs PHP
                </a>
                <a href="https://nginx.org/en/docs/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                    <i class="fas fa-book"></i> Docs Nginx
                </a>
                <?php if (isset($services['MySQL']) && $services['MySQL']['status']): ?>
                    <a href="https://dev.mysql.com/doc/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                        <i class="fas fa-database"></i> Docs MySQL
                    </a>
                <?php endif; ?>
                <?php if (isset($services['PostgreSQL']) && $services['PostgreSQL']['status']): ?>
                    <a href="https://www.postgresql.org/docs/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                        <i class="fas fa-database"></i> Docs PostgreSQL
                    </a>
                <?php endif; ?>
            </nav>
        </section>

        <section class="panel next-steps-section p-4 p-md-5" aria-labelledby="next-steps-heading">
            <h3 id="next-steps-heading" class="mb-4 pb-2 border-bottom">Próximos Pasos Esenciales:</h3>
            <ul class="list-unstyled mb-0">
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Coloca tus archivos de aplicación PHP dentro del directorio.</span>
                    <code class="d-block rounded p-2 mt-2">app/</code>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Asegúrate de que tu punto de entrada principal sea.</span>
                    <code class="d-block rounded p-2 mt-2">index.php</code>
                    <span>o configura Nginx para uno diferente.</span>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Ejecuta para instalar las dependencias de PHP.</span>
                    <code class="d-block rounded p-2 mt-2">docker compose exec app composer install</code>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Para migraciones de base de datos (ejemplo de Laravel):</span>
                    <code class="d-block rounded p-2 mt-2">docker compose exec app php artisan migrate</code>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Revisa los logs para solucionar problemas.</span>
                    <code class="d-block rounded p-2 mt-2">docker compose logs -f</code>
                </li>
                <li class="d-flex flex-column align-items-start position-relative ps-5">
                    <span>Visita en tu navegador para ver esta página y tu aplicación.</span>
                    <code class="d-block rounded p-2 mt-2">http://localhost</code>
                </li>
            </ul>
        </section>

        <section class="panel phpinfo-section p-4 p-md-5 mt-4" aria-labelledby="phpinfo-heading" id="phpinfo-panel" style="display:none;">
            <h2 id="phpinfo-heading" class="mb-4 pb-2 border-bottom">Información de PHP</h2>
            <div class="info-grid row g-3">
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Versión de PHP:</strong>
                        <code class="d-block"><?php echo phpversion(); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Modo de ejecución (SAPI):</strong>
                        <code class="d-block"><?php echo php_sapi_name(); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Ruta del archivo php.ini:</strong>
                        <code class="d-block"><?php echo php_ini_loaded_file() ?: 'No cargado'; ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Límite de memoria:</strong>
                        <code class="d-block"><?php echo ini_get('memory_limit'); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Tiempo máximo de ejecución:</strong>
                        <code class="d-block"><?php echo ini_get('max_execution_time'); ?>s</code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Reporte de errores:</strong>
                        <code class="d-block"><?php echo ini_get('error_reporting'); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Display Errors:</strong>
                        <code class="d-block"><?php echo ini_get('display_errors') ? 'On' : 'Off'; ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Carga de archivos:</strong>
                        <code class="d-block"><?php echo ini_get('file_uploads') ? 'On' : 'Off'; ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Extensión Xdebug:</strong>
                        <code class="d-block"><?php echo extension_loaded('xdebug') ? 'Activado' : 'Desactivado'; ?></code>
                    </div>
                </div>
            </div>
            <a href="?phpinfo=1" target="_blank" rel="noopener noreferrer" class="action-button d-flex align-items-center gap-2 mt-4 mx-auto">
                <i class="fas fa-search"></i> Ver phpinfo() completo
            </a>
        </section>

        <div>
            <button id="toggle-phpinfo" type="button" class="action-button d-flex align-items-center gap-2 mt-4 mx-auto">
                <i class="fas fa-info-circle"></i> Mostrar detalles avanzados de PHP
            </button>
        </div>

        <section class="panel project-access-section p-4 p-md-5" aria-labelledby="access-heading">
            <h2 id="access-heading" class="mb-4 pb-2 border-bottom">Accesos Rápidos a Servicios</h2>
            <div class="info-grid row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong>App HTTP:</strong>
                        <code class="d-block"><a href="http://localhost:<?php echo $nginxPort; ?>" target="_blank">http://localhost:<?php echo $nginxPort; ?></a></code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong>App HTTPS:</strong>
                        <code class="d-block"><a href="https://localhost:<?php echo $nginxSslPort; ?>" target="_blank">https://localhost:<?php echo $nginxSslPort; ?></a></code>
                    </div>
                </div>
                <?php if ($phpmyadminPort && $services['MySQL']['status']): ?>
                    <div class="col">
                        <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                            <strong>phpMyAdmin:</strong>
                            <code class="d-block"><a href="http://localhost:<?php echo $phpmyadminPort; ?>" target="_blank">http://localhost:<?php echo $phpmyadminPort; ?></a></code>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($pgadminPort && $services['PostgreSQL']['status']): ?>
                    <div class="col">
                        <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                            <strong>pgAdmin:</strong>
                            <code class="d-block"><a href="http://localhost:<?php echo $pgadminPort; ?>" target="_blank">http://localhost:<?php echo $pgadminPort; ?></a></code>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <footer class="footer-section text-center py-4 mt-5 border-top">
            <p class="mb-0">
                <small>&copy; <?php echo date('Y'); ?> Docker PHP-Nginx-MySQL Starter. Desarrollado por Antonio Salcedo.</small>
            </p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePhpinfoButton = document.getElementById('toggle-phpinfo');
            const phpinfoPanel = document.getElementById('phpinfo-panel');

            const isPhpinfoVisible = localStorage.getItem('phpinfoVisible') === 'true';
            if (isPhpinfoVisible) {
                phpinfoPanel.style.display = 'block';
                togglePhpinfoButton.innerHTML = '<i class="fas fa-times-circle"></i> Ocultar detalles avanzados de PHP';
            }

            togglePhpinfoButton.addEventListener('click', function() {
                if (phpinfoPanel.style.display === 'none') {
                    phpinfoPanel.style.display = 'block';
                    togglePhpinfoButton.innerHTML = '<i class="fas fa-times-circle"></i> Ocultar detalles avanzados de PHP';
                    localStorage.setItem('phpinfoVisible', 'true');
                } else {
                    phpinfoPanel.style.display = 'none';
                    togglePhpinfoButton.innerHTML = '<i class="fas fa-info-circle"></i> Mostrar detalles avanzados de PHP';
                    localStorage.setItem('phpinfoVisible', 'false');
                }
            });
        });
    </script>
</body>

</html>