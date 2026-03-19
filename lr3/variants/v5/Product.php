<?php
/**
 * Клас Musician — модель музиканта
 *
 * Використовується у всіх завданнях ЛР3 (варіант 5).
 */

class Musician
{
    public string $name;
    public string $instrument;
    public int $yearsPlaying;

    /**
     * Конструктор — задає початкові значення властивостей
     */
    public function __construct(string $name = '', string $instrument = '', int $yearsPlaying = 0)
    {
        $this->name = $name;
        $this->instrument = $instrument;
        $this->yearsPlaying = $yearsPlaying;
    }

    /**
     * Виводить інформацію про музиканта
     */
    public function getInfo(): string
    {
        return "Музикант: {$this->name}, Інструмент: {$this->instrument}, Років гри: {$this->yearsPlaying}";
    }

    /**
     * При клонуванні — встановлює значення за замовчанням
     */
    public function __clone(): void
    {
        $this->name = 'Новий музикант';
        $this->instrument = 'Без інструменту';
        $this->yearsPlaying = 0;
    }
}
