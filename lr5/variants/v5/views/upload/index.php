<?php
$images = $images ?? [];
$message = $message ?? '';
$error = $error ?? '';
$oldTitle = $oldTitle ?? '';
?>

<h1>Завантаження зображень</h1>
<p>Завантажте зображення (JPEG, PNG, GIF, WebP, до 5 МБ). Файли зберігаються у <code>data/uploads/</code>.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=upload/index" enctype="multipart/form-data" class="form">
    <div class="form__group">
        <label for="upload_title" class="form__label">Назва зображення <span class="required">*</span></label>
        <input type="text" id="upload_title" name="image_title" class="form__input"
               value="<?= htmlspecialchars($oldTitle) ?>"
               maxlength="100"
               placeholder="Наприклад: Toyota Camry 2022, вид спереду">
    </div>

    <div class="form__group">
        <label for="upload_image" class="form__label">Оберіть зображення <span class="required">*</span></label>
        <input type="file" id="upload_image" name="image" class="form__input" accept="image/*" required>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Завантажити</button>
    </div>
</form>

<h2>Галерея (<?= count($images) ?>)</h2>

<?php if (empty($images)): ?>
    <p class="text-muted">Зображень ще немає.</p>
<?php else: ?>
    <div class="gallery">
        <?php foreach ($images as $img): ?>
            <div class="gallery__item">
                <img src="<?= htmlspecialchars($img['url']) ?>" alt="<?= htmlspecialchars($img['title']) ?>" class="gallery__img">
                <div class="gallery__info">
                    <span class="gallery__name"><?= htmlspecialchars($img['title']) ?></span>
                    <span class="gallery__meta"><?= htmlspecialchars($img['date']) ?> &middot; <?= round($img['size'] / 1024) ?> КБ</span>
                    <span class="gallery__meta">Файл: <?= htmlspecialchars($img['name']) ?></span>
                    <form method="POST" action="index.php?route=upload/index" style="margin-top:8px"
                          onsubmit="return confirm('Видалити це зображення?')">
                        <input type="hidden" name="delete_file" value="<?= htmlspecialchars($img['name']) ?>">
                        <button type="submit" class="btn btn--small btn--danger">Видалити</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
