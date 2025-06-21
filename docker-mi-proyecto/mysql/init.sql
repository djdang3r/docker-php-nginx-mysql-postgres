-- create una tabla de ejemplo
CREATE TABLE IF NOT EXISTS ejemplo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- inserta algunos datos de ejemplo
INSERT INTO ejemplo (nombre, descripcion) VALUES
('Ejemplo 1', 'Descripción del ejemplo 1'),
('Ejemplo 2', 'Descripción del ejemplo 2'),
('Ejemplo 3', 'Descripción del ejemplo 3');

-- crea un usuario y otorga permisos
CREATE USER 'usuario'@'%' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON *.* TO 'usuario'@'%';
FLUSH PRIVILEGES;
