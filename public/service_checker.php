<?php

class ServiceChecker
{
    private static function getEnvOrDefault($env, $default = '')
    {
        $val = getenv($env);
        return ($val !== false && $val !== '') ? $val : $default;
    }

    private static function checkPDO($type, $env, $dsnTemplate, $versionQuery, $successMsg, $errorMsg)
    {
        $status = null;
        $message = '';
        $version = '';
        $host = self::getEnvOrDefault($env['host']);
        $db   = self::getEnvOrDefault($env['db']);
        $user = self::getEnvOrDefault($env['user']);
        $pass = self::getEnvOrDefault($env['pass']);

        if ($host && $db && $user) {
            try {
                $dsn = sprintf($dsnTemplate, $host, $db);
                $pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 2,
                ]);
                $status = true;
                $stmt = $pdo->query($versionQuery);
                $version = $stmt ? $stmt->fetchColumn() : 'Desconocida';
                $message = $successMsg . $version;
            } catch (PDOException $e) {
                $status = false;
                $message = $errorMsg . $e->getMessage()
                    . " [host=$host, db=$db, user=$user]";
            }
        } else {
            $message = "Faltan variables de entorno para $type";
        }
        return ['status' => $status, 'message' => $message, 'version' => $version];
    }

    public static function checkMySQL()
    {
        return self::checkPDO(
            'MySQL',
            [
                'host' => 'MYSQL_HOST',
                'db'   => 'MYSQL_DATABASE',
                'user' => 'MYSQL_USER',
                'pass' => 'MYSQL_PASSWORD'
            ],
            'mysql:host=%s;dbname=%s',
            'SELECT VERSION()',
            'Conectado exitosamente! Versión: ',
            'Error de conexión a MySQL: '
        );
    }

    public static function checkPostgreSQL()
    {
        return self::checkPDO(
            'PostgreSQL',
            [
                'host' => 'POSTGRES_HOST',
                'db'   => 'POSTGRES_DB',
                'user' => 'POSTGRES_USER',
                'pass' => 'POSTGRES_PASSWORD'
            ],
            'pgsql:host=%s;dbname=%s',
            'SELECT version()',
            'Conectado exitosamente! ',
            'Error de conexión a PostgreSQL: '
        );
    }
}
