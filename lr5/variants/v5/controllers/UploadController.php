<?php

class UploadController extends PageController
{
    private string $uploadDir;
    private string $metaFile;
    private array $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private int $maxSize = 5 * 1024 * 1024; // 5 MB

    public function __construct()
    {
        parent::__construct();
        $this->uploadDir = DATA_DIR . '/uploads';
        $this->metaFile = $this->uploadDir . '/metadata.json';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function action_index(): void
    {
        [$message, $error, $oldTitle] = $this->pullFlashState();

        if ($this->request->isPost()) {
            $deleteFile = trim((string)$this->request->post('delete_file', ''));

            if ($deleteFile !== '') {
                [$message, $error] = $this->handleDelete($deleteFile);
            } else {
                $oldTitle = trim((string)$this->request->post('image_title', ''));
                [$message, $error, $oldTitle] = $this->handleUpload($oldTitle);
            }

            $this->storeFlashState($message, $error, $oldTitle);
            $this->redirect('upload/index');
            return;
        }

        $images = $this->getImages();

        $this->render('upload/index', [
            'images' => $images,
            'message' => $message,
            'error' => $error,
            'oldTitle' => $oldTitle,
        ], 'Завантаження зображень');
    }

    private function pullFlashState(): array
    {
        $message = (string)($_SESSION['upload_flash_message'] ?? '');
        $error = (string)($_SESSION['upload_flash_error'] ?? '');
        $oldTitle = (string)($_SESSION['upload_flash_old_title'] ?? '');

        unset($_SESSION['upload_flash_message'], $_SESSION['upload_flash_error'], $_SESSION['upload_flash_old_title']);

        return [$message, $error, $oldTitle];
    }

    private function storeFlashState(string $message, string $error, string $oldTitle): void
    {
        $_SESSION['upload_flash_message'] = $message;
        $_SESSION['upload_flash_error'] = $error;
        $_SESSION['upload_flash_old_title'] = $oldTitle;
    }

    private function handleDelete(string $deleteFile): array
    {
        $safeFileName = basename($deleteFile);
        $ext = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));

        if (!preg_match('/^[A-Za-z0-9._-]+$/', $safeFileName) || !in_array($ext, $this->allowedExtensions, true)) {
            return ['', 'Некоректне ім\'я файлу для видалення.'];
        }

        $path = $this->uploadDir . '/' . $safeFileName;

        if (!is_file($path)) {
            return ['', 'Файл для видалення не знайдено.'];
        }

        if (!unlink($path)) {
            return ['', 'Не вдалося видалити зображення.'];
        }

        $this->removeTitleForImage($safeFileName);
        return ['Зображення видалено.', ''];
    }

    private function handleUpload(string $title): array
    {
        $file = $_FILES['image'] ?? null;

        if (!is_array($file) || !isset($file['error'], $file['name'], $file['tmp_name'], $file['size'])) {
            return ['', 'Оберіть зображення для завантаження.', $title];
        }

        if ($title === '') {
            return ['', 'Введіть назву зображення.', $title];
        }

        $titleLength = function_exists('mb_strlen') ? mb_strlen($title) : strlen($title);
        if ($titleLength > 100) {
            return ['', 'Назва зображення має бути не довше 100 символів.', $title];
        }

        $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['', 'Помилка завантаження файлу (код: ' . $file['error'] . ').', $title];
        }

        if ((int)$file['size'] > $this->maxSize) {
            return ['', 'Максимальний розмір файлу: 5 МБ.', $title];
        }

        if (!in_array($ext, $this->allowedExtensions, true)) {
            return ['', 'Дозволені формати: JPEG, PNG, GIF, WebP.', $title];
        }

        $realType = $this->detectMimeType((string)$file['tmp_name']);
        if ($realType === null || !in_array($realType, $this->allowedMimeTypes, true)) {
            return ['', 'Дозволені формати: JPEG, PNG, GIF, WebP.', $title];
        }

        $safeName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $dest = $this->uploadDir . '/' . $safeName;

        if (!move_uploaded_file((string)$file['tmp_name'], $dest)) {
            return ['', 'Не вдалося зберегти файл.', $title];
        }

        $this->saveTitleForImage($safeName, $title);
        return ['Зображення "' . htmlspecialchars($title) . '" завантажено!', '', ''];
    }

    private function getImages(): array
    {
        $images = [];
        $files = glob($this->uploadDir . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
        $metadata = $this->readMetadata();

        if ($files) {
            rsort($files);
            foreach ($files as $file) {
                $fileName = basename($file);
                $title = $metadata[$fileName] ?? pathinfo($fileName, PATHINFO_FILENAME);
                $images[] = [
                    'name' => $fileName,
                    'title' => $title,
                    'url' => 'data/uploads/' . $fileName,
                    'size' => filesize($file),
                    'date' => date('Y-m-d H:i', filemtime($file)),
                ];
            }
        }

        return $images;
    }

    private function readMetadata(): array
    {
        if (!is_file($this->metaFile)) {
            return [];
        }

        $raw = file_get_contents($this->metaFile);
        if (!is_string($raw) || $raw === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function writeMetadata(array $metadata): void
    {
        file_put_contents(
            $this->metaFile,
            json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            LOCK_EX
        );
    }

    private function saveTitleForImage(string $fileName, string $title): void
    {
        $metadata = $this->readMetadata();
        $metadata[$fileName] = $title;
        $this->writeMetadata($metadata);
    }

    private function removeTitleForImage(string $fileName): void
    {
        $metadata = $this->readMetadata();

        if (isset($metadata[$fileName])) {
            unset($metadata[$fileName]);
            $this->writeMetadata($metadata);
        }
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
