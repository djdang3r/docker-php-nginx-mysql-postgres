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

$envPath = __DIR__ . '/../.env';
loadEnv($envPath);

// Include the service checker file
require_once 'service_checker.php';

// If full phpinfo is requested, show it and exit
if (isset($_GET['phpinfo']) && $_GET['phpinfo'] == '1') {
    phpinfo();
    exit();
}

// Collect the status of the services
$services = [];

$mysqlInfo = ServiceChecker::checkMySQL();

if ($mysqlInfo['status'] !== null) { // Only add if config exists (MYSQL_HOST is defined)
    $services['MySQL'] = $mysqlInfo;
}

$pgsqlInfo = ServiceChecker::checkPostgreSQL();
if ($pgsqlInfo['status'] !== null) { // Only add if config exists (POSTGRES_HOST is defined)
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Docker PHP-Nginx-MySQL Starter - Ready to Develop!</title>
    <meta name="description" content="Quick start page for a Dockerized development environment with PHP, Nginx, MySQL and PostgreSQL. Check status, get project info and next steps.">
    <meta name="keywords" content="Docker, PHP, Nginx, MySQL, PostgreSQL, development, web stack, starter kit, local environment">
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
            <img class="docker-logo me-md-4 mb-3 mb-md-0" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg" alt="Docker logo, a stylized blue whale design">
            <div>
                <h1 class="mb-2">Docker PHP Stack Ready!</h1>
                <p class="subtitle mb-0">
                    <span class="status-dot success me-2"></span>
                    System running! Your environment is modern, fast and secure.
                </p>
            </div>
        </header>

        <section class="panel status-info-section p-4 p-md-5" aria-labelledby="status-heading">
            <h2 id="status-heading" class="mb-4 pb-2 border-bottom">Service Status</h2>
            <div class="status-list row g-3 mb-4">
                <?php if (count($services)): ?>
                    <?php foreach ($services as $name => $info): ?>
                        <?php if ($info['status']): ?>
                            <div class="status-item d-flex align-items-center justify-content-between p-3 rounded-3 <?php echo !$info['status'] ? 'danger-status-item' : ''; ?>">
                                <span class="status-dot <?php echo $info['status'] ? 'success' : 'danger'; ?> me-3 flex-shrink-0"></span>
                                <strong class="flex-grow-1"><?php echo htmlspecialchars($name); ?><?php if (!empty($info['version'])): ?> <small class="text-secondary">(<?php echo htmlspecialchars($info['version']); ?>)</small><?php endif; ?>:</strong>
                                <span class="status-message text-end ms-4">
                                    <?php echo $info['status'] ? 'Connected' : 'Connection Error'; ?>
                                    <br>
                                    <small class="text-muted"><?php echo htmlspecialchars($info['message']); ?></small>
                                </span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="status-item p-3 rounded-3">
                        <span class="status-dot warning me-3"></span>
                        <strong>No database services configured.</strong>
                        <span class="status-message text-muted ms-4">
                            No environment variables detected for MySQL or PostgreSQL.<br>
                            Check your <code>.env</code> and <code>docker-compose.yaml</code> file.
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <h2 class="visually-hidden">Project Information</h2>
            <div class="info-grid row row-cols-1 row-cols-md-1 row-cols-lg-2 g-3 mt-4">
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Root Path:</strong>
                        <code class="d-block">/var/www/html</code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Public Directory:</strong>
                        <code class="d-block">/var/www/html/public</code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Default Page:</strong>
                        <code class="d-block">index.php</code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">PHP Version:</strong>
                        <code class="d-block"><?php echo phpversion(); ?></code>
                    </div>
                </div>
                <div class="col">
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Server IP:</strong>
                        <code class="d-block"><?php echo $_SERVER['SERVER_ADDR'] ?? 'N/A'; ?></code>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel stack-section p-4 p-md-5" aria-labelledby="technologies-heading">
            <h2 id="technologies-heading" class="mb-4 pb-2 border-bottom">Included Technologies</h2>
            <div class="stack-list d-flex justify-content-center flex-wrap gap-3 mt-4">
                <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="PHP <?php echo phpversion(); ?>: The programming language powering your web application.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP Icon">
                    PHP <?php echo phpversion(); ?>
                </div>
                <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="Nginx 1.28: High-performance web server to serve your files.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nginx/nginx-original.svg" alt="Nginx Icon">
                    Nginx 1.28
                </div>
                <?php if (extension_loaded('xdebug')): ?>
                    <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="Xdebug: Essential tool for PHP debugging and performance analysis.">
                        <img src="https://www.xdebug.org/images/xdebug-logo.svg" alt="Xdebug Icon" style="width: 40px; height: 40px; margin-top: 4px;">
                        Xdebug
                    </div>
                <?php endif; ?>
                <?php if (isset($services['MySQL']) && $services['MySQL']['status']): ?>
                    <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="MySQL <?php echo htmlspecialchars($services['MySQL']['version'] ?? ''); ?>: Popular relational database for your application.">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL Icon">
                        MySQL
                        <?php
                        $mysqlVersion = $services['MySQL']['version'] ?? '';
                        echo htmlspecialchars($mysqlVersion);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($services['PostgreSQL']) && $services['PostgreSQL']['status']): ?>
                    <div class="stack-item d-flex flex-column align-items-center p-3 rounded-4 shadow-sm" title="PostgreSQL: Advanced object-relational database management system.">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg" alt="PostgreSQL Icon">
                        PostgreSQL
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="panel actions-links-section p-4 p-md-5" aria-labelledby="actions-heading">
            <h2 id="actions-heading" class="mb-4 pb-2 border-bottom">Quick Actions & Resources</h2>
            <div class="quick-actions d-flex flex-wrap justify-content-center gap-3">
                <button type="button" class="action-button d-flex align-items-center gap-2" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh Status
                </button>
                <button type="button" class="action-button d-flex align-items-center gap-2" onclick="window.open('https://github.com/jsrivero22/docker-config', '_blank')">
                    <i class="fab fa-github"></i> GitHub Repository
                </button>
                <button type="button" class="action-button d-flex align-items-center gap-2" onclick="alert('For help, check the documentation links below or the repository README.')">
                    <i class="fas fa-question-circle"></i> Help
                </button>
            </div>
            <nav class="links-grid d-flex flex-wrap justify-content-center gap-3 mt-4" aria-label="Related Documentation Links">
                <a href="https://docs.docker.com/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                    <i class="fab fa-docker"></i> Docker Docs
                </a>
                <a href="https://www.php.net/manual/en/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                    <i class="fas fa-book-open"></i> PHP Docs
                </a>
                <a href="https://nginx.org/en/docs/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                    <i class="fas fa-book"></i> Nginx Docs
                </a>
                <?php if (isset($services['MySQL']) && $services['MySQL']['status']): ?>
                    <a href="https://dev.mysql.com/doc/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                        <i class="fas fa-database"></i> MySQL Docs
                    </a>
                <?php endif; ?>
                <?php if (isset($services['PostgreSQL']) && $services['PostgreSQL']['status']): ?>
                    <a href="https://www.postgresql.org/docs/" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center gap-2">
                        <i class="fas fa-database"></i> PostgreSQL Docs
                    </a>
                <?php endif; ?>
            </nav>
        </section>

        <section class="panel next-steps-section p-4 p-md-5" aria-labelledby="next-steps-heading">
            <h3 id="next-steps-heading" class="mb-4 pb-2 border-bottom">Essential Next Steps:</h3>
            <ul class="list-unstyled mb-0">
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Place your PHP application files inside the directory.</span>
                    <code class="d-block rounded p-2 mt-2">app/</code>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Make sure your main entry point is:</span>
                    <code class="d-block rounded p-2 mt-2">index.php</code>
                    <span>or configure Nginx for a different one.</span>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Run to install PHP dependencies.</span>
                    <code class="d-block rounded p-2 mt-2">docker compose exec app composer install</code>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>For database migrations (Laravel example):</span>
                    <code class="d-block rounded p-2 mt-2">docker compose exec app php artisan migrate</code>
                </li>
                <li class="mb-3 d-flex flex-column align-items-start position-relative ps-5">
                    <span>Check the logs to troubleshoot issues.</span>
                    <code class="d-block rounded p-2 mt-2">docker compose logs -f</code>
                </li>
                <li class="d-flex flex-column align-items-start position-relative ps-5">
                    <span>Visit in your browser to see this page and your app.</span>
                    <code class="d-block rounded p-2 mt-2">http://localhost</code>
                </li>
            </ul>
        </section>

        <section class="panel phpinfo-section p-4 p-md-5 mt-4" aria-labelledby="phpinfo-heading" id="phpinfo-panel" style="display:none;">
            <h2 id="phpinfo-heading" class="mb-4 pb-2 border-bottom">PHP Information</h2>
            <div class="info-grid row g-3">
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">PHP Version:</strong>
                        <code class="d-block"><?php echo phpversion(); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Execution Mode (SAPI):</strong>
                        <code class="d-block"><?php echo php_sapi_name(); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">php.ini File Path:</strong>
                        <code class="d-block"><?php echo php_ini_loaded_file() ?: 'Not loaded'; ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Memory Limit:</strong>
                        <code class="d-block"><?php echo ini_get('memory_limit'); ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Max Execution Time:</strong>
                        <code class="d-block"><?php echo ini_get('max_execution_time'); ?>s</code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Error Reporting:</strong>
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
                        <strong class="d-block mb-1">File Uploads:</strong>
                        <code class="d-block"><?php echo ini_get('file_uploads') ? 'On' : 'Off'; ?></code>
                    </div>
                </div>
                <div>
                    <div class="custom-info-grid-item p-3 rounded-3 h-100 d-flex flex-column justify-content-between">
                        <strong class="d-block mb-1">Xdebug Extension:</strong>
                        <code class="d-block"><?php echo extension_loaded('xdebug') ? 'Enabled' : 'Disabled'; ?></code>
                    </div>
                </div>
            </div>
            <a href="?phpinfo=1" target="_blank" rel="noopener noreferrer" class="action-button d-flex align-items-center gap-2 mt-4 mx-auto">
                <i class="fas fa-search"></i> View full phpinfo()
            </a>
        </section>

        <div>
            <button id="toggle-phpinfo" type="button" class="action-button d-flex align-items-center gap-2 mt-4 mx-auto">
                <i class="fas fa-info-circle"></i> Show advanced PHP details
            </button>
        </div>

        <section class="panel project-access-section p-4 p-md-5" aria-labelledby="access-heading">
            <h2 id="access-heading" class="mb-4 pb-2 border-bottom">Quick Service Access</h2>
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
                <small>&copy; <?php echo date('Y'); ?> Docker PHP-Nginx-MySQL Starter. Developed by Antonio Salcedo.</small>
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
                togglePhpinfoButton.innerHTML = '<i class="fas fa-times-circle"></i> Hide advanced PHP details';
            }

            togglePhpinfoButton.addEventListener('click', function() {
                if (phpinfoPanel.style.display === 'none') {
                    phpinfoPanel.style.display = 'block';
                    togglePhpinfoButton.innerHTML = '<i class="fas fa-times-circle"></i> Hide advanced PHP details';
                    localStorage.setItem('phpinfoVisible', 'true');
                } else {
                    phpinfoPanel.style.display = 'none';
                    togglePhpinfoButton.innerHTML = '<i class="fas fa-info-circle"></i> Show advanced PHP details';
                    localStorage.setItem('phpinfoVisible', 'false');
                }
            });
        });
    </script>
</body>

</html>
