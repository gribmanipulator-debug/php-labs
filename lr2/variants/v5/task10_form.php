<?php
/**
 * Завдання 10: Реєстраційна форма
 *
 * Варіант 5: логін "tryzub_olha", міста з v5.md
 * POST, сесія, cookie (мова), завантаження фото
 * Вибір мови (іконки) → GET → cookie (6 місяців)
 */
session_start();
require_once __DIR__ . '/layout.php';

// --- Мова ---
$languages = [
    'uk' => 'Українська',
    'en' => 'English',
    'de' => 'Deutsch',
];

if (isset($_GET['lang']) && isset($languages[$_GET['lang']])) {
    $lang = $_GET['lang'];
    setcookie('lang', $lang, time() + 6 * 30 * 24 * 3600, '/');
} elseif (isset($_COOKIE['lang']) && isset($languages[$_COOKIE['lang']])) {
    $lang = $_COOKIE['lang'];
} else {
    $lang = 'uk';
}

// --- Переклади ---
$t = [
    'uk' => [
        'title'             => 'Реєстраційна форма',
        'lang_label'        => 'Мова:',
        'lang_selected'     => 'Вибрана мова',
        'errors_title'      => 'Помилки',
        'login'             => 'Логін',
        'login_placeholder' => 'Ваш логін',
        'password'          => 'Пароль',
        'password_ph'       => 'Мін. 4 символи',
        'password2'         => 'Повторіть пароль',
        'password2_ph'      => 'Ще раз',
        'gender'            => 'Стать',
        'male'              => 'Чоловіча',
        'female'            => 'Жіноча',
        'city'              => 'Місто',
        'city_default'      => '-- Оберіть місто --',
        'hobbies'           => 'Хобі',
        'about'             => 'Про себе',
        'about_ph'          => 'Розкажіть про себе...',
        'photo'             => 'Фотографія',
        'photo_saved'       => 'Поточне фото збережено в сесії',
        'submit'            => 'Зареєструватися',
        'err_login'         => 'Логін не може бути порожнім',
        'err_pass_len'      => 'Пароль повинен бути не менше 4 символів',
        'err_pass_match'    => 'Паролі не збігаються',
        'err_gender'        => 'Оберіть стать',
        'err_city'          => 'Оберіть місто',
        'err_photo'         => 'Дозволені формати фото: JPG, PNG, GIF, WEBP',
        'hobby_sport'       => 'Спорт',
        'hobby_music'       => 'Музика',
        'hobby_reading'     => 'Читання',
        'hobby_gaming'      => 'Ігри',
        'hobby_cooking'     => 'Кулінарія',
        'hobby_travel'      => 'Подорожі',
    ],
    'en' => [
        'title'             => 'Registration Form',
        'lang_label'        => 'Language:',
        'lang_selected'     => 'Selected language',
        'errors_title'      => 'Errors',
        'login'             => 'Login',
        'login_placeholder' => 'Your login',
        'password'          => 'Password',
        'password_ph'       => 'Min. 4 characters',
        'password2'         => 'Repeat password',
        'password2_ph'      => 'Again',
        'gender'            => 'Gender',
        'male'              => 'Male',
        'female'            => 'Female',
        'city'              => 'City',
        'city_default'      => '-- Select city --',
        'hobbies'           => 'Hobbies',
        'about'             => 'About me',
        'about_ph'          => 'Tell about yourself...',
        'photo'             => 'Photo',
        'photo_saved'       => 'Current photo saved in session',
        'submit'            => 'Register',
        'err_login'         => 'Login cannot be empty',
        'err_pass_len'      => 'Password must be at least 4 characters',
        'err_pass_match'    => 'Passwords do not match',
        'err_gender'        => 'Select gender',
        'err_city'          => 'Select city',
        'err_photo'         => 'Allowed photo formats: JPG, PNG, GIF, WEBP',
        'hobby_sport'       => 'Sport',
        'hobby_music'       => 'Music',
        'hobby_reading'     => 'Reading',
        'hobby_gaming'      => 'Gaming',
        'hobby_cooking'     => 'Cooking',
        'hobby_travel'      => 'Travel',
    ],
    'de' => [
        'title'             => 'Anmeldeformular',
        'lang_label'        => 'Sprache:',
        'lang_selected'     => 'Gewählte Sprache',
        'errors_title'      => 'Fehler',
        'login'             => 'Benutzername',
        'login_placeholder' => 'Ihr Benutzername',
        'password'          => 'Passwort',
        'password_ph'       => 'Min. 4 Zeichen',
        'password2'         => 'Passwort wiederholen',
        'password2_ph'      => 'Nochmal',
        'gender'            => 'Geschlecht',
        'male'              => 'Männlich',
        'female'            => 'Weiblich',
        'city'              => 'Stadt',
        'city_default'      => '-- Stadt wählen --',
        'hobbies'           => 'Hobbys',
        'about'             => 'Über mich',
        'about_ph'          => 'Erzählen Sie über sich...',
        'photo'             => 'Foto',
        'photo_saved'       => 'Aktuelles Foto in Sitzung gespeichert',
        'submit'            => 'Registrieren',
        'err_login'         => 'Benutzername darf nicht leer sein',
        'err_pass_len'      => 'Passwort muss mindestens 4 Zeichen lang sein',
        'err_pass_match'    => 'Passwörter stimmen nicht überein',
        'err_gender'        => 'Geschlecht wählen',
        'err_city'          => 'Stadt wählen',
        'err_photo'         => 'Erlaubte Formate: JPG, PNG, GIF, WEBP',
        'hobby_sport'       => 'Sport',
        'hobby_music'       => 'Musik',
        'hobby_reading'     => 'Lesen',
        'hobby_gaming'      => 'Spiele',
        'hobby_cooking'     => 'Kochen',
        'hobby_travel'      => 'Reisen',
    ],
];
$tr = $t[$lang];

