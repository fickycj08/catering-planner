<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Planner - Portal Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-color: #FF7043;
            --secondary-color: #2E7D32;
            --accent-color: #FFAB00;
            --text-color: #263238;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f0f4f8' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }
        
        .login-btn {
            background: linear-gradient(135deg, var(--primary-color), #FF9800);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 112, 67, 0.4);
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 112, 67, 0.5);
        }
        
        .food-image {
            background-image: url('https://images.unsplash.com/photo-1555244162-803834f70033');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .food-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0) 100%);
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f8fafc;
        }
        
        .input-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 112, 67, 0.2);
            outline: none;
        }
        
        .input-group label {
            position: absolute;
            top: -10px;
            left: 12px;
            background-color: white;
            padding: 0 8px;
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }
        
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            filter: blur(20px);
            z-index: -1;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }
        
        .logo-container {
            animation: pulse 3s infinite ease-in-out;
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
    </style>
</head>
<body class="bg-pattern">
    <!-- Floating shapes for background -->
    <div class="floating-shape bg-orange-200" style="width: 300px; height: 300px; top: -100px; right: -100px; animation: float 8s infinite ease-in-out;"></div>
    <div class="floating-shape bg-green-200" style="width: 200px; height: 200px; bottom: 50px; left: -50px; animation: float 10s infinite ease-in-out 1s;"></div>
    <div class="floating-shape bg-blue-200" style="width: 150px; height: 150px; top: 40%; right: 10%; animation: float 7s infinite ease-in-out 0.5s;"></div>

    <div class="container mx-auto px-4 py-12 min-h-screen flex items-center justify-center">
        <div class="max-w-6xl w-full">
            <div class="card flex flex-col md:flex-row">
                <!-- Left side: Food image and info -->
                <div class="w-full md:w-5/12 food-image relative hidden md:block">
                    <div class="absolute inset-0 flex flex-col justify-between p-8 text-white">
                        <div class="logo-container bg-white bg-opacity-10 backdrop-blur-md p-4 inline-block rounded-xl self-start">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-utensils text-2xl text-white"></i>
                                <span class="font-bold text-xl">Catering Planner</span>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <h2 class="text-3xl font-bold leading-tight">Solusi Lengkap untuk Bisnis Catering Anda</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                        <i class="fas fa-check text-accent-color"></i>
                                    </div>
                                    <p>Kelola pesanan dengan mudah</p>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                        <i class="fas fa-check text-accent-color"></i>
                                    </div>
                                    <p>Pantau inventaris bahan</p>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                        <i class="fas fa-check text-accent-color"></i>
                                    </div>
                                    <p>Analisis performa bisnis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side: Login form -->
                <div class="w-full md:w-7/12 p-8 md:p-12">
                    <div class="max-w-md mx-auto">
                        <div class="text-center mb-10">
                            <div class="inline-flex items-center justify-center p-4 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full mb-4">
                                <i class="fas fa-utensils text-3xl text-primary-color"></i>
                            </div>
                            <h1 class="text-3xl font-bold text-text-color">Selamat Datang Kembali</h1>
                            <p class="text-gray-600 mt-2">Masuk ke dashboard manajemen catering Anda</p>
                        </div>

                        <form method="POST" action="{{ route('custom.login.submit') }}" class="space-y-6">
                            @csrf

                            @if ($errors->any())
                                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-6 flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $errors->first() }}</span>
                                </div>
                            @endif

                            <div class="input-group">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    placeholder="email@perusahaan.com"
                                >
                            </div>

                            <div class="input-group">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="Masukkan password Anda"
                                >
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="rounded text-primary-color focus:ring-primary-color">
                                    <span class="text-gray-700">Ingat saya</span>
                                </label>
                                <a href="#" class="text-primary-color hover:underline font-medium">Lupa password?</a>
                            </div>

                            <button
                                type="submit"
                                class="login-btn w-full text-white font-medium px-5 py-3 rounded-xl flex items-center justify-center gap-2"
                            >
                                <span>Masuk ke Dashboard</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>

                        <br>

                        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('staff.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Daftar sekarang
                </a>
            </p>
        </div>

                       

                        <div class="mt-8 text-center text-gray-500 text-xs">
                            <p>© 2025 Catering Planner. Semua hak dilindungi.</p>
                            <p class="mt-1">Butuh bantuan? <a href="#" class="text-primary-color hover:underline">Hubungi Support</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 200);
            
            // Focus animation for input fields
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-5px)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
