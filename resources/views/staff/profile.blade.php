<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navbar -->
            <div class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center md:hidden">
                            <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-700 hidden md:block">Profil Staff</span>
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
                <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('staff.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $staff->name) }}" class="w-full border-gray-300 rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Posisi</label>
                            <input type="text" name="position" value="{{ old('position', $staff->position) }}" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="password" class="w-full border-gray-300 rounded-lg p-2" autocomplete="new-password">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg p-2" autocomplete="new-password">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.querySelector('button');
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