// --- Міста (варіант 5) ---
$cities = [
    'Київ', 'Львів', 'Одеса', 'Харків', 'Дніпро',
    'Запоріжжя', 'Вінниця', 'Полтава', 'Чернігів', 'Тернопіль',
];

// --- Хобі (локалізовані) ---
$hobbies = [
    'sport'   => $tr['hobby_sport'],
    'music'   => $tr['hobby_music'],
    'reading' => $tr['hobby_reading'],
    'gaming'  => $tr['hobby_gaming'],
    'cooking' => $tr['hobby_cooking'],
    'travel'  => $tr['hobby_travel'],
];

// --- Автозаповнення з сесії ---
$sessionData = $_SESSION['reg_data'] ?? [];

// --- Обробка форми ---
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $city = $_POST['city'] ?? '';
    $selectedHobbies = $_POST['hobbies'] ?? [];
    $about = trim($_POST['about'] ?? '');

    // Валідація
    if ($login === '') {
        $errors[] = $tr['err_login'];
    }
    if (mb_strlen($password) < 4) {
        $errors[] = $tr['err_pass_len'];
    }
    if ($password !== $password2) {
        $errors[] = $tr['err_pass_match'];
    }
    if (!in_array($gender, ['male', 'female'])) {
        $errors[] = $tr['err_gender'];
    }
    if ($city === '') {
        $errors[] = $tr['err_city'];
    }

    // Обробка фото
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($_FILES['photo']['type'], $allowedTypes)) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $newName = uniqid('photo_') . '.' . $ext;
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $destination = $uploadDir . $newName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                $photoPath = 'uploads/' . $newName;
            }
        } else {
            $errors[] = $tr['err_photo'];
        }
    }

    // Зберігаємо в сесію
    $regData = [
        'login' => $login,
        'gender' => $gender,
        'city' => $city,
        'hobbies' => $selectedHobbies,
        'about' => $about,
        'photo' => $photoPath ?: ($sessionData['photo'] ?? ''),
    ];
    $_SESSION['reg_data'] = $regData;

    if (empty($errors)) {
        header('Location: task10_result.php');
        exit;
    }
}

// Для автозаповнення
$formData = [
    'login' => $_POST['login'] ?? $sessionData['login'] ?? 'tryzub_olha',
    'gender' => $_POST['gender'] ?? $sessionData['gender'] ?? '',
    'city' => $_POST['city'] ?? $sessionData['city'] ?? '',
    'hobbies' => $_POST['hobbies'] ?? $sessionData['hobbies'] ?? [],
    'about' => $_POST['about'] ?? $sessionData['about'] ?? '',
];

