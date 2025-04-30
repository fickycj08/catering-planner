<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Staff | Catering Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23d1fae5' fill-opacity='0.4'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .form-card {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .form-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        .form-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .input-field:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }
        .submit-btn {
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(5, 150, 105, 0.4);
        }
        .field-icon {
            color: #6B7280;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md form-card bg-white">
        <!-- Header -->
        <div class="form-header p-6 text-white relative">
            <div class="flex items-center mb-3">
                <i class="fas fa-utensils text-3xl mr-3"></i>
                <h1 class="text-2xl font-bold">Catering Pro</h1>
            </div>
            <h2 class="text-xl font-medium">Registrasi Staff Baru</h2>
            <p class="mt-1 text-sm opacity-80">Lengkapi formulir untuk bergabung dengan tim kami</p>
            
            <!-- Decorative elements -->
            <div class="absolute -bottom-6 right-10 w-12 h-12 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -top-6 left-20 w-16 h-16 bg-white opacity-10 rounded-full"></div>
        </div>
        
        <!-- Form -->
        <div class="p-6">
            <form action="{{ route('staff.register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user field-icon mr-2"></i>Nama Lengkap
                    </label>
                    <input type="text" name="name" placeholder="Masukkan nama lengkap" 
                           class="input-field w-full p-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope field-icon mr-2"></i>Email
                    </label>
                    <input type="email" name="email" placeholder="email@perusahaan.com" 
                           class="input-field w-full p-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock field-icon mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="Minimal 8 karakter" 
                               class="input-field w-full p-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700" required>
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword(this)">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-check-circle field-icon mr-2"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" 
                               class="input-field w-full p-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700" required>
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword(this)">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-phone field-icon mr-2"></i>No. HP
                    </label>
                    <input type="text" name="phone" placeholder="Contoh: 081234567890" 
                           class="input-field w-full p-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-briefcase field-icon mr-2"></i>Posisi
                    </label>
                    <select name="position" class="input-field w-full p-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700" required>
                        <option value="" disabled selected>Pilih posisi</option>
                        <option value="Chef">Chef</option>
                        <option value="Assistant Chef">Assistant Chef</option>
                        <option value="Kitchen Staff">Kitchen Staff</option>
                        <option value="Server">Server</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Administration">Administration</option>
                        <option value="Manager">Manager</option>
                        <option value="Other">Lainnya</option>
                    </select>
                </div>
                
                <div class="pt-3">
                    <button type="submit" class="submit-btn w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-5 text-sm text-gray-600">
                Sudah punya akun? 
                <a href="#" class="text-green-600 hover:text-green-800 font-medium">Masuk di sini</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 text-center text-xs text-gray-500">
            &copy; 2025 Catering Pro Management System - Internal Use Only
        </div>
    </div>
    
    <script>
        function togglePassword(button) {
            const input = button.parentElement.querySelector('input');
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>