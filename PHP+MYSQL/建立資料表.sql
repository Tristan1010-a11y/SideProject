CREATE DATABASE city_db;

USE city_db;

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    population INT NOT NULL
);

INSERT INTO cities (name, country, population) VALUES
('Taipei', 'Taiwan', 2700000),
('Kaohsiung', 'Taiwan', 2770000),
('New York', 'USA', 8419600),
('London', 'UK', 8982000);
