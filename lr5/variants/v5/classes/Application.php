<?php

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->initDatabase();
    }

    public function run(): void
    {
        $route = $this->router->parseRoute();

        $controllerName = ucfirst($route['controller']) . 'Controller';
        $actionName = 'action_' . $route['action'];

        if (!class_exists($controllerName)) {
            $this->show404("Контролер '{$route['controller']}' не знайдено.");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $actionName)) {
            $this->show404("Дію '{$route['action']}' не знайдено в контролері '{$route['controller']}'.");
            return;
        }

        $controller->$actionName();
    }

    private function initDatabase(): void
    {
        $dbPath = ROOT_DIR . '/database/app.db';
        $schemaPath = ROOT_DIR . '/database/schema.sql';
        if (!file_exists($schemaPath)) {
            return;
        }

        $db = Database::getInstance();
        $needInit = !file_exists($dbPath);
        $dbConfig = require ROOT_DIR . '/config/database.php';
        $dsn = (string)($dbConfig['dsn'] ?? '');

        if (!$needInit) {
            if (strpos($dsn, 'sqlite:') === 0) {
                $stmt = $db->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=:table");
                $stmt->execute([':table' => 'cars']);
                $needInit = !$stmt->fetch();
            } else {
                $stmt = $db->query("SHOW TABLES LIKE 'cars'");
                $needInit = !$stmt->fetch();
            }
        }

        if ($needInit) {
            $db->exec(file_get_contents($schemaPath));
        }

        $this->migrateUsersTable($db, $dsn);
    }

    private function migrateUsersTable(PDO $db, string $dsn): void
    {
        if (strpos($dsn, 'sqlite:') === 0) {
            if (!$this->sqliteTableExists($db, 'users')) {
                $db->exec(
                    'CREATE TABLE IF NOT EXISTS users (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        login VARCHAR(50) NOT NULL UNIQUE,
                        password VARCHAR(255) NOT NULL,
                        email VARCHAR(100) NOT NULL,
                        first_name VARCHAR(50) NOT NULL,
                        last_name VARCHAR(50) NOT NULL,
                        phone VARCHAR(20) DEFAULT \'\',
                        city VARCHAR(50) DEFAULT \'\',
                        gender VARCHAR(10) DEFAULT \'\',
                        about TEXT DEFAULT \'\',
                        birthday DATE DEFAULT NULL,
                        website VARCHAR(200) DEFAULT \'\',
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                    )'
                );
                return;
            }

            if (!$this->sqliteColumnExists($db, 'users', 'birthday')) {
                $db->exec('ALTER TABLE users ADD COLUMN birthday DATE DEFAULT NULL');
            }

            if (!$this->sqliteColumnExists($db, 'users', 'website')) {
                $db->exec("ALTER TABLE users ADD COLUMN website VARCHAR(200) DEFAULT ''");
            }
            return;
        }

        if (!$this->mysqlTableExists($db, 'users')) {
            $db->exec(
                'CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    login VARCHAR(50) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    first_name VARCHAR(50) NOT NULL,
                    last_name VARCHAR(50) NOT NULL,
                    phone VARCHAR(20) DEFAULT \'\',
                    city VARCHAR(50) DEFAULT \'\',
                    gender VARCHAR(10) DEFAULT \'\',
                    about TEXT,
                    birthday DATE NULL,
                    website VARCHAR(200) DEFAULT \'\',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )'
            );
            return;
        }

        if (!$this->mysqlColumnExists($db, 'users', 'birthday')) {
            $db->exec('ALTER TABLE users ADD COLUMN birthday DATE NULL');
        }

        if (!$this->mysqlColumnExists($db, 'users', 'website')) {
            $db->exec("ALTER TABLE users ADD COLUMN website VARCHAR(200) DEFAULT ''");
        }
    }

    private function sqliteColumnExists(PDO $db, string $table, string $column): bool
    {
        $stmt = $db->query('PRAGMA table_info(' . $table . ')');
        $columns = $stmt ? $stmt->fetchAll() : [];

        foreach ($columns as $col) {
            if (($col['name'] ?? '') === $column) {
                return true;
            }
        }

        return false;
    }

    private function sqliteTableExists(PDO $db, string $table): bool
    {
        $stmt = $db->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=:table");
        $stmt->execute([':table' => $table]);
        return (bool)$stmt->fetch();
    }

    private function mysqlColumnExists(PDO $db, string $table, string $column): bool
    {
        $stmt = $db->prepare(
            'SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = :column'
        );
        $stmt->execute([
            ':table' => $table,
            ':column' => $column,
        ]);

        $row = $stmt->fetch();
        return (int)($row['cnt'] ?? 0) > 0;
    }

    private function mysqlTableExists(PDO $db, string $table): bool
    {
        $stmt = $db->prepare(
            'SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.TABLES
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table'
        );
        $stmt->execute([':table' => $table]);
        $row = $stmt->fetch();
        return (int)($row['cnt'] ?? 0) > 0;
    }

    private function show404(string $message): void
    {
        http_response_code(404);
        $view = new PageView();
        $view->setTitle('404 — Сторінку не знайдено');
        $view->render('layout/404', ['message' => $message]);
    }
}
