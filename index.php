<?php

// Modern Welcome Page for Docker Project Configuration

// Estado de servicios
$mysqlStatus = false;
$mysqlMessage = '';
$pgsqlStatus = false;
$pgsqlMessage = 'No configurado en .env';
$redisStatus = false;
$redisMessage = '';

// MySQL Connection Test
$mysqlHost = getenv('MYSQL_HOST') ?: 'mysql';
$mysqlDb   = getenv('MYSQL_DATABASE') ?: 'mi_proyecto';
$mysqlUser = getenv('MYSQL_USER') ?: 'adminmysqldocker';
$mysqlPass = getenv('MYSQL_PASSWORD') ?: 'qwerty123456';

try {
    $pdo = new PDO("mysql:host=$mysqlHost;dbname=$mysqlDb", $mysqlUser, $mysqlPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 2,
    ]);
    $mysqlStatus = true;
    $mysqlMessage = 'Conectado exitosamente!';
} catch (PDOException $e) {
    $mysqlStatus = false;
    $mysqlMessage = 'Error de conexión a MySQL: ' . $e->getMessage();
}

// PostgreSQL Connection Test
// $pgsqlHost = getenv('POSTGRES_HOST') ?: 'db';
// $pgsqlDb   = getenv('POSTGRES_DB') ?: 'docker-php';
// $pgsqlUser = getenv('POSTGRES_USER') ?: 'adminpgdocker';
// $pgsqlPass = getenv('POSTGRES_PASSWORD') ?: 'qwerty123456';

// try {
//     $pgPdo = new PDO("pgsql:host=$pgsqlHost;dbname=$pgsqlDb", $pgsqlUser, $pgsqlPass, [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_TIMEOUT => 2,
//     ]);
//     $pgsqlStatus = true;
//     $pgsqlMessage = 'Conectado exitosamente!';
// } catch (PDOException $e) {
//     $pgsqlStatus = false;
//     $pgsqlMessage = 'Error de conexión a PostgreSQL: ' . $e->getMessage();
// }

