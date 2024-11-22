@include('partials._header')

        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="//unpkg.com/alpinejs" defer></script>



@include('partials._footer')
