<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Changelog</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .dark .glass {
            background: rgba(17, 24, 39, 0.7);
        }

        .timeline-line::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #0284c7 0%, transparent 100%);
        }

        .dark .timeline-line::before {
            background: linear-gradient(to bottom, #38bdf8 0%, transparent 100%);
        }
    </style>
</head>

<body
    class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors duration-300">
    <div class="relative min-h-screen">
        <!-- Background Decor -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div
                class="absolute -top-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-primary-100/50 dark:bg-primary-900/20 blur-[120px]">
            </div>
            <div
                class="absolute -bottom-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-100/50 dark:bg-blue-900/10 blur-[120px]">
            </div>
        </div>

        <!-- Navigation / Header -->
        <nav class="sticky top-0 z-50 glass border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span
                                class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                            <span
                                class="ml-1 text-sm font-medium text-primary-600 dark:text-primary-400">Changelog</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button onclick="toggleDarkMode()"
                            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-all duration-200 shadow-sm">
                            <svg id="sun-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M7.757 7.757l.707.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                            </svg>
                            <svg id="moon-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-12">
                    <!-- Filters -->
                    <div class="flex flex-wrap gap-2 mb-8 bg-white dark:bg-gray-900 p-4 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                        <button onclick="filterType('all')" class="filter-btn active px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200 bg-primary-600 text-white shadow-md shadow-primary-500/20">
                            All
                        </button>
                        @php
                            $allTypes = [];
                            foreach($changelog as $group) {
                                foreach(array_keys($group) as $type) {
                                    $allTypes[$type] = true;
                                }
                            }
                        @endphp
                        @foreach(array_keys($allTypes) as $type)
                            <button onclick="filterType('{{ Str::slug($type) }}')" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700">
                                {{ $type }}
                            </button>
                        @endforeach
                    </div>

                    <div id="changelog-container" class="relative pl-8 timeline-line">
                        @foreach($changelog as $date => $group)
                            <div class="date-group relative mb-16 group" data-dates="{{ $date }}">
                                <!-- Date Dot -->
                                <div
                                    class="absolute -left-10 top-1 w-4 h-4 bg-primary-500 rounded-full border-4 border-white dark:border-gray-950 shadow-md transition-transform duration-300 group-hover:scale-125">
                                </div>

                                <h2
                                    class="text-2xl font-extrabold text-gray-900 dark:text-white mb-8 bg-white dark:bg-gray-950 inline-block pr-4 pr-4 py-1">
                                    {{ $date }}</h2>

                                <div class="space-y-8">
                                    @foreach($group as $groupName => $commits)
                                        <div class="commit-group bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow duration-300" data-type="{{ Str::slug($groupName) }}">
                                            <div class="flex items-center mb-4">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300">
                                                    {{ $groupName }}
                                                </span>
                                            </div>

                                            <ul class="space-y-4">
                                                @foreach($commits as $commit)
                                                    <li class="flex items-start">
                                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3 flex-shrink-0"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>
                                                        <div>
                                                            <span
                                                                class="font-semibold text-gray-700 dark:text-gray-300">{{ $commit['scope'] }}</span>
                                                            <span
                                                                class="text-gray-600 dark:text-gray-400">{{ $commit['subject'] }}</span>
                                                            @if(isset($commit['author']))
                                                                <span
                                                                    class="ml-2 text-xs text-gray-400 dark:text-gray-500 font-medium">—
                                                                    {{ $commit['author'] }}</span>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($history)
                        <div class="pt-12 border-t border-gray-200 dark:border-gray-800">
                            <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 flex items-center">
                                <svg class="w-8 h-8 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Historical Changes
                            </h3>
                            <div
                                class="prose dark:prose-invert max-w-none bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-800">
                                {!! $history !!}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar / Releases -->
                <aside class="lg:col-span-4 space-y-8">
                    <div class="sticky top-24">
                        <section
                            class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                            <div
                                class="p-6 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/30">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Releases
                                </h2>
                                <span
                                    class="bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-400 text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter">Official</span>
                            </div>
                            <div class="p-6">
                                @if(count($releases) > 0)
                                    <ul class="space-y-6">
                                        @foreach($releases as $release)
                                            <li class="group">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h3
                                                        class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                                        {{ $release['name'] }}
                                                    </h3>
                                                    <time
                                                        class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ $release['created_at'] }}</time>
                                                </div>
                                                <div
                                                    class="text-xs text-gray-500 dark:text-gray-400 line-clamp-3 prose prose-sm dark:prose-invert prose-p:leading-tight">
                                                    {!! $release['body'] !!}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center py-8">
                                        <p class="text-sm text-gray-400">No releases found</p>
                                    </div>
                                @endif
                            </div>
                        </section>

                        <!-- Mini Footer -->
                        <div class="mt-8 px-6 text-center">
                            <p
                                class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em]">
                                Generated by Laravel GitHub Changelog</p>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <script>
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
                updateIcons(false);
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
                updateIcons(true);
            }
        }

        function updateIcons(isDark) {
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            if (isDark) {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }

        // Initialize theme
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            updateIcons(true);
        } else {
            document.documentElement.classList.remove('dark');
            updateIcons(false);
        }

        function filterType(type) {
            const commitGroups = document.querySelectorAll('.commit-group');
            const dateGroups = document.querySelectorAll('.date-group');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update buttons
            buttons.forEach(btn => {
                btn.classList.remove('bg-primary-600', 'text-white', 'shadow-md', 'shadow-primary-500/20', 'active');
                btn.classList.add('bg-gray-100', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-400');
            });

            const activeBtn = Array.from(buttons).find(btn => 
                (type === 'all' && btn.innerText.trim().toLowerCase() === 'all') || 
                (btn.getAttribute('onclick').includes(`'${type}'`))
            );
            
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-100', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-400');
                activeBtn.classList.add('bg-primary-600', 'text-white', 'shadow-md', 'shadow-primary-500/20', 'active');
            }

            // Filter groups
            dateGroups.forEach(dateGroup => {
                let hasVisibleCommits = false;
                const groupsInDate = dateGroup.querySelectorAll('.commit-group');
                
                groupsInDate.forEach(group => {
                    if (type === 'all' || group.getAttribute('data-type') === type) {
                        group.style.display = 'block';
                        hasVisibleCommits = true;
                    } else {
                        group.style.display = 'none';
                    }
                });

                dateGroup.style.display = hasVisibleCommits ? 'block' : 'none';
            });
        }
    </script>
</body>

</html>