// Redis Connection Test (opcional, descomenta si tienes Redis y la extensión instalada)
// $redisHost = getenv('REDIS_HOST') ?: 'redis';
// $redisPort = getenv('REDIS_PORT') ?: 6379;
// try {
//     $redis = new Redis();
//     $redis->connect($redisHost, $redisPort, 2);
//     $redisStatus = true;
//     $redisMessage = 'Conectado exitosamente!';
//     $redis->close();
// } catch (Exception $e) {
//     $redisStatus = false;
//     $redisMessage = 'Error de conexión a Redis: ' . $e->getMessage();
// }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Docker PHP-Nginx-MySQL-Redis Starter - ¡Listo para Desarrollar!</title>
    <meta name="description"
        content="Página de inicio rápido para un entorno de desarrollo Dockerizado con PHP, Nginx, MySQL y Redis. Verifica el estado, obtén información del proyecto y los próximos pasos.">
    <meta name="keywords"
        content="Docker, PHP, Nginx, MySQL, Redis, desarrollo, stack web, kit de inicio, entorno local">
    <meta name="author" content="Antonio Salcedo">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4A90E2;
            /* Azul vibrante */
            --primary-dark: #357ABD;
            --secondary: #F0F4F8;
            /* Gris claro suave */
            --accent: #7ED321;
            /* Verde brillante para éxito/énfasis */
            --text-dark: #2C3E50;
            /* Azul oscuro para texto principal */
            --text-light: #5A6A7A;
            /* Gris medio para texto secundario */
            --bg-gradient: linear-gradient(135deg, #E0F2F7 0%, #D1ECF2 100%);
            /* Degradado de fondo más suave */
            --card-bg: #FFFFFF;
            --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.08);
            --shadow-strong: 0 10px 30px rgba(0, 0, 0, 0.15);
            --success: #28A745;
            /* Verde Bootstrap */
            --danger: #DC3545;
            /* Rojo Bootstrap */
            --warning: #FFC107;
            /* Amarillo Bootstrap */
            --info: #17A2B8;
            /* Azul claro Bootstrap */
            --border-color: #E0E6EB;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: 1px solid rgba(255, 255, 255, 0.6);
        }

        /* Base Styles - Mobile First */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            min-height: 100vh;
            /* Asegura que el fondo cubra toda la altura */
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            /* Evita el scroll horizontal */
        }

        body {
            padding: 20px;
            /* Un padding general para evitar que el dashboard se pegue a los bordes */
        }

        .dashboard {
            display: grid;
            grid-template-columns: 1fr;
            /* Default to single column for mobile */
            gap: 1.5rem;
            max-width: 1200px;
            width: 100%;
            background: var(--glass-bg);
            border-radius: 2rem;
            box-shadow: var(--shadow-strong);
            padding: 2rem;
            border: var(--glass-border);
            backdrop-filter: blur(15px);
            animation: fadeInScale 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            margin: 20px auto;
            /* Centra horizontalmente y añade margen superior/inferior */
        }

        /* Particle Background Effect */
        .dashboard::before,
        .dashboard::after {
            content: "";
            position: absolute;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            opacity: 0.08;
            border-radius: 50%;
            z-index: 0;
            animation: floatAndFade 15s infinite ease-in-out;
        }

        .dashboard::before {
            width: 250px;
            height: 250px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .dashboard::after {
            width: 180px;
            height: 180px;
            bottom: -80px;
            right: -80px;
            animation-delay: 7s;
        }

        @keyframes floatAndFade {

            0%,
            100% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 0.08;
            }

            25% {
                transform: translateY(-20px) translateX(20px) scale(1.05);
                opacity: 0.12;
            }

            50% {
                transform: translateY(0) translateX(-20px) scale(1);
                opacity: 0.08;
            }

            75% {
                transform: translateY(20px) translateX(20px) scale(0.95);
                opacity: 0.1;
            }
        }

        /* Panel Common Styles */
        .panel {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-light);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            z-index: 1;
            /* Ensure content is above particles */
        }

        .panel:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-strong);
        }

        h1 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            letter-spacing: -0.05em;
        }

        h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 0.5rem;
        }

        h3 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--card-bg);
            margin-bottom: 1rem;
        }

        p.subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-top: 0;
            font-weight: 500;
        }

        /* Header Section */
        .header-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .docker-logo {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
            /* For mobile */
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .docker-logo:hover {
            transform: rotate(10deg) scale(1.1);
        }

        /* Status & Info Section */
        .status-info-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--secondary);
            border-radius: 0.75rem;
            padding: 0.8rem 1.2rem;
            font-size: 1.05rem;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .status-item:hover {
            background-color: var(--border-color);
        }

        .status-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            margin-right: 0.8rem;
            flex-shrink: 0;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .status-dot.success {
            background: var(--success);
        }

        .status-dot.danger {
            background: var(--danger);
        }

        .status-dot.warning {
            background: var(--warning);
        }

        .status-dot.info {
            background: var(--info);
        }

        .status-message {
            font-size: 0.9em;
            color: var(--text-light);
            margin-left: 1rem;
            text-align: right;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-grid>div {
            background: var(--secondary);
            border-radius: 0.75rem;
            padding: 1rem;
            font-size: 0.95rem;
            color: var(--text-light);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: background-color 0.2s ease;
        }

        .info-grid>div:hover {
            background-color: var(--border-color);
        }

        .info-grid strong {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.3rem;
            display: block;
        }

        .info-grid code {
            background: #EAF0F5;
            color: var(--primary-dark);
            border-radius: 5px;
            padding: 0.2em 0.5em;
            font-family: 'Roboto Mono', monospace;
            font-weight: 500;
            word-break: break-all;
            /* Ensure long paths wrap */
        }

        /* Stack Section */
        .stack-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.2rem;
            margin-top: 1rem;
        }

        .stack-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 1.05rem;
            color: var(--text-dark);
            background: var(--secondary);
            border-radius: 1rem;
            padding: 0.8rem 1.2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            min-width: 100px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            cursor: help;
            /* Indicates more info on hover */
            border: 1px solid var(--border-color);
        }

        .stack-item:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: #EAF0F5;
            /* Lighter on hover */
        }

        .stack-item img {
            width: 48px;
            height: 48px;
            margin-bottom: 0.5rem;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1));
        }

        /* Actions & Links Section */
        .actions-links-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }

        .action-button {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .action-button:hover {
            background: var(--primary-dark);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 6px 18px rgba(74, 144, 226, 0.45);
        }

        .action-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(74, 144, 226, 0.2);
            background: var(--primary);
        }

        .links-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.8rem 1.2rem;
            margin-top: 1rem;
        }

        .links-grid a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
            padding: 0.5rem 0.8rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .links-grid a:hover {
            color: var(--primary-dark);
            background: var(--secondary);
            transform: translateY(-2px);
            text-decoration: underline;
        }

        /* Next Steps Section */
        .next-steps-section {
            background: linear-gradient(145deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            padding: 1.8rem;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.25);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .next-steps-section h3 {
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 0.8rem;
            margin-bottom: 1.2rem;
            color: #E0F2F7;
        }

        .next-steps-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .next-steps-section li {
            margin-bottom: 1.8rem;
            /* Aumento significativo para más espacio entre ítems */
            font-size: 1.05rem;
            display: flex;
            /* Mantén flex para el ícono y el contenido */
            flex-direction: column;
            /* ¡Nuevo! Para que el contenido interno se apile */
            align-items: flex-start;
            /* Alinea el contenido a la izquierda */
            line-height: 1.6;
            color: #F0F8FF;
            position: relative;
            /* Para posicionar el before correctamente */
            padding-left: 2.2em;
            /* Espacio para el ícono a la izquierda */
        }

        .next-steps-section li:last-child {
            margin-bottom: 0;
        }

        /* El ícono ahora se posiciona absolutamente dentro del li */
        .next-steps-section li::before {
            content: "\f058";
            /* FontAwesome check circle */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: var(--accent);
            /* Bright green check */
            position: absolute;
            /* ¡Nuevo! Posiciona el ícono de forma independiente */
            left: 0;
            /* Lo coloca al inicio del padding-left del li */
            top: 0.1em;
            /* Ajuste fino de alineación vertical */
            font-size: 1.2em;
            line-height: 1;
            flex-shrink: 0;
            /* Asegura que no se encoja */
        }

        .next-steps-section li span {
            margin-bottom: 0.5rem;
            /* Espacio entre la descripción y el código */
            display: block;
            /* Asegura que cada span ocupe su propia línea */
        }

        .next-steps-section code {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            border-radius: 5px;
            padding: 0.4em 0.8em;
            /* Aumentado padding para más aire alrededor del texto del código */
            font-family: 'Roboto Mono', monospace;
            font-weight: 600;
            display: block;
            /* ¡Clave! Hace que el código ocupe toda la línea */
            word-break: break-all;
            /* Asegura que el texto largo se rompa */
            white-space: pre-wrap;
            /* Mantiene saltos de línea y espacios en código */
            max-width: 100%;
            /* Asegura que no se desborde */
        }

        /* Footer Section */
        .footer-section {
            font-size: 0.9rem;
            color: var(--text-light);
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            margin-top: 2rem;
            opacity: 0.9;
        }

        /* Animations */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .dashboard {
                grid-template-columns: 2fr 1.2fr;
                grid-template-rows: auto 1fr auto auto;
                gap: 2rem;
                padding: 3rem;
                grid-template-areas:
                    "header header"
                    "status-info stack"
                    "actions-links next-steps"
                    "phpinfo phpinfo"
                    "footer footer";
            }

            .phpinfo-section {
                grid-area: phpinfo;
            }

            .header-section {
                grid-area: header;
                align-items: flex-start;
                text-align: left;
            }

            .status-info-section {
                grid-area: status-info;
            }

            .stack-section {
                grid-area: stack;
            }

            .actions-links-section {
                grid-area: actions-links;
            }

            .next-steps-section {
                grid-area: next-steps;
            }

            .footer-section {
                grid-area: footer;
            }

            h1 {
                font-size: 3.5rem;
            }

            p.subtitle {
                font-size: 1.35rem;
            }

            /* Reajuste para que el logo Docker quede a la izquierda en desktop si se prefiere ahí */
            .docker-logo {
                position: static;
                /* Eliminar posicionamiento absoluto para fluir con el contenido */
                margin-bottom: 0;
                order: 1;
                /* Ordena el logo antes del texto si quieres que aparezca a la izquierda del H1 */
                margin-right: 1.5rem;
                /* Espacio a la derecha del logo */
            }

            .header-content {
                display: flex;
                /* Permite que el logo y el texto estén en la misma línea */
                align-items: center;
                justify-content: flex-start;
                /* Alinea a la izquierda */
                width: 100%;
                /* Asegura que ocupe todo el ancho disponible */
            }
        }

        @media (min-width: 1024px) {
            .dashboard {
                grid-template-columns: 1.8fr 1fr;
                grid-template-rows: auto 1fr auto;
                gap: 2.5rem;
                padding: 3.5rem;
            }

            h1 {
                font-size: 4rem;
            }

            p.subtitle {
                font-size: 1.45rem;
            }

            .docker-logo {
                width: 140px;
            }
        }

        /* Solo afecta el info-grid dentro de la sección phpinfo-section */
        .phpinfo-section .info-grid {
            display: block;
        }

        .phpinfo-section .info-grid>div {
            margin-bottom: 1rem;
        }

        /* Accessibility: Visually hidden content */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }
    </style>
