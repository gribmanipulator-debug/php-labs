<?php

class SettingsController extends PageController
{
    private array $availableColors = [
        '#71797E' => 'Металік сірий',
        '#1C1C1C' => 'Лаковий чорний',
        '#F8F8FF' => 'Перламутровий білий',
        '#CC0000' => 'Гоночний червоний',
        '#AAB2BD' => 'Хромований срібний',
    ];

    public function action_color(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost()) {
            $color = $this->request->post('bg_color', '#F8F8FF');

            if (array_key_exists($color, $this->availableColors)) {
                $_SESSION['bg_color'] = $color;
                $message = 'Колір фону збережено!';
            } else {
                $error = 'Невідомий колір.';
            }
        }

        $this->render('settings/color', [
            'colors' => $this->availableColors,
            'currentColor' => $_SESSION['bg_color'] ?? '#F8F8FF',
            'message' => $message,
            'error' => $error,
        ], 'Колір фону');
    }

    public function action_greeting(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost()) {
            $name = trim($this->request->post('greeting_name', ''));
            $gender = $this->request->post('greeting_gender', '');

            if ($name === '') {
                $error = "Ім'я не може бути порожнім.";
            } elseif (!in_array($gender, ['male', 'female'], true)) {
                $error = 'Оберіть стать.';
            } else {
                setcookie('greeting_name', $name, time() + 30 * 24 * 3600, '/');
                setcookie('greeting_gender', $gender, time() + 30 * 24 * 3600, '/');

                $_COOKIE['greeting_name'] = $name;
                $_COOKIE['greeting_gender'] = $gender;

                $message = 'Привітання збережено в cookie!';
            }
        }

        $this->render('settings/greeting', [
            'message' => $message,
            'error' => $error,
            'currentName' => $_COOKIE['greeting_name'] ?? '',
            'currentGender' => $_COOKIE['greeting_gender'] ?? '',
        ], 'Привітання (Cookie)');
    }
}
