<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }

        .order-card {
            transition: all 0.3s ease;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .badge {
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .badge-in-progress {
            background: linear-gradient(45deg, #3b82f6, #2563eb);
            color: white;
        }

        .badge-completed {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
        }

        .badge-cancelled {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        }

        .stats-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
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
                            <div
                                class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-green-600 shadow-md">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-white font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-green-100 text-sm">{{ auth()->user()->staff->position ?? 'Staff' }}</p>

                            </div>
                        </div>
                        <nav class="flex-1 space-y-1">
                            <a href="{{ route('staff.dashboard') }}"
                                class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg mb-2 {{ request()->routeIs('staff.dashboard') ? 'bg-white/20' : '' }}">
                                <i class="fas fa-home mr-3"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('staff.schedule') }}"
                                class="flex items-center px-4 py-3 text-white hover:bg-white/10 rounded-lg mb-2 {{ request()->routeIs('staff.schedule') ? 'bg-white/20' : '' }}">
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
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-all duration-300">
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
                            <span class="text-gray-700 hidden md:block">Dashboard Staff</span>
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
                <div class="max-w-7xl mx-auto">
                    <!-- Welcome Card -->
                    <div class="stats-gradient rounded-2xl shadow-xl p-6 mb-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h1>
                                <p class="text-blue-100 mt-1">{{ now()->format('l, d F Y') }}</p>
                            </div>
                           
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow-lg p-5 transition-all hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Pesanan</p>
                                    <h2 class="text-3xl font-bold text-gray-700">{{ $assignedOrders->count() }}</h2>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="fas fa-clipboard-list text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg p-5 transition-all hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Pesanan Aktif</p>
                                    <h2 class="text-3xl font-bold text-gray-700">
                                        {{ $assignedOrders->where('order.status', 'in progress')->count() }}</h2>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg p-5 transition-all hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Pesanan Selesai</p>
                                    <h2 class="text-3xl font-bold text-gray-700">
                                        {{ $assignedOrders->where('order.status', 'completed')->count() }}</h2>
                                </div>
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Section -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-700">
                                <i class="fas fa-tasks mr-2 text-blue-600"></i>
                                Pesanan Yang Ditugaskan
                            </h3>
                        </div>

                        <div class="p-6">
                            @if($assignedOrders->isEmpty())
                                <div class="flex flex-col items-center justify-center py-12">
                                    <div class="bg-gray-100 p-5 rounded-full mb-4">
                                        <i class="fas fa-clipboard-list text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg">Belum ada tugas yang ditugaskan kepadamu.</p>
                                    <p class="text-gray-400 text-sm mt-2">Pesanan baru akan muncul di sini.</p>
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($assignedOrders as $assignment)
                                            <div class="order-card bg-white border border-gray-100 rounded-xl overflow-hidden">
                                                <div class="p-5">
                                                    <div class="flex justify-between items-start">
                                                        <div>
                                                            <h3 class="text-lg font-semibold text-gray-800">Order
                                                                #{{ $assignment->order->id }}</h3>
                                                            <p class="text-sm text-gray-500 mt-1">
                                                                {{ $assignment->order->scheduled_date }}</p>
                                                        </div>
                                                        <div>
                                                            @php
                                                                $statusClass = '';
                                                                switch ($assignment->order->status) {
                                                                    case 'pending':
                                                                        $statusClass = 'badge-pending';
                                                                        break;
                                                                    case 'in progress':
                                                                        $statusClass = 'badge-in-progress';
                                                                        break;
                                                                    case 'completed':
                                                                        $statusClass = 'badge-completed';
                                                                        break;
                                                                    case 'cancelled':
                                                                        $statusClass = 'badge-cancelled';
                                                                        break;
                                                                    default:
                                                                        $statusClass = 'bg-gray-200 text-gray-800';
                                                                }
                                                            @endphp
                                        <span
                                                                class="badge {{ $statusClass }}">{{ ucfirst($assignment->order->status) }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 space-y-3">
                                                        <div class="flex items-start">
                                                            <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-3"></i>
                                                            <div>
                                                                <p class="text-sm text-gray-600 font-medium">Tujuan:</p>
                                                                <p class="text-gray-800">{{ $assignment->order->tujuan }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-start">
                                                            <i class="fas fa-user-tag text-blue-500 mt-1 mr-3"></i>
                                                            <div>
                                                                <p class="text-sm text-gray-600 font-medium">Catatan Tambahan:</p>
                                                                <p class="text-gray-800">{{ $assignment->order->special_instructions}}</p>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-start">
                                                            <i class="fas fa-spinner text-yellow-500 mt-1 mr-3"></i>
                                                            <div>
                                                                <p class="text-sm text-gray-600 font-medium">Status Pengerjaan:</p>
                                                                 <p class="text-gray-800">{{ $assignment->order->scheduled_date}}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="mt-5 pt-5 border-t border-gray-100 flex justify-between items-center">
                                                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                                                        </a>

                                                        @php
    $isManager = auth()->user()->staff->position === 'Manager';
@endphp

@if ($isManager)
    <!-- Form Update Status hanya untuk Manager -->
    <form action="{{ route('staff.orders.updateStatus', $assignment->order) }}"
        method="POST" class="flex items-center gap-2">
        @csrf
        @method('PATCH')

        <label for="status" class="text-gray-700 text-sm font-medium">Status</label>

        <select id="status" name="status"
            class="border border-gray-200 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach(['pending' => 'Pending', 'in progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}" {{ $assignment->order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit"
            class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition">
            Update
        </button>
    </form>
@else
    <div class="text-sm text-gray-500 italic">Hanya Manager yang dapat mengubah status.</div>
@endif


                                                    </div>


                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

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