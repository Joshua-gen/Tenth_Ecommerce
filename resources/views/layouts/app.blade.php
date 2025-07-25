<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        @if(auth()->user()->hasRole('user'))
            <div class="relative bg-black h-[60px] overflow-hidden flex items-center">
                <div class="absolute flex animate-marquee m-0 whitespace-nowrap">
                    <div id="marquee" class="flex items-center"></div>
                    <div id="marquee-clone" class="flex items-center"></div>
                </div>
            
                <style>
                    @keyframes marquee {
                        from { transform: translateX(0); }
                        to { transform: translateX(-50%); }
                    }
            
                    .animate-marquee {
                        display: flex;
                        min-width: 200%;
                        animation: marquee 40s linear infinite;
                    }
            
                    .marquee-text {
                        font-size: 2.5rem; 
                        font-weight: bold;
                        color: #FFD700; 
                        text-transform: uppercase;
                        margin-right: 50px; 
                        line-height: 1; 
                        white-space: nowrap; 
                        display: flex;
                        align-items: center;
                    }
                </style>
            </div>
        @endif
             
            
        @if(auth()->check() && auth()->user()->hasRole('admin'))
            <livewire:layout.navigation />
        @else
            @livewire('header')
            @livewire('navbar')
        @endif
    
    


            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
        <script>
            const marquee = document.getElementById("marquee");
            const marqueeClone = document.getElementById("marquee-clone");
    
            for (let i = 0; i < 20; i++) { 
                const span = document.createElement("span");
                span.className = "marquee-text";
                span.innerHTML = "FREE SHIPPING 🔥";
                marquee.appendChild(span);
            }
            marqueeClone.innerHTML = marquee.innerHTML;
        </script>
    </body>
</html>
