-- Crea una tabla de ejemplo
CREATE TABLE IF NOT EXISTS ejemplo (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserta algunos datos de ejemplo
INSERT INTO ejemplo (nombre, descripcion) VALUES
('Ejemplo 1', 'Descripción del ejemplo 1'),
('Ejemplo 2', 'Descripción del ejemplo 2'),
('Ejemplo 3', 'Descripción del ejemplo 3');

-- Crea un usuario y otorga permisos
DO
$$
BEGIN
   IF NOT EXISTS (
      SELECT FROM pg_catalog.pg_roles WHERE rolname = 'usuario'
   ) THEN
      CREATE ROLE usuario LOGIN PASSWORD 'contraseña';
   END IF;
END
$$;

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO usuario;
