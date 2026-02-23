<?php
/**
 * Завдання 10: Результат реєстрації
 *
 * Варіант 5: відображає дані збережені в сесії
 * Вибір мови (іконки) → GET → cookie (6 місяців)
 */
session_start();
require_once __DIR__ . '/layout.php';

$data = $_SESSION['reg_data'] ?? null;

// Мова
$languages = [
    'uk' => 'Українська',
    'en' => 'English',
    'de' => 'Deutsch',
];
$lang = $_COOKIE['lang'] ?? 'uk';
if (!isset($languages[$lang])) {
    $lang = 'uk';
}

// --- Переклади ---
$t = [
    'uk' => [
        'title'          => 'Результат реєстрації',
        'lang_selected'  => 'Вибрана мова',
        'success_title'  => 'Реєстрацію завершено',
        'success_msg'    => 'Дані збережено в сесії',
        'login'          => 'Логін',
        'gender'         => 'Стать',
        'male'           => 'Чоловіча',
        'female'         => 'Жіноча',
        'not_specified'  => 'Не вказано',
        'city'           => 'Місто',
        'hobbies'        => 'Хобі',
        'about'          => 'Про себе',
        'photo'          => 'Фотографія',
        'back'           => 'Повернутися до форми',
        'error_title'    => 'Помилка',
        'error_msg'      => 'Дані реєстрації не знайдено. Заповніть форму спочатку.',
        'go_form'        => 'Перейти до форми',
        'hobby_sport'    => 'Спорт',
        'hobby_music'    => 'Музика',
        'hobby_reading'  => 'Читання',
        'hobby_gaming'   => 'Ігри',
        'hobby_cooking'  => 'Кулінарія',
        'hobby_travel'   => 'Подорожі',
    ],
    'en' => [
        'title'          => 'Registration Result',
        'lang_selected'  => 'Selected language',
        'success_title'  => 'Registration completed',
        'success_msg'    => 'Data saved in session',
        'login'          => 'Login',
        'gender'         => 'Gender',
        'male'           => 'Male',
        'female'         => 'Female',
        'not_specified'  => 'Not specified',
        'city'           => 'City',
        'hobbies'        => 'Hobbies',
        'about'          => 'About me',
        'photo'          => 'Photo',
        'back'           => 'Back to form',
        'error_title'    => 'Error',
        'error_msg'      => 'Registration data not found. Please fill in the form first.',
        'go_form'        => 'Go to form',
        'hobby_sport'    => 'Sport',
        'hobby_music'    => 'Music',
        'hobby_reading'  => 'Reading',
        'hobby_gaming'   => 'Gaming',
        'hobby_cooking'  => 'Cooking',
        'hobby_travel'   => 'Travel',
    ],
    'de' => [
        'title'          => 'Registrierungsergebnis',
        'lang_selected'  => 'Gewählte Sprache',
        'success_title'  => 'Registrierung abgeschlossen',
        'success_msg'    => 'Daten in Sitzung gespeichert',
        'login'          => 'Benutzername',
        'gender'         => 'Geschlecht',
        'male'           => 'Männlich',
        'female'         => 'Weiblich',
        'not_specified'  => 'Nicht angegeben',
        'city'           => 'Stadt',
        'hobbies'        => 'Hobbys',
        'about'          => 'Über mich',
        'photo'          => 'Foto',
        'back'           => 'Zurück zum Formular',
        'error_title'    => 'Fehler',
        'error_msg'      => 'Registrierungsdaten nicht gefunden. Bitte füllen Sie zuerst das Formular aus.',
        'go_form'        => 'Zum Formular',
        'hobby_sport'    => 'Sport',
        'hobby_music'    => 'Musik',
        'hobby_reading'  => 'Lesen',
        'hobby_gaming'   => 'Spiele',
        'hobby_cooking'  => 'Kochen',
        'hobby_travel'   => 'Reisen',
    ],
];
$tr = $t[$lang];

