<?php

class GuestbookController extends PageController
{
    private string $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->filePath = DATA_DIR . '/comments.txt';
    }

    public function action_index(): void
    {
        [$message, $errors, $old] = $this->pullFlashState();

        if ($this->request->isPost()) {
            $name = trim($this->request->post('name', ''));
            $comment = trim($this->request->post('comment', ''));
            $errors = [];
            $old = [
                'name' => $name,
                'comment' => $comment,
            ];

            if ($name === '') {
                $errors['name'] = "Ім'я є обов'язковим.";
            }
            if ($comment === '') {
                $errors['comment'] = 'Коментар є обов\'язковим.';
            }

            if (empty($errors)) {
                $name = str_replace(["\r", "\n"], ' ', $name);
                $comment = str_replace(["\r", "\n"], ' ', $comment);
                $name = str_replace('|', '/', $name);
                $comment = str_replace('|', '/', $comment);
                $line = date('Y-m-d H:i') . '|' . $name . '|' . $comment;
                file_put_contents($this->filePath, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
                $message = 'Коментар додано!';
                $old = [];
            }

            $this->storeFlashState($message, $errors, $old);
            $this->redirect('guestbook/index');
            return;
        }

        $comments = $this->readComments();

        $this->render('guestbook/index', [
            'comments' => $comments,
            'message' => $message,
            'errors' => $errors,
            'old' => $old,
        ], 'Гостьова книга');
    }

    private function pullFlashState(): array
    {
        $message = (string)($_SESSION['guestbook_flash_message'] ?? '');
        $errors = $_SESSION['guestbook_flash_errors'] ?? [];
        $old = $_SESSION['guestbook_flash_old'] ?? [];

        if (!is_array($errors)) {
            $errors = [];
        }
        if (!is_array($old)) {
            $old = [];
        }

        unset(
            $_SESSION['guestbook_flash_message'],
            $_SESSION['guestbook_flash_errors'],
            $_SESSION['guestbook_flash_old']
        );

        return [$message, $errors, $old];
    }

    private function storeFlashState(string $message, array $errors, array $old): void
    {
        $_SESSION['guestbook_flash_message'] = $message;
        $_SESSION['guestbook_flash_errors'] = $errors;
        $_SESSION['guestbook_flash_old'] = $old;
    }

    private function readComments(): array
    {
        $comments = [];

        if (!file_exists($this->filePath)) {
            return $comments;
        }

        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $parts = explode('|', $line, 3);
            if (count($parts) === 3) {
                $comments[] = [
                    'date' => $parts[0],
                    'name' => $parts[1],
                    'comment' => $parts[2],
                ];
            }
        }

        return array_reverse($comments);
    }
}
