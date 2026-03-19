# Помилка: PHP не розпізнається (php: The term 'php' is not recognized)

## Проблема

Коли ви намагаєтесь запустити PHP, з'являється помилка:

```
php : The term 'php' is not recognized as the name of a cmdlet, function, script file, or operable program.
Check the spelling of the name, or if a path was included, verify that the path is correct and try again.
```

## Причина

PHP не встановлено на вашому комп'ютері або не доданий до системної змінної `PATH`.

## Рішення

### Варіант 1: Автоматичне встановлення (рекомендовано)

1. Откройте PowerShell в корневій папці проекту
2. Перейдіть в папку `setup`:

   ```powershell
   cd setup
   ```

3. Запустіть скрипт базильної установки:

   ```powershell
   .\install-basic.ps1
   ```

   Цей скрипт автоматично встановить:
   - Scoop (package manager)
   - PHP 8.x
   - Git

4. **Важливо:** Закрийте та змініть відкритий PowerShell/Terminal, щоб оновити змінні середовища (PATH)

5. Перевірте установку:
   ```powershell
   php -v
   ```

### Варіант 2: Ручне встановлення через Scoop

Якщо перший варіант не спрацював, спробуйте ручні команди:

1. Встановіть Scoop (якщо не встановлено):

   ```powershell
   Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
   Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh')
   ```

2. Встановіть PHP:git fetch upstream

   ```powershell
   scoop install php
   ```

3. Закрийте та змініть PowerShell, щоб оновити PATH

4. Перевірте:
   ```powershell
   php -v
   ```

### Варіант 3: Встановлення PHP без Scoop

Якщо Scoop не працює, встановіть PHP безпосередньо з [php.net](https://windows.php.net/download/):

1. Завантажте архів з PHP (Thread Safe, 64-bit для більшості)
2. Розпакуйте в папку (наприклад: `C:\php`)
3. Доданьте папку PHP до системної змінної PATH:
   - Откройте **System Properties** (Win + X → System)
   - Перейдіть на **Advanced tab** → **Environment Variables**
   - Знайдіть змінну `Path` у **System variables** та натисніть **Edit**
   - Додайте нову запис з шляхом до папки PHP (наприклад: `C:\php`)
   - Натисніть OK та закрийте всі вікна

4. Закрийте та змініть PowerShell/CMD та перевірте:
   ```powershell
   php -v
   ```

## Запуск локального сервера

Після успішної установки PHP ви можете запустити локальний сервер:

```powershell
php -S localhost:8000
```

Тепер зайдіть на http://localhost:8000 у браузері.

## Додаткова допомога

- Переконайтесь, що ви використовуєте PowerShell **з правами адміністратора** при встановленні
- Якщо помилка зберігається після установки, спробуйте перезавантажити комп'ютер
- Переконайтесь, що PATH коректно оновлена (закрийте всі termіnali та відкрийте нові)
