<?php

class RegformController extends PageController
{
    private array $operationLabels = [
        'sum' => 'Додавання',
        'sub' => 'Віднімання',
        'mul' => 'Множення',
        'div' => 'Ділення',
    ];

    public function action_form(): void
    {
        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                $number1 = $this->parseNumber((string) ($old['number1'] ?? ''));
                $number2 = $this->parseNumber((string) ($old['number2'] ?? ''));
                $expectedResult = $this->parseNumber((string) ($old['expected_result'] ?? ''));
                $operation = $this->request->postString('operation');

                if ($number1 === null || $number2 === null || $expectedResult === null || !isset($this->operationLabels[$operation])) {
                    $errors['form'] = 'Не вдалося обробити дані форми.';
                } else {
                    $actualResult = $this->calculate($number1, $number2, $operation);

                    $_SESSION['reg_data'] = [
                        'number1' => $this->formatNumber($number1),
                        'number2' => $this->formatNumber($number2),
                        'operation' => $operation,
                        'operationLabel' => $this->operationLabels[$operation],
                        'expectedResult' => $this->formatNumber($expectedResult),
                        'actualResult' => $this->formatNumber($actualResult),
                    ];
                    $_SESSION['reg_success'] = true;

                    $this->redirect('regform/done');
                    return;
                }
            }
        }

        $this->render('regform/form', [
            'errors' => $errors,
            'old' => $old,
            'operations' => $this->operationLabels,
        ], 'Калькулятор вартості авто');
    }

    public function action_done(): void
    {
        if (empty($_SESSION['reg_success'])) {
            $this->redirect('regform/form');
            return;
        }

        $data = $_SESSION['reg_data'] ?? [];
        unset($_SESSION['reg_success'], $_SESSION['reg_data']);

        $this->render('regform/done', ['regData' => $data], 'Результат перевірено');
    }

    private function validate(array $data): array
    {
        $errors = [];

        $number1Raw = is_string($data['number1'] ?? '') ? trim($data['number1']) : '';
        $number2Raw = is_string($data['number2'] ?? '') ? trim($data['number2']) : '';
        $operation = is_string($data['operation'] ?? '') ? $data['operation'] : '';
        $expectedRaw = is_string($data['expected_result'] ?? '') ? trim($data['expected_result']) : '';

        $number1 = null;
        $number2 = null;
        $expectedResult = null;

        if ($number1Raw === '') {
            $errors['number1'] = 'Поле "Число 1" є обов\'язковим.';
        } else {
            $number1 = $this->parseNumber($number1Raw);
            if ($number1 === null) {
                $errors['number1'] = 'У полі "Число 1" має бути число.';
            }
        }

        if ($number2Raw === '') {
            $errors['number2'] = 'Поле "Число 2" є обов\'язковим.';
        } else {
            $number2 = $this->parseNumber($number2Raw);
            if ($number2 === null) {
                $errors['number2'] = 'У полі "Число 2" має бути число.';
            }
        }

        if (!isset($this->operationLabels[$operation])) {
            $errors['operation'] = 'Оберіть коректну математичну операцію.';
        }

        if ($expectedRaw === '') {
            $errors['expected_result'] = 'Поле "Результат" є обов\'язковим.';
        } else {
            $expectedResult = $this->parseNumber($expectedRaw);
            if ($expectedResult === null) {
                $errors['expected_result'] = 'У полі "Результат" має бути число.';
            }
        }

        if (!isset($errors['number2']) && $operation === 'div' && $number2 !== null && $this->numbersAreEqual($number2, 0.0)) {
            $errors['number2'] = 'Ділення на нуль неможливе';
        }

        if (empty($errors) && $number1 !== null && $number2 !== null && $expectedResult !== null) {
            $actualResult = $this->calculate($number1, $number2, $operation);

            if (!$this->numbersAreEqual($expectedResult, $actualResult)) {
                $errors['expected_result'] = 'Невірний результат. Правильна відповідь: ' . $this->formatNumber($actualResult);
            }
        }

        return $errors;
    }

    private function parseNumber(string $value): ?float
    {
        $normalized = str_replace(',', '.', trim($value));
        if ($normalized === '' || !is_numeric($normalized)) {
            return null;
        }

        return (float) $normalized;
    }

    private function calculate(float $number1, float $number2, string $operation): float
    {
        return match ($operation) {
            'sum' => $number1 + $number2,
            'sub' => $number1 - $number2,
            'mul' => $number1 * $number2,
            'div' => $number1 / $number2,
            default => 0.0,
        };
    }

    private function numbersAreEqual(float $left, float $right): bool
    {
        return abs($left - $right) < 0.0000001;
    }

    private function formatNumber(float $value): string
    {
        $rounded = round($value, 10);
        if ($this->numbersAreEqual($rounded, round($rounded))) {
            return (string) (int) round($rounded);
        }

        return rtrim(rtrim(number_format($rounded, 10, '.', ''), '0'), '.');
    }
}
