-- Users table (auth module)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(20) DEFAULT '',
    city VARCHAR(50) DEFAULT '',
    gender VARCHAR(10) DEFAULT '',
    about TEXT DEFAULT '',
    birthday DATE DEFAULT NULL,
    website VARCHAR(200) DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Cars table (CRUD module — Автосалон)
CREATE TABLE IF NOT EXISTS cars (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INTEGER NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    engine_type VARCHAR(30) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Seed cars
INSERT INTO cars (brand, model, year, price, engine_type) VALUES
    ('Toyota', 'Camry', 2022, 1380000.00, 'бензин'),
    ('Volkswagen', 'Passat', 2021, 1245000.00, 'дизель'),
    ('Tesla', 'Model 3', 2023, 1899000.00, 'електро'),
    ('BMW', 'X5', 2020, 2550000.00, 'дизель'),
    ('Hyundai', 'Tucson Hybrid', 2024, 1650000.00, 'гібрид'),
    ('Skoda', 'Octavia', 2019, 980000.00, 'бензин'),
    ('Audi', 'A6', 2022, 2410000.00, 'дизель'),
    ('Nissan', 'Leaf', 2021, 1125000.00, 'електро');
