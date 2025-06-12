<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Staff Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6/index.global.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
        .sidebar-gradient {
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        }
    </style>
</head>
<body>
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 sidebar-gradient shadow-xl">
                <div class="flex items-center justify-center h-20 bg-white/10">
                    <div class="text-xl font-bold text-white">CATERING PRO</div>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <div class="px-4 py-6">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-green-600 shadow-md">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-white font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-green-100 text-sm">{{ auth()->user()->staff->position ?? 'Staff' }}</p>
                            </div>
                        </div>
                        <nav class="flex-1 space-y-1">
                            <a href="{{ route('staff.dashboard') }}" class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg mb-2 {{ request()->routeIs('staff.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-home mr-3"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('staff.schedule') }}" class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg mb-2 {{ request()->routeIs('staff.schedule') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                <span>Jadwal</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg">
                                <i class="fas fa-user-cog mr-3"></i>
                                <span>Profil</span>
                            </a>
                        </nav>
                    </div>
                </div>
                <div class="p-4">
                    <form action="{{ route('staff.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-all duration-300">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navbar -->
            <div class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center md:hidden">
                            <button id="menu-toggle" type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-700 hidden md:block">Jadwal Staff</span>
                        </div>
                        <div class="flex items-center">
                            <div class="ml-3 relative md:hidden">
                                <form action="{{ route('staff.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-1 text-red-500">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-6">
                <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg p-6">
                    <div id="calendar"></div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                events: @json($events)
            });
            calendar.render();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.querySelector('#menu-toggle');
            if (menuButton) {
                menuButton.addEventListener('click', () => {
                    const sidebar = document.querySelector('.md\\:flex.md\\:flex-shrink-0');
                    if (sidebar) {
                        sidebar.classList.toggle('hidden');
                        sidebar.classList.toggle('block');
                    }
                });
            }
        });
    </script>
</body>
</html>
