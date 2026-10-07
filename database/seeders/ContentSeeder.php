<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Advantage;
use App\Models\Course;
use App\Models\Employee;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Partner;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Demo content taken from the original markup (ilmcity.tj).
 * Texts are seeded in Russian; the Tajik tab of each record is filled in the admin
 * (until then the site shows the Russian text).
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();

        $this->content();

        foreach (['bobo.svg' => 'Bobo', 'zal.svg' => 'Zal', 'siyoma.svg' => 'Siyoma', 'kids.svg' => 'Kids'] as $file => $name) {
            Partner::create(['name' => $name, 'logo' => $this->image($file, 'partners')]);
        }
    }

    /**
     * Texts are stored in Russian; Tajik translations are added in the admin.
     */
    protected function content(): void
    {
        $teachers = collect([
            ['Манижа Тураева', 'Английский язык'],
            ['Нигина Каримова', 'Математика'],
            ['Фарзона Рахимова', 'Подготовка к школе'],
            ['Дилноза Саидова', 'Основы живописи'],
            ['Шахзод Назаров', 'Информатика'],
            ['Мадина Юсупова', 'Русский язык'],
        ])->map(fn ($item, $i) => Employee::create([
            'role' => Role::Teacher,
            'name' => $item[0],
            'position' => $item[1],
            'photo' => $this->image($i === 0 ? 'manija.png' : 'teacher.png', 'employees'),
            'bio' => $this->bio(),
            'sort' => $i,
        ]));

        collect([
            ['Зарина Олимова', 'Директор'],
            ['Гулноза Шарипова', 'Заместитель директора'],
            ['Фируза Ахмедова', 'Методист'],
        ])->each(fn ($item, $i) => Employee::create([
            'role' => Role::Admin,
            'name' => $item[0],
            'position' => $item[1],
            'photo' => $this->image('teacher.png', 'employees'),
            'bio' => $this->bio(),
            'sort' => $i,
        ]));

        foreach ($teachers as $teacher) {
            foreach (range(1, 2) as $n) {
                $teacher->certificates()->create([
                    'title' => 'Победитель конкурса "Интерактивная мозаика"-2077 на портале Поле чудес',
                    'description' => 'Мы разработали увлекательные занятия, которые помогут детям развивать интеллект, творчество и навыки общения.',
                    'image' => $this->image('cert.png', 'certificates'),
                    'sort' => $n,
                ]);
            }
        }

        $courses = [
            ['Подготовка к школе', 'Поможем вашему ребенку успешно адаптироваться к новому этапу в жизни: чтение, письмо, счёт и развитие речи.'],
            ['Математика', 'Развиваем логическое мышление и уверенность в решении задач — от простого счёта до олимпиадных заданий.'],
            ['Основы живописи', 'Знакомим детей с цветом, формой и композицией, помогаем раскрыть творческий потенциал.'],
            ['Английский', 'Английский язык — в игровой и познавательной форме мы помогаем детям развивать языковые навыки. Английский становится не просто предметом, а настоящим средством общения и познания мира.'],
            ['Информатика', 'Знакомство с технологиями и основами программирования.'],
            ['Русский язык', 'Грамотность, богатый словарный запас и умение красиво выражать свои мысли.'],
        ];

        foreach ($courses as $i => [$title, $description]) {
            $course = Course::create([
                'title' => $title,
                'description' => $description,
                'banner' => $this->image('courses.png', 'courses'),
                'banner_title' => 'Подготовка к школе для детей с 4 лет',
                'banner_text' => 'Поможем вашему ребенку успешно адаптироваться к новому этапу в жизни.',
                'price' => '150 сомони в месяц',
                'duration' => '6 месяцев',
                'content_title' => 'Подарите ребенку яркое будущее с нашими курсами!',
                'blocks' => [
                    [
                        'image' => $this->image('cert.png', 'courses/blocks'),
                        'title' => ['ru' => 'В программе'],
                        'items' => ['ru' => "Основы чтения и письма\nМатематика\nАнглийский язык\nРазвитие речи\nРазвитие коммуникативных навыков."],
                    ],
                    [
                        'image' => $this->image('cert.png', 'courses/blocks'),
                        'title' => ['ru' => 'Занятия проходят по будням'],
                        'items' => ['ru' => "Первая смена: 9:00 – 12:00\nВторая смена: 13:00 – 16:00\nТретья смена: 14:00 – 17:00"],
                    ],
                ],
                'sort' => $i,
            ]);

            $course->employees()->attach($teachers->random(2)->pluck('id'));
        }

        foreach (['Устойчивое развитие', 'Инновации', 'Вдохновение', 'Ответственность', 'Сотрудничество', 'Любознательность'] as $i => $title) {
            Advantage::create([
                'title' => $title,
                'text' => 'Мы в "IlmCity" верим в важность устойчивого развития. Наша цель — создать образовательную среду, которая будет способствовать долгосрочному прогрессу и процветанию наших студентов. Мы стремимся внедрять новейшие образовательные методы и технологии, чтобы наши ученики могли успешно адаптироваться к вызовам будущего и вносить свой вклад в развитие общества.',
                'sort' => $i,
            ]);
        }

        foreach (range(1, 6) as $i) {
            News::create([
                'title' => 'Новая программа по устойчивому развитию',
                'excerpt' => 'Мы запускаем уникальную программу, которая поможет студентам стать экспертами в области устойчивого развития. Не упустите шанс!',
                'image' => $this->image('news.png', 'news'),
                'sort' => $i,
            ]);
        }

        foreach (['Мама Арнольда', 'Папа Самира', 'Мама Лолы', 'Мама Карины', 'Папа Тимура', 'Мама Амины'] as $i => $caption) {
            Review::create([
                'title' => 'Устойчивое развитие',
                'text' => 'Занятия в этом центре помогли моему ребенку быстро адаптироваться к школьной программе. Он стал более самостоятельным, уверенным в себе и получил прочные знания, которые пригодятся ему в дальнейшем обучении. Я очень довольна результатами и рекомендую этот курс всем, кто хочет дать своему ребенку хорошее начало в школе.',
                'author_name' => 'Манижа Тураева',
                'author_caption' => $caption,
                'photo' => $this->image('teacher.png', 'reviews'),
                'sort' => $i,
            ]);
        }

        $services = [
            ['service-1.png', 'Развиваем речь, раскрываем потенциал'],
            ['service-2.png', 'Эмоциональная поддержка и развитие'],
            ['service-3.png', 'Зал для тренингов и мероприятий'],
            ['service-4.png', 'Уютное место для отдыха и общения'],
        ];

        foreach ($services as $i => [$image, $title]) {
            Service::create([
                'title' => $title,
                'text' => 'Наши занятия с логопедом помогают детям развивать правильную речь, улучшать дикцию и уверенно выражать свои мысли. Индивидуальный подход и эффективные методики обучения позволяют добиться отличных результатов.',
                'image' => $this->image($image, 'services'),
                'sort' => $i,
            ]);
        }

        $faqs = [
            ['Что такое IlmCity?', 'IlmCity — это образовательная платформа для будущего!'],
            ['Каковы наши ценности?', 'Устойчивое развитие, инновации и вдохновение!'],
            ['Как записаться на курсы?', 'Просто нажмите кнопку “Связаться с нами”!'],
            ['Кто наши преподаватели?', 'Настоящие эксперты и вдохновители!'],
            ['Где мы находимся?', 'В сердце инновационного образования!'],
        ];

        foreach ($faqs as $i => [$question, $answer]) {
            Faq::create(['question' => $question, 'answer' => $answer, 'sort' => $i]);
        }

        $images = array_map(fn ($n) => $this->image("gallery/{$n}.jpg", 'galleries'), range(1, 7));

        foreach (range(1, 4) as $i) {
            Gallery::create([
                'title' => 'День защиты детей в ilmcity',
                'date' => '2024-06-01',
                'images' => $images,
                'sort' => $i,
            ]);
        }
    }

    protected function settings(): void
    {
        Setting::put([
            'phone' => '+992 987 65 43 21',
            'email' => 'info@ilmcity.tj',
            'telegram' => null,
            'instagram' => null,
            'address' => ['ru' => 'Пулоди 43, Душанбе', 'tj' => 'Пулодӣ 43, Душанбе'],
            'hours' => [
                ['label' => ['ru' => 'По будням:', 'tj' => 'Рӯзҳои корӣ:'], 'value' => ['ru' => 'с 8:00 до 20:00', 'tj' => 'аз 8:00 то 20:00']],
                ['label' => ['ru' => 'По субботам:', 'tj' => 'Шанбеҳо:'], 'value' => ['ru' => 'с 09:00 до 18:00', 'tj' => 'аз 09:00 то 18:00']],
                ['label' => ['ru' => 'Вск - выходной', 'tj' => 'Якшанбе - рӯзи истироҳат'], 'value' => []],
            ],
            'license' => ['ru' => 'Лицензия МЮ РТ 2024 “Ъ” от 08 августа 2024', 'tj' => 'Иҷозатномаи ВА ҶТ 2024 “Ъ” аз 08 августи 2024'],
            'stats' => [
                ['value' => '130+', 'label_ru' => 'Постоянных учеников', 'label_tj' => 'Хонандагони доимӣ'],
                ['value' => '60+', 'label_ru' => 'Илмсити клаб', 'label_tj' => 'Илмсити клаб'],
                ['value' => '60+', 'label_ru' => 'Лагеря', 'label_tj' => 'Лагер'],
            ],
        ]);
    }

    /**
     * Copies a bundled image from public/images to the public disk so it can be managed in the admin.
     */
    protected function image(string $file, string $directory): string
    {
        $path = $directory.'/'.basename($file);

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, file_get_contents(public_path("images/{$file}")));
        }

        return $path;
    }

    protected function bio(): string
    {
        return '<p><strong>В 1993г. окончила Душанбинское педагогическое училище №3 с черным дипломом.</strong></p>'
            .'<p>Квалификация по диплому: учитель начальных классов; учитель ОИВТ в начальных классах</p>'
            .'<p><strong>В 1994г. окончила ДГОУ с красным дипломом</strong></p>'
            .'<p>Специальность: педагогика и методика начального обучения, квалификация: учитель начальных классов.</p>'
            .'<p><strong>Стаж работы 30 лет (с 21.12.1992г.).</strong></p>'
            .'<p>Учитель Высшей квалификац. категории</p>';
    }
}