</head>

<body>
    <div class="dashboard" role="main">
        <header class="panel header-section">
            <div class="header-content">
                <img class="docker-logo"
                    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg"
                    alt="Logo de Docker, un diseño estilizado de una ballena azul">
                <div>
                    <h1>¡Docker PHP Stack Listo!</h1>
                    <p class="subtitle">
                        <span class="status-dot success"></span>
                        ¡Sistema en marcha! Tu entorno es moderno, rápido y seguro.
                    </p>
                </div>
            </div>
        </header>

        <section class="panel status-info-section" aria-labelledby="status-heading">
            <h2 id="status-heading">Estado de los Servicios</h2>
            <div class="status-list">
                <div class="status-item">
                    <span class="status-dot <?php echo $mysqlStatus ? 'success' : 'danger'; ?>"></span>
                    <strong>MySQL:</strong>
                    <span class="status-message">
                        <?php echo $mysqlStatus ? 'Conectado' : 'Error de Conexión'; ?>
                        <br>
                        <small><?php echo $mysqlMessage; ?></small>
                    </span>
                </div>
                <!-- <div class="status-item">
                    <span class="status-dot <?php echo $pgsqlStatus ? 'success' : 'danger'; ?>"></span>
                    <strong>PostgreSQL:</strong>
                    <span class="status-message">
                        <?php echo $pgsqlStatus ? 'Conectado' : 'Error de Conexión'; ?>
                        <br>
                        <small><?php echo $pgsqlMessage; ?></small>
                    </span>
                </div> -->
                <!--
                <div class="status-item">
                    <span class="status-dot <?php echo $redisStatus ? 'success' : 'danger'; ?>"></span>
                    <strong>Redis:</strong>
                    <span class="status-message">
                        <?php echo $redisStatus ? 'Conectado' : 'Error de Conexión'; ?>
                        <br>
                        <small><?php echo $redisMessage; ?></small>
                    </span>
                </div>
                -->
            </div>

            <h2 class="sr-only">Información del Proyecto</h2>
            <div class="info-grid">
                <div>
                    <strong>Ruta Raíz:</strong>
                    <code>/var/www/html</code>
                </div>
                <div>
                    <strong>Directorio Público:</strong>
                    <code>/var/www/html/public</code>
                </div>
                <div>
                    <strong>Página por Defecto:</strong>
                    <code>index.php</code>
                </div>
                <div>
                    <strong>Versión de PHP:</strong>
                    <code><?php echo phpversion(); ?></code>
                </div>
                <div>
                    <strong>IP del Servidor:</strong>
                    <code><?php echo $_SERVER['SERVER_ADDR'] ?? 'N/A'; ?></code>
                </div>
            </div>
        </section>

        <section class="panel stack-section" aria-labelledby="technologies-heading">
            <h2 id="technologies-heading">Tecnologías Incluidas</h2>
            <div class="stack-list">
                <div class="stack-item" title="PHP 8.1.32: El lenguaje de scripting web que impulsa tu aplicación.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg"
                        alt="Icono de PHP">
                    PHP 8.1.32
                </div>
                <div class="stack-item" title="Nginx 1.28: Servidor web de alto rendimiento para servir tus archivos.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nginx/nginx-original.svg"
                        alt="Icono de Nginx">
                    Nginx 1.28
                </div>
                <div class="stack-item" title="MySQL 8.0: Sistema de gestión de bases de datos relacionales.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg"
                        alt="Icono de MySQL">
                    MySQL 8.0
                </div>
                <!-- <div class="stack-item" title="PostgreSQL: Sistema de gestión de bases de datos objeto-relacional.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg"
                        alt="Icono de PostgreSQL">
                    PostgreSQL
                </div> -->
                <!-- <div class="stack-item" title="Redis: Almacén de datos en memoria utilizado para caching y colas.">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/redis/redis-original.svg"
                        alt="Icono de Redis">
                    Redis
                </div> -->
            </div>
        </section>

        <section class="panel actions-links-section" aria-labelledby="actions-heading">
            <h2 id="actions-heading">Acciones Rápidas y Recursos</h2>
            <div class="quick-actions">
                <button type="button" class="action-button" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Actualizar Estado
                </button>
                <button type="button" class="action-button"
                    onclick="window.open('https://github.com/jsrivero22/docker-config', '_blank')">
                    <i class="fab fa-github"></i> Repositorio GitHub
                </button>
                <button type="button" class="action-button"
                    onclick="alert('Para obtener ayuda, consulta los enlaces de documentación a continuación o contacta al mantenedor.')">
                    <i class="fas fa-question-circle"></i> Ayuda
                </button>
            </div>
            <nav class="links-grid" aria-label="Enlaces de Documentación Relacionados">
                <a href="https://github.com/jsrivero22/docker-config" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-book"></i> Docs Docker
                </a>
                <a href="https://www.php.net/manual/en/" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-book-open"></i> Docs PHP
                </a>
                <a href="https://nginx.org/en/docs/" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-book"></i> Docs Nginx
                </a>
                <a href="https://dev.mysql.com/doc/" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-database"></i> Docs MySQL
                </a>
                <!-- <a href="https://www.postgresql.org/docs/" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-database"></i> Docs PostgreSQL
                </a> -->
                <!-- <a href="https://redis.io/docs/" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-gripfire"></i> Docs Redis
                </a> -->
            </nav>
        </section>

        <section class="panel next-steps-section" aria-labelledby="next-steps-heading">
            <h3 id="next-steps-heading">Próximos Pasos Esenciales:</h3>
            <ul>
                <li>
                    <span>Coloca tus archivos de aplicación PHP dentro del directorio.</span>
                    <code>app/</code>
                </li>
                <li>
                    <span>Asegúrate de que tu punto de entrada principal sea.</span>
                    <code>index.php</code>
                    <span>o configura Nginx para uno diferente.</span>
                </li>
                <li>
                    <span>Ejecuta para instalar las dependencias de PHP.</span>
                    <code>docker compose exec app composer install</code>
                </li>
                <li>
                    <span>Para migraciones de base de datos (ejemplo de Laravel):</span>
                    <code>docker compose exec app php artisan migrate</code>
                </li>
                <li>
                    <span>Revisa los logs para solucionar problemas.</span>
                    <code>docker compose logs</code>
                </li>
                <li>
                    <span>Visita en tu navegador para ver esta página y tu aplicación.</span>
                    <code>http://localhost</code>
                </li>
            </ul>
        </section>

        <section class="panel phpinfo-section" aria-labelledby="phpinfo-heading">
            <h2 id="phpinfo-heading">Información de PHP</h2>
            <div class="info-grid">
                <div>
                    <strong>Versión de PHP:</strong>
                    <code><?php echo phpversion(); ?></code>
                </div>
                <div>
                    <strong>Modo de ejecución:</strong>
                    <code><?php echo php_sapi_name(); ?></code>
                </div>
                <div>
                    <strong>Directorio de PHP:</strong>
                    <code><?php echo PHP_BINDIR; ?></code>
                </div>
                <div>
                    <strong>Archivo php.ini cargado:</strong>
                    <code><?php echo php_ini_loaded_file() ?: 'No cargado'; ?></code>
                </div>
                <div>
                    <strong>Archivos de configuración adicionales:</strong>
                    <ul style="margin:0; padding-left:1.2em; font-size:0.97em;">
                        <?php
                        $scanned = php_ini_scanned_files();
                        if ($scanned) {
                            foreach (explode(',', $scanned) as $file) {
                                echo "<li>" . trim($file) . "</li>";
                            }
                        } else {
                            echo "<li>No hay archivos adicionales</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div>
                    <strong>Variables de entorno:</strong>
                    <ul style="margin:0; padding-left:1.2em; font-size:0.97em; max-height:120px; overflow:auto;">
                        <?php
                        foreach ($_ENV as $key => $value) {
                            echo "<li><b>$key:</b> <code>$value</code></li>";
                        }
                        ?>
                    </ul>
                </div>
                <div>
                    <strong>Módulos de PHP cargados:</strong>
                    <ul style="margin:0; padding-left:1.2em; columns:6; font-size:0.97em; max-height:120px; overflow:auto;">
                        <?php
                        $modules = get_loaded_extensions();
                        sort($modules);
                        foreach ($modules as $mod) {
                            echo "<li>$mod</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div>
                    <strong>Variables de configuración seleccionadas:</strong>
                    <ul style="margin:0; padding-left:1.2em; font-size:0.97em;">
                        <?php
                        $keys = [
                            'date.timezone',
                            'default_charset',
                            'error_reporting',
                            'file_uploads',
                            'max_file_uploads',
                            'session.save_path',
                            'session.gc_maxlifetime',
                            'short_open_tag',
                            'zend.assertions'
                        ];
                        foreach ($keys as $key) {
                            echo "<li><b>$key:</b> " . ini_get($key) . "</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </section>

        <footer class="footer-section">
            <p>&copy; <?php echo date('Y'); ?> Docker PHP-Nginx-MySQL-Redis Starter &mdash; Desarrollado con 💙 por Antonio Salcedo</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ejemplo de funcionalidad adicional: copiar al portapapeles
            document.querySelectorAll('code').forEach(codeBlock => {
                codeBlock.addEventListener('click', () => {
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(codeBlock.textContent.trim())
                            .then(() => {
                                const originalText = codeBlock.textContent;
                                codeBlock.textContent = '¡Copiado!';
                                setTimeout(() => {
                                    codeBlock.textContent = originalText;
                                }, 1500);
                            })
                            .catch(err => console.error('Error al copiar:', err));
                    } else {
                        // Fallback para navegadores antiguos
                        const range = document.createRange();
                        range.selectNode(codeBlock);
                        window.getSelection().removeAllRanges();
                        window.getSelection().addRange(range);
                        document.execCommand('copy');
                        window.getSelection().removeAllRanges();
                        alert('Texto copiado al portapapeles: ' + codeBlock.textContent);
                    }
                });
            });

            // Añadir tooltips dinámicos para los ítems de la pila (ejemplo básico)
            document.querySelectorAll('.stack-item').forEach(item => {
                const title = item.getAttribute('title');
                if (title) {
                    item.removeAttribute('title'); // Remove default browser tooltip
                    item.setAttribute('data-tooltip', title);
                }
            });
        });
    </script>
</body>

</html>