$hobbiesMap = [
    'sport'   => $tr['hobby_sport'],
    'music'   => $tr['hobby_music'],
    'reading' => $tr['hobby_reading'],
    'gaming'  => $tr['hobby_gaming'],
    'cooking' => $tr['hobby_cooking'],
    'travel'  => $tr['hobby_travel'],
];

$genderMap = ['male' => $tr['male'], 'female' => $tr['female']];

ob_start();
?>
<div class="demo-card demo-card-wide">
    <h2><?= htmlspecialchars($tr['title']) ?></h2>

    <div class="lang-notice"><?= htmlspecialchars($tr['lang_selected']) ?>: <?= htmlspecialchars($languages[$lang]) ?></div>

    <?php if ($data): ?>
    <div class="demo-result">
        <h3><?= htmlspecialchars($tr['success_title']) ?></h3>
        <div class="demo-result-value"><?= htmlspecialchars($tr['success_msg']) ?></div>
    </div>

    <div class="result-data mt-15">
        <div class="result-data-row">
            <span class="result-data-label"><?= htmlspecialchars($tr['login']) ?></span>
            <span class="result-data-value"><?= htmlspecialchars($data['login'] ?? '') ?></span>
        </div>
        <div class="result-data-row">
            <span class="result-data-label"><?= htmlspecialchars($tr['gender']) ?></span>
            <span class="result-data-value">
                <?= htmlspecialchars($genderMap[$data['gender'] ?? ''] ?? $tr['not_specified']) ?>
            </span>
        </div>
        <div class="result-data-row">
            <span class="result-data-label"><?= htmlspecialchars($tr['city']) ?></span>
            <span class="result-data-value"><?= htmlspecialchars($data['city'] ?? '') ?></span>
        </div>
        <div class="result-data-row">
            <span class="result-data-label"><?= htmlspecialchars($tr['hobbies']) ?></span>
            <span class="result-data-value">
                <?php
                $selectedHobbies = $data['hobbies'] ?? [];
                if (!empty($selectedHobbies)) {
                    $labels = array_reduce($selectedHobbies, function (array $acc, string $key) use ($hobbiesMap) {
                        if (isset($hobbiesMap[$key])) {
                            $acc[] = $hobbiesMap[$key];
                        }
                        return $acc;
                    }, []);
                    foreach ($labels as $label) {
                        echo '<span class="demo-tag demo-tag-primary">' . htmlspecialchars($label) . '</span> ';
                    }
                } else {
                    echo htmlspecialchars($tr['not_specified']);
                }
                ?>
            </span>
        </div>
        <div class="result-data-row">
            <span class="result-data-label"><?= htmlspecialchars($tr['about']) ?></span>
            <span class="result-data-value"><?= nl2br(htmlspecialchars($data['about'] ?? $tr['not_specified'])) ?></span>
        </div>

        <?php if (!empty($data['photo']) && file_exists(__DIR__ . '/' . $data['photo'])): ?>
        <div class="result-data-row">
            <span class="result-data-label"><?= htmlspecialchars($tr['photo']) ?></span>
            <span class="result-data-value">
                <img src="<?= htmlspecialchars($data['photo']) ?>" alt="<?= htmlspecialchars($tr['photo']) ?>" class="photo-preview">
            </span>
        </div>
        <?php endif; ?>
    </div>

    <div class="flex-buttons mt-15">
        <a href="task10_form.php" class="btn-secondary"><?= htmlspecialchars($tr['back']) ?></a>
    </div>

    <?php else: ?>
    <div class="demo-result demo-result-error">
        <h3><?= htmlspecialchars($tr['error_title']) ?></h3>
        <div class="demo-result-value"><?= htmlspecialchars($tr['error_msg']) ?></div>
    </div>
    <div class="flex-buttons mt-15">
        <a href="task10_form.php" class="btn-secondary"><?= htmlspecialchars($tr['go_form']) ?></a>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 10');
