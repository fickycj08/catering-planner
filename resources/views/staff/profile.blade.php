<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Staff - Catering Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background-color: #f0f2f5; /* Warna latar belakang sedikit lebih lembut */
        }
        .sidebar-gradient {
            background: linear-gradient(160deg, #10b981 0%, #3b82f6 100%);
        }
        .btn-gradient {
            background: linear-gradient(to right, #10b981, #2563eb);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        /* Animasi untuk sidebar mobile */
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="antialiased">
    <div class="relative min-h-screen md:flex">
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

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
                            <a href="{{ route('staff.profile') }}" class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg {{ request()->routeIs('staff.profile') ? 'bg-white/20' : '' }}">
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

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800 hidden md:block">Profil Saya</h2>
                        <div class="flex items-center">
                           </div>
                    </div>
                </div>
            </header>
            
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-4xl mx-auto">
                    @if(session('success'))
                        <div class="mb-6 p-4 flex items-center bg-green-100 text-green-800 rounded-lg shadow-sm">
                            <i class="fas fa-check-circle mr-3 text-green-600"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium">Terdapat error pada input Anda:</h3>
                                    <ul class="mt-2 list-disc pl-5 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('staff.profile.update') }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Informasi Akun</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone', $staff->phone) }}" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-briefcase text-gray-400"></i>
                                        </div>
                                        <input type="text" id="position" name="position" value="{{ old('position', $staff->position) }}" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Ubah Password</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                     <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" id="password" name="password" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="new-password" placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-3 btn-gradient text-white font-bold rounded-lg shadow-md hover:shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        if (menuButton) {
            menuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                toggleSidebar();
            });
        }
    });
    </script>
</body>
</html>