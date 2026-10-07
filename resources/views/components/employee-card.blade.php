@props(['employee'])

<li>
    <a class="flex items-center rounded-2xl border-gray-300 bg-gray-100 py-3 px-6 shadow border gap-3 text-inherit no-underline hover:bg-yellow-300 duration-150" href="{{ route('employees.show', $employee) }}">
        <img class="flex border border-gray-400 rounded-full bg-gray-300 object-cover w-20 h-20 min-w-20" src="{{ $employee->photo_url }}" width="80" height="80" alt="{{ $employee->name }}">
        <div>
            <h2 class="text-lg font-semibold m-0 mb-1">{{ $employee->name }}</h2>
            <div>{{ $employee->position }}</div>
        </div>
    </a>
</li>
