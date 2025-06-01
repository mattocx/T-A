@extends('layouts.auth')

@section('title')
    {{ __('Login Customer') }}
@endsection

@section('main')
<div class="flex justify-center">
    <img src="{{ asset('images/logo.png') }}" class="w-40 lg:w-40" />
</div>

<h3 class="mx-auto max-w-xs text-2xl mt-8 font-semibold text-center text-pink-700">
    {{ __('Portal Customer') }}
</h3>

<div class="mt-8 flex flex-col items-center">
    <div class="w-full flex-1">
        <form action="{{ route('filament.customer.auth.login') }}" method="POST">
            @csrf
            <div class="mx-auto max-w-xs">

                {{-- Input User ID --}}
                <input
                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white @error('id') border-red-500 focus:border-red-500 @enderror"
                    type="text" placeholder="{{ __('User ID') }}" name="id" value="{{ old('id') }}" />

                {{-- Menampilkan error khusus untuk kolom id --}}
                @if ($errors->has('id'))
                    <div class="text-red-600 mt-2 text-sm">
                        @if(session('html_error'))
                            {!! $errors->first('id') !!}
                        @else
                            {{ $errors->first('id') }}
                        @endif
                    </div>
                @endif

                {{-- Input Password --}}
                <input
                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5 @error('password') border-red-500 focus:border-red-500 @enderror"
                    type="password" placeholder="Password" name="password" />
                @error('password')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror

                {{-- Tombol Submit --}}
                <button type="submit"
                    class="mt-5 tracking-wide font-semibold bg-pink-400 text-white w-full py-4 rounded-lg hover:bg-pink-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                    <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <path d="M20 8v6M23 11h-6" />
                    </svg>
                    <span class="ml-3">
                        {{ __('Sign In') }}
                    </span>
                </button>

                <p class="mt-6 text-xs text-gray-600 text-center">
                    I agree to abide by Cartesian Kinetics
                    <a href="#" class="border-b border-gray-500 border-dotted">
                        Terms of Service
                    </a>
                    and its
                    <a href="#" class="border-b border-gray-500 border-dotted">
                        Privacy Policy
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('preload')
    <link rel='preload' href='{{ asset('images/logo.png') }}' as='image' type='image/png'/>
@endpush
