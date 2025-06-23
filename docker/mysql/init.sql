-- create a sample table
CREATE TABLE IF NOT EXISTS example (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- insert some sample data
INSERT INTO example (name, description) VALUES
('Example 1', 'Description for example 1'),
('Example 2', 'Description for example 2'),
('Example 3', 'Description for example 3');

-- create a user and grant privileges
CREATE USER 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%';
FLUSH PRIVILEGES;