ob_start();
?>
<div class="demo-card demo-card-wide">
    <h2><?= htmlspecialchars($tr['title']) ?></h2>

    <!-- Вибір мови -->
    <div class="lang-selector">
        <span style="font-size: 14px; color: var(--color-text-muted); margin-right: 8px;"><?= htmlspecialchars($tr['lang_label']) ?></span>
        <?php foreach ($languages as $code => $name): ?>
        <a href="?lang=<?= $code ?>" class="<?= $lang === $code ? 'active' : '' ?>">
            <?= htmlspecialchars($name) ?>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="lang-notice"><?= htmlspecialchars($tr['lang_selected']) ?>: <?= htmlspecialchars($languages[$lang]) ?></div>

    <?php if (!empty($errors)): ?>
    <div class="demo-result demo-result-error">
        <h3><?= htmlspecialchars($tr['errors_title']) ?></h3>
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="demo-form">
        <!-- Логін -->
        <div class="form-group">
            <label for="login"><?= htmlspecialchars($tr['login']) ?></label>
            <input type="text" id="login" name="login" value="<?= htmlspecialchars($formData['login']) ?>" placeholder="<?= htmlspecialchars($tr['login_placeholder']) ?>" required>
        </div>

        <!-- Пароль -->
        <div class="form-group">
            <div class="form-row">
                <div>
                    <label for="password"><?= htmlspecialchars($tr['password']) ?></label>
                    <input type="password" id="password" name="password" placeholder="<?= htmlspecialchars($tr['password_ph']) ?>" required>
                </div>
                <div>
                    <label for="password2"><?= htmlspecialchars($tr['password2']) ?></label>
                    <input type="password" id="password2" name="password2" placeholder="<?= htmlspecialchars($tr['password2_ph']) ?>" required>
                </div>
            </div>
        </div>

        <!-- Стать -->
        <div class="form-group">
            <label><?= htmlspecialchars($tr['gender']) ?></label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="gender" value="male" <?= $formData['gender'] === 'male' ? 'checked' : '' ?>>
                    <?= htmlspecialchars($tr['male']) ?>
                </label>
                <label>
                    <input type="radio" name="gender" value="female" <?= $formData['gender'] === 'female' ? 'checked' : '' ?>>
                    <?= htmlspecialchars($tr['female']) ?>
                </label>
            </div>
        </div>

        <!-- Місто -->
        <div class="form-group">
            <label for="city"><?= htmlspecialchars($tr['city']) ?></label>
            <select id="city" name="city" required>
                <option value=""><?= htmlspecialchars($tr['city_default']) ?></option>
                <?php foreach ($cities as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>" <?= $formData['city'] === $c ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Хобі -->
        <div class="form-group">
            <label><?= htmlspecialchars($tr['hobbies']) ?></label>
            <div class="checkbox-group">
                <?php foreach ($hobbies as $key => $label): ?>
                <label>
                    <input type="checkbox" name="hobbies[]" value="<?= $key ?>" <?= in_array($key, $formData['hobbies']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($label) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Про себе -->
        <div class="form-group">
            <label for="about"><?= htmlspecialchars($tr['about']) ?></label>
            <textarea id="about" name="about" rows="3" placeholder="<?= htmlspecialchars($tr['about_ph']) ?>"><?= htmlspecialchars($formData['about']) ?></textarea>
        </div>

        <!-- Фотографія -->
        <div class="form-group">
            <label for="photo"><?= htmlspecialchars($tr['photo']) ?></label>
            <input type="file" id="photo" name="photo" accept="image/*">
            <?php if (!empty($sessionData['photo']) && file_exists(__DIR__ . '/' . $sessionData['photo'])): ?>
            <p style="font-size: 13px; color: var(--color-text-muted); margin-top: 4px;">
                <?= htmlspecialchars($tr['photo_saved']) ?>
            </p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit"><?= htmlspecialchars($tr['submit']) ?></button>
    </form>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 10');
