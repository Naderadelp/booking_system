<x-app-layout>

    <a href="{{ route('booking') }}" class="text-xs text-blue-500">&larr; Go Back</a>

    <h1 class="text-2xl font-medium mt-6">
        Now Choosea service from {{ $employee->name }}
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 mt-6">
        @foreach ($services as $service)
        <a href="#" class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray-50/75">
            <div class="text-sm font-medium text-slate-600">{{ $service->title }}</div>
            <div class="text-sm font-medium text-slate-400 mt-1">{{ $service->price }}</div>
            <div class="text-sm font-medium text-slate-400 mt-2">{{ $service->duration }} minutes</div>

        </a>
        @endforeach
    </div>
</x-app-layout>