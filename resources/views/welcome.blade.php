<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Planner - Portal Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #1e40af, #3b82f6);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, #047857, #10b981);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }
        
        .food-bg {
            background-image: url('/api/placeholder/1200/800');
            background-size: cover;
            background-position: center;
        }
        
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 -z-10"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-yellow-300 rounded-full opacity-20"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-green-300 rounded-full opacity-20"></div>
    <div class="absolute top-1/4 right-1/4 w-16 h-16 bg-blue-300 rounded-full opacity-20"></div>
    
    <div class="container mx-auto max-w-6xl">
        <div class="flex flex-col lg:flex-row gap-6 items-center">
            <!-- Left Side - Image -->
            <div class="w-full lg:w-1/2">
                <div class="relative food-bg h-64 lg:h-96 rounded-2xl overflow-hidden shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-6 text-white">
                        <h3 class="text-2xl font-bold">Manajemen Catering Profesional</h3>
                        <p class="text-gray-200">Kelola pesanan, menu, dan layanan dengan sistem terpadu kami</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Card -->
            <div class="w-full lg:w-1/2">
                <div class="card p-8 md:p-10">
                    <div class="text-center mb-8">
                        <div class="inline-block p-3 bg-blue-100 rounded-full mb-4">
                            <i class="fas fa-utensils text-4xl text-blue-600 logo-pulse"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800">Catering Planner</h1>
                        <p class="text-gray-600 mt-2">Sistem Manajemen Internal</p>
                        <div class="h-1 w-20 bg-gradient-to-r from-blue-500 to-green-500 mx-auto mt-4"></div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="bg-white border border-gray-100 rounded-xl p-5 transition-all hover:shadow-md">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="fas fa-user-shield text-blue-700"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-800">Admin</h3>
                                    <p class="text-sm text-gray-500">Akses penuh ke seluruh sistem</p>
                                </div>
                                <a href="/admin" class="btn-primary text-white px-5 py-2 rounded-lg flex items-center gap-2">
                                    Masuk <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-white border border-gray-100 rounded-xl p-5 transition-all hover:shadow-md">
                            <div class="flex items-center space-x-4">
                                <div class="bg-green-100 p-3 rounded-full">
                                    <i class="fas fa-user-tie text-green-700"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-800">Staff</h3>
                                    <p class="text-sm text-gray-500">Akses untuk operasional harian</p>
                                </div>
                                <a href="/staff/login" class="btn-secondary text-white px-5 py-2 rounded-lg flex items-center gap-2">
                                    Masuk <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center text-gray-500 text-sm">
                        <p>© 2025 Catering Planner. Semua hak dilindungi.</p>
                        <p class="mt-1">Butuh bantuan? <a href="#" class="text-blue-600 hover:underline">Hubungi Support</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Simple animation for entrance
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>