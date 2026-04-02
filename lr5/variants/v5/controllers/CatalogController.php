<?php

class CatalogController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_list(): void
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM cars ORDER BY id DESC');
            $stmt->execute();
            $cars = $stmt->fetchAll();
        } catch (PDOException $e) {
            $cars = [];
            $_SESSION['flash_success'] = 'Помилка читання каталогу авто.';
        }

        $this->render('catalog/list', [
            'cars' => $cars,
        ], 'Каталог авто');
    }

    public function action_create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'INSERT INTO cars (brand, model, year, price, engine_type)
                         VALUES (:brand, :model, :year, :price, :engine_type)'
                    );
                    $stmt->execute([
                        ':brand' => trim($old['brand']),
                        ':model' => trim($old['model']),
                        ':year' => (int)$old['year'],
                        ':price' => (float)$old['price'],
                        ':engine_type' => trim($old['engine_type']),
                    ]);

                    $_SESSION['flash_success'] = 'Автомобіль додано!';
                    $this->redirect('catalog/list');
                    return;
                } catch (PDOException $e) {
                    $errors['db'] = 'Не вдалося зберегти запис в базу даних.';
                }
            }
        }

        $this->render('catalog/create', [
            'errors' => $errors,
            'old' => $old,
        ], 'Додати авто');
    }

    public function action_edit(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $id = (int)$this->request->get('id', 0);
        if ($id <= 0) {
            $this->redirect('catalog/list');
            return;
        }

        try {
            $stmt = $this->db->prepare('SELECT * FROM cars WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $car = $stmt->fetch();
        } catch (PDOException $e) {
            $car = false;
        }

        if (!$car) {
            $_SESSION['flash_success'] = 'Авто не знайдено.';
            $this->redirect('catalog/list');
            return;
        }

        $errors = [];

        if ($this->request->isPost()) {
            $data = $this->request->allPost();
            $errors = $this->validate($data);

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'UPDATE cars SET brand = :brand, model = :model, year = :year,
                         price = :price, engine_type = :engine_type WHERE id = :id'
                    );
                    $stmt->execute([
                        ':brand' => trim($data['brand']),
                        ':model' => trim($data['model']),
                        ':year' => (int)$data['year'],
                        ':price' => (float)$data['price'],
                        ':engine_type' => trim($data['engine_type']),
                        ':id' => $id,
                    ]);

                    $_SESSION['flash_success'] = 'Дані авто оновлено!';
                    $this->redirect('catalog/list');
                    return;
                } catch (PDOException $e) {
                    $errors['db'] = 'Не вдалося оновити запис.';
                }
            }

            $car = array_merge($car, $data);
        }

        $this->render('catalog/edit', [
            'car' => $car,
            'errors' => $errors,
        ], 'Редагувати авто');
    }

    public function action_delete(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if ($this->request->isPost()) {
            $id = (int)$this->request->post('id', 0);

            if ($id > 0) {
                try {
                    $stmt = $this->db->prepare('DELETE FROM cars WHERE id = :id');
                    $stmt->execute([':id' => $id]);
                    $_SESSION['flash_success'] = 'Авто видалено!';
                } catch (PDOException $e) {
                    $_SESSION['flash_success'] = 'Помилка видалення авто.';
                }
            }
        }

        $this->redirect('catalog/list');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (trim($data['brand'] ?? '') === '') {
            $errors['brand'] = 'Марка є обов\'язковою.';
        }

        if (trim($data['model'] ?? '') === '') {
            $errors['model'] = 'Модель є обов\'язковою.';
        }

        $year = $data['year'] ?? '';
        $currentYear = (int)date('Y') + 1;
        if ($year === '' || !ctype_digit((string)$year) || (int)$year < 1950 || (int)$year > $currentYear) {
            $errors['year'] = 'Рік має бути в діапазоні 1950-' . $currentYear . '.';
        }

        $price = $data['price'] ?? '';
        if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
            $errors['price'] = 'Ціна має бути додатнім числом.';
        }

        $allowedEngines = ['бензин', 'дизель', 'електро', 'гібрид'];
        $engineType = mb_strtolower(trim($data['engine_type'] ?? ''));
        if (!in_array($engineType, $allowedEngines, true)) {
            $errors['engine_type'] = 'Тип двигуна: бензин, дизель, електро або гібрид.';
        }

        return $errors;
    }
}
