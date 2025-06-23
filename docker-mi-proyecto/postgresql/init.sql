-- Create a sample table
CREATE TABLE IF NOT EXISTS example (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample data
INSERT INTO example (name, description) VALUES
('Example 1', 'Description for example 1'),
('Example 2', 'Description for example 2'),
('Example 3', 'Description for example 3');

-- Create a user and grant privileges
DO
$$
BEGIN
   IF NOT EXISTS (
      SELECT FROM pg_catalog.pg_roles WHERE rolname = 'user'
   ) THEN
      CREATE ROLE "user" LOGIN PASSWORD 'password';
   END IF;
END
$$;

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO "user";
