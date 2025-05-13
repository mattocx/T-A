@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    $user = Auth::user();
    $photoUrl = $user->photo
        ? Storage::url($user->photo)
        : asset('storage/default-avatar.png');
@endphp

<div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center gap-4">
        <img src="{{ $photoUrl }}" class="h-10 w-10 rounded-full object-cover" alt="Profile">
        <div class="flex flex-col justify-center">
            <span class="font-semibold text-sm text-gray-900 dark:text-white">
                {{ $user->name }}
            </span>
            <span class="text-xs text-gray-600 dark:text-gray-400 capitalize">
                {{ $user->role }}
            </span>
        </div>
    </div>
</div>
