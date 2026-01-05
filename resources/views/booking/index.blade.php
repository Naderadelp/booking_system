<x-app-layout>
    <h1 class="text-2xl font-medium">
        Choose a Professional
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 mt-6">
        @foreach ($employees as $employee)
        <a href="{{ route('booking.employee',$employee) }}" class="py-8 px-4 border border-slate-200 rounded-lg shadow-sm flex flex-col items-center justify-center text-center hover:bg-gray-50/75">
                <img src="{{ $employee->profile_photo_url }}" alt="{{ $employee->name }}" class="rounded-full size-14 bg-slate-100">
                <div class="text-sm font-medium mt-3 text-slat-600">{{ $employee->name }}</div>
            </a>
        @endforeach
    </div>
</x-app-layout>