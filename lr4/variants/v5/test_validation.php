<?php
/**
 * Automated test for v5 RegformController validation.
 * Run: php test_validation.php
 */

require_once __DIR__ . '/config/init.php';

$controller = new RegformController();
$validate = new ReflectionMethod($controller, 'validate');
if (PHP_VERSION_ID < 80100) {
    $validate->setAccessible(true);
}

$tests = [
    [
        'name' => 'Empty number 1',
        'data' => ['number1' => '', 'number2' => '10', 'operation' => 'sum', 'expected_result' => '10'],
        'expectKey' => 'number1',
    ],
    [
        'name' => 'Number 2 is not numeric',
        'data' => ['number1' => '10', 'number2' => 'abc', 'operation' => 'sum', 'expected_result' => '10'],
        'expectKey' => 'number2',
        'expectContains' => 'має бути число',
    ],
    [
        'name' => 'Invalid operation',
        'data' => ['number1' => '10', 'number2' => '5', 'operation' => 'pow', 'expected_result' => '15'],
        'expectKey' => 'operation',
    ],
    [
        'name' => 'Division by zero',
        'data' => ['number1' => '100', 'number2' => '0', 'operation' => 'div', 'expected_result' => '0'],
        'expectKey' => 'number2',
        'expectContains' => 'Ділення на нуль неможливе',
    ],
    [
        'name' => 'Wrong expected result',
        'data' => ['number1' => '50', 'number2' => '5', 'operation' => 'mul', 'expected_result' => '200'],
        'expectKey' => 'expected_result',
        'expectContains' => 'Невірний результат',
    ],
    [
        'name' => 'Valid subtraction',
        'data' => ['number1' => '120000', 'number2' => '30000', 'operation' => 'sub', 'expected_result' => '90000'],
        'expectEmpty' => true,
    ],
    [
        'name' => 'Valid decimal with comma',
        'data' => ['number1' => '10,5', 'number2' => '2', 'operation' => 'div', 'expected_result' => '5.25'],
        'expectEmpty' => true,
    ],
];

$passed = 0;
$failed = 0;

foreach ($tests as $test) {
    $errors = $validate->invoke($controller, $test['data']);

    if (!empty($test['expectEmpty'])) {
        if (empty($errors)) {
            echo "PASS: {$test['name']}\n";
            $passed++;
        } else {
            echo "FAIL: {$test['name']} — expected no errors, got: " . json_encode($errors, JSON_UNESCAPED_UNICODE) . "\n";
            $failed++;
        }
    } else {
        $key = $test['expectKey'];
        if (!isset($errors[$key])) {
            echo "FAIL: {$test['name']} — expected error for '{$key}', got: " . json_encode($errors, JSON_UNESCAPED_UNICODE) . "\n";
            $failed++;
        } elseif (!empty($test['expectContains']) && strpos($errors[$key], $test['expectContains']) === false) {
            echo "FAIL: {$test['name']} — expected '{$test['expectContains']}' in error, got: {$errors[$key]}\n";
            $failed++;
        } else {
            echo "PASS: {$test['name']}\n";
            $passed++;
        }
    }
}

$total = $passed + $failed;
echo "\n{$passed}/{$total} tests passed.\n";

if ($failed > 0) {
    exit(1);
}
