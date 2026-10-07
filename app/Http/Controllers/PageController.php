<?php

namespace App\Http\Controllers;

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
use App\Support\SiteContent;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index', [
            'courses' => Course::visible()->get(),
            'advantages' => Advantage::visible()->get(),
            'teachers' => Employee::visible()->where('role', Role::Teacher)->limit(6)->get(),
            'news' => News::visible()->get(),
            'partners' => Partner::visible()->get(),
            'reviews' => Review::visible()->get(),
        ]);
    }

    public function about()
    {
        $this->ensurePublished('about');

        return view('pages.about');
    }

    public function courses()
    {
        $this->ensurePublished('courses');

        return view('pages.courses.index', [
            'courses' => Course::visible()->get(),
        ]);
    }

    public function course(Course $course)
    {
        $this->ensurePublished('courses');
        abort_unless($course->is_published, 404);

        $course->load(['employees' => fn ($query) => $query->visible()]);

        return view('pages.courses.show', compact('course'));
    }

    public function employees()
    {
        $this->ensurePublished('employees');

        $employees = Employee::visible()->get()->groupBy(fn ($employee) => $employee->role->value);

        return view('pages.employees.index', [
            'admins' => $employees->get(Role::Admin->value, collect()),
            'teachers' => $employees->get(Role::Teacher->value, collect()),
        ]);
    }

    public function employee(Employee $employee)
    {
        $this->ensurePublished('employees');
        abort_unless($employee->is_published, 404);

        $employee->load(['certificates', 'courses' => fn ($query) => $query->visible()]);

        return view('pages.employees.show', compact('employee'));
    }

    public function camp()
    {
        $this->ensurePublished('camp');

        return view('pages.camp');
    }

    public function services()
    {
        $this->ensurePublished('services');

        return view('pages.services', [
            'services' => Service::visible()->get(),
        ]);
    }

    public function galleries()
    {
        $this->ensurePublished('galleries');

        return view('pages.galleries.index', [
            'galleries' => Gallery::visible()->get(),
        ]);
    }

    public function gallery(Gallery $gallery)
    {
        $this->ensurePublished('galleries');
        abort_unless($gallery->is_published, 404);

        return view('pages.galleries.show', compact('gallery'));
    }

    public function faq()
    {
        $this->ensurePublished('faq');

        return view('pages.faq', [
            'faqs' => Faq::visible()->get(),
        ]);
    }

    /**
     * Pages switched off on the "Контент" admin page are not available.
     */
    protected function ensurePublished(string $page): void
    {
        abort_unless(SiteContent::isPublished($page), 404);
    }
}
