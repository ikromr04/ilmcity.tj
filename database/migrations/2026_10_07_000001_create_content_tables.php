<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('banner')->nullable();
            $table->string('banner_title')->nullable();
            $table->text('banner_text')->nullable();
            $table->string('price')->nullable();
            $table->string('duration')->nullable();
            $table->string('content_title')->nullable();
            $table->json('blocks')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('role', 20)->default('teacher');
            $table->string('name');
            $table->string('position')->nullable();
            $table->longText('bio')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('course_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('title');
            $table->date('date')->nullable();
            $table->json('images')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('title');
            $table->text('text');
            $table->string('author_name');
            $table->string('author_caption')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('title');
            $table->text('text');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->string('url')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 5)->default('ru')->index();
            $table->string('title');
            $table->text('text');
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('locale', 5)->nullable();
            $table->boolean('is_processed')->default(false);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['settings', 'contact_requests', 'services', 'faqs', 'partners', 'advantages', 'reviews', 'news', 'galleries', 'certificates', 'course_employee', 'employees', 'courses'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
