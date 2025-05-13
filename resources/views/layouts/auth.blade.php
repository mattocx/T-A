<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') ?? 'Laravel' }}</title>
    <link rel="dns-prefetch" href="{{ url('/') }}"/>
    <link rel='preload' href='{{ asset('images/background.svg') }}' as='image' type='image/svg+xml'/>
    @stack('preload')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                @yield('main')
            </div>
            <div class="flex-1 bg-pink-100 text-center hidden lg:flex">
                <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                    style="background-image: url('{{ asset('images/background.png') }}');">
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
