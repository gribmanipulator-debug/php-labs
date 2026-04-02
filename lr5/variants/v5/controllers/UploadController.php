<?php

class UploadController extends PageController
{
    private string $uploadDir;
    private array $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private int $maxSize = 5 * 1024 * 1024; // 5 MB

    public function __construct()
    {
        parent::__construct();
        $this->uploadDir = DATA_DIR . '/uploads';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function action_index(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost() && isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $error = 'Помилка завантаження файлу (код: ' . $file['error'] . ').';
            } elseif ($file['size'] > $this->maxSize) {
                $error = 'Максимальний розмір файлу: 5 МБ.';
            } elseif (!in_array($ext, $this->allowedExtensions, true)) {
                $error = 'Дозволені формати: JPEG, PNG, GIF, WebP.';
            } else {
                $realType = $this->detectMimeType((string)$file['tmp_name']);
                if ($realType === null) {
                    $error = 'Не вдалося визначити тип файлу. Спробуйте інше зображення.';
                } elseif (!in_array($realType, $this->allowedMimeTypes, true)) {
                    $error = 'Дозволені формати: JPEG, PNG, GIF, WebP.';
                }
            }

            if ($error === '' && $ext !== '') {
                $safeName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $dest = $this->uploadDir . '/' . $safeName;

                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $message = 'Зображення "' . htmlspecialchars($file['name']) . '" завантажено!';
                } else {
                    $error = 'Не вдалося зберегти файл.';
                }
            }
        }

        $images = $this->getImages();

        $this->render('upload/index', [
            'images' => $images,
            'message' => $message,
            'error' => $error,
        ], 'Завантаження зображень');
    }

    private function getImages(): array
    {
        $images = [];
        $files = glob($this->uploadDir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

        if ($files) {
            rsort($files);
            foreach ($files as $file) {
                $images[] = [
                    'name' => basename($file),
                    'url' => 'data/uploads/' . basename($file),
                    'size' => filesize($file),
                    'date' => date('Y-m-d H:i', filemtime($file)),
                ];
            }
        }

        return $images;
    }

    private function detectMimeType(string $tmpPath): ?string
    {
        if (class_exists('finfo')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($tmpPath);
            if (is_string($mime) && $mime !== '') {
                return $mime;
            }
        }

        if (function_exists('exif_imagetype')) {
            $type = exif_imagetype($tmpPath);
            $map = [
                IMAGETYPE_JPEG => 'image/jpeg',
                IMAGETYPE_PNG => 'image/png',
                IMAGETYPE_GIF => 'image/gif',
                IMAGETYPE_WEBP => 'image/webp',
            ];
            if ($type !== false && isset($map[$type])) {
                return $map[$type];
            }
        }

        if (function_exists('getimagesize')) {
            $imgInfo = getimagesize($tmpPath);
            if (is_array($imgInfo) && isset($imgInfo['mime']) && is_string($imgInfo['mime'])) {
                return $imgInfo['mime'];
            }
        }

        return null;
    }
}
