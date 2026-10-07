<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Content used to be stored as one record per language (a "locale" column).
 * Now every translatable column is JSON holding all languages: {"ru": "...", "tj": "..."}.
 *
 * Existing ru/tj records are paired by their order (sort, id) and merged into the ru record.
 */
return new class extends Migration
{
    /** @var array<string, list<string>> */
    protected array $localized = [
        'courses' => ['title', 'description', 'banner_title', 'banner_text', 'price', 'duration', 'content_title'],
        'employees' => ['name', 'position', 'bio', 'video_title'],
        'galleries' => ['title'],
        'news' => ['title', 'excerpt'],
        'reviews' => ['title', 'text', 'author_name', 'author_caption'],
        'advantages' => ['title', 'text'],
        'faqs' => ['question', 'answer'],
        'services' => ['title', 'text'],
    ];

    /** @var list<string> */
    protected array $certificateColumns = ['title', 'description'];

    public function up(): void
    {
        foreach ([...$this->localized, 'certificates' => $this->certificateColumns] as $table => $columns) {
            Schema::table($table, function (Blueprint $blueprint) use ($columns) {
                foreach ($columns as $column) {
                    $blueprint->longText($column)->nullable()->change();
                }
            });
        }

        foreach ($this->localized as $table => $columns) {
            foreach (DB::table($table)->get() as $row) {
                DB::table($table)->where('id', $row->id)->update($this->wrap($row, $columns, $row->locale));
            }
        }

        $locales = DB::table('employees')->pluck('locale', 'id');

        foreach (DB::table('certificates')->get() as $row) {
            DB::table('certificates')->where('id', $row->id)
                ->update($this->wrap($row, $this->certificateColumns, $locales[$row->employee_id] ?? 'ru'));
        }

        foreach ($this->localized as $table => $columns) {
            $this->mergePairs($table, $columns);
        }

        foreach ($this->localized as $table => $columns) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropIndex(['locale']);
                $blueprint->dropColumn('locale');
            });
        }

        foreach ([...$this->localized, 'certificates' => $this->certificateColumns] as $table => $columns) {
            Schema::table($table, function (Blueprint $blueprint) use ($columns) {
                foreach ($columns as $column) {
                    $blueprint->json($column)->nullable()->change();
                }
            });
        }
    }

    /**
     * Turns plain values into {"<locale>": value}; course blocks get the same for their texts.
     *
     * @param  list<string>  $columns
     * @return array<string, string|null>
     */
    protected function wrap(object $row, array $columns, string $locale): array
    {
        $values = [];

        foreach ($columns as $column) {
            $values[$column] = $row->{$column} === null ? null : $this->encode([$locale => $row->{$column}]);
        }

        if (property_exists($row, 'blocks') && $row->blocks) {
            $values['blocks'] = $this->encode(array_map(fn (array $block) => [
                ...$block,
                'title' => [$locale => $block['title'] ?? null],
                'items' => [$locale => $block['items'] ?? null],
            ], json_decode($row->blocks, true) ?: []));
        }

        return $values;
    }

    /**
     * @param  list<string>  $columns
     */
    protected function mergePairs(string $table, array $columns): void
    {
        $ru = DB::table($table)->where('locale', 'ru')->orderBy('sort')->orderBy('id')->get()->values();
        $tj = DB::table($table)->where('locale', 'tj')->orderBy('sort')->orderBy('id')->get()->values();

        foreach ($ru as $index => $target) {
            $source = $tj[$index] ?? null;

            if (! $source) {
                break;
            }

            $values = [];

            foreach ($columns as $column) {
                $values[$column] = $this->mergeJson($target->{$column}, $source->{$column});
            }

            if ($table === 'courses') {
                $values['blocks'] = $this->mergeBlocks($target->blocks, $source->blocks);

                DB::table('contact_requests')->where('course_id', $source->id)->update(['course_id' => $target->id]);
            }

            if ($table === 'employees') {
                $this->mergeCertificates($target->id, $source->id);
            }

            DB::table($table)->where('id', $target->id)->update($values);
            DB::table($table)->where('id', $source->id)->delete();
        }
    }

    protected function mergeCertificates(int $targetId, int $sourceId): void
    {
        $targets = DB::table('certificates')->where('employee_id', $targetId)->orderBy('sort')->orderBy('id')->get()->values();
        $sources = DB::table('certificates')->where('employee_id', $sourceId)->orderBy('sort')->orderBy('id')->get()->values();

        foreach ($sources as $index => $source) {
            $target = $targets[$index] ?? null;

            if (! $target) {
                DB::table('certificates')->where('id', $source->id)->update(['employee_id' => $targetId]);

                continue;
            }

            DB::table('certificates')->where('id', $target->id)->update([
                'title' => $this->mergeJson($target->title, $source->title),
                'description' => $this->mergeJson($target->description, $source->description),
                'image' => $target->image ?? $source->image,
            ]);
        }
    }

    protected function mergeBlocks(?string $target, ?string $source): ?string
    {
        $targetBlocks = json_decode($target ?? '[]', true) ?: [];
        $sourceBlocks = json_decode($source ?? '[]', true) ?: [];

        if (! $targetBlocks && ! $sourceBlocks) {
            return $target;
        }

        $merged = [];

        foreach (range(0, max(count($targetBlocks), count($sourceBlocks)) - 1) as $index) {
            $a = $targetBlocks[$index] ?? [];
            $b = $sourceBlocks[$index] ?? [];

            $merged[] = [
                'image' => $a['image'] ?? $b['image'] ?? null,
                'title' => array_merge($b['title'] ?? [], $a['title'] ?? []),
                'items' => array_merge($b['items'] ?? [], $a['items'] ?? []),
            ];
        }

        return $this->encode($merged);
    }

    protected function mergeJson(?string $target, ?string $source): ?string
    {
        $merged = array_merge(json_decode($source ?? 'null', true) ?? [], json_decode($target ?? 'null', true) ?? []);

        return $merged ? $this->encode($merged) : null;
    }

    protected function encode(mixed $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Restores one ru record per item; Tajik texts are lost.
     */
    public function down(): void
    {
        foreach ([...$this->localized, 'certificates' => $this->certificateColumns] as $table => $columns) {
            Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                foreach ($columns as $column) {
                    $blueprint->longText($column)->nullable()->change();
                }

                if ($table !== 'certificates') {
                    $blueprint->string('locale', 5)->default('ru')->index();
                }
            });

            foreach (DB::table($table)->get() as $row) {
                $values = [];

                foreach ($columns as $column) {
                    $values[$column] = json_decode($row->{$column} ?? 'null', true)['ru'] ?? null;
                }

                if ($table === 'courses' && $row->blocks) {
                    $values['blocks'] = $this->encode(array_map(fn (array $block) => [
                        ...$block,
                        'title' => $block['title']['ru'] ?? null,
                        'items' => $block['items']['ru'] ?? null,
                    ], json_decode($row->blocks, true) ?: []));
                }

                DB::table($table)->where('id', $row->id)->update($values);
            }
        }
    }
};
