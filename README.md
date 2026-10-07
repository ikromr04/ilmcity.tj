# IlmCity

Сайт образовательного центра IlmCity: Laravel 13, Blade + Livewire 4, Tailwind CSS 4, админка на Filament 5.

## Установка

```bash
composer install
cp .env.example .env && php artisan key:generate
# указать DB_* в .env (MySQL, база `ilmcity`)
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
```

Админка: `/admin` (пользователь из `DatabaseSeeder`, пароль можно задать через `ADMIN_PASSWORD`).

## Устройство

- Языки: `ru` (по умолчанию, без префикса) и `tj` (`/tj/...`). Строки интерфейса — `lang/tj.json`, контент — отдельные записи с полем `locale`.
- Контент из админки: курсы, сотрудники (+сертификаты), галерея, новости, отзывы, ценности, услуги, FAQ, партнёры.
- Заявки с формы в подвале (Livewire `ContactForm`) попадают в раздел «Заявки».
- Контакты, график работы, цифры и видео на главной — «Настройки сайта» (`App\Models\Setting`).
- Стили без Tailwind preflight, как в исходной вёрстке (см. `resources/css/app.css`).
