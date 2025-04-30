<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
        }
        .payment-card {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
        }
        .payment-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        .stamp {
            position: absolute;
            right: 20px;
            top: 20px;
            transform: rotate(12deg);
            color: rgba(22, 163, 74, 0.2);
            font-size: 5rem;
            font-weight: 700;
            border: 0.5rem solid rgba(22, 163, 74, 0.2);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-10 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-t-xl shadow-sm p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-600 text-white p-2 rounded-lg">
                        <i class="fas fa-receipt text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Bukti Pembayaran</h1>
                </div>
                <div>
                    <a href="javascript:history.back()" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-white shadow-sm relative overflow-hidden">
            @if($record->status === 'completed')
                <div class="stamp">Lunas</div>
            @endif
            
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">ID Pesanan</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->id }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Pembayaran</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Pelanggan</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $record->customer->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Metode Pembayaran</h3>
                        <p class="text-lg font-semibold text-gray-800">
                            @if($record->payment_method === 'transfer_bank')
                                <i class="fas fa-university mr-1 text-blue-500"></i> Transfer Bank
                            @elseif($record->payment_method === 'tunai')
                                <i class="fas fa-money-bill-wave mr-1 text-green-500"></i> Tunai
                            @elseif($record->payment_method === 'qris')
                                <i class="fas fa-qrcode mr-1 text-purple-500"></i> QRIS
                            @else
                                {{ $record->payment_method }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Detail Pembayaran</h3>
                        <span class="px-3 py-1 rounded-full {{ $record->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Harga</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($record->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Uang Muka (DP)</p>
                            <p class="text-xl font-bold text-green-600">Rp {{ number_format($record->down_payment, 0, ',', '.') }}</p>
                        </div>
                        @if($record->remaining_payment > 0)
                        <div>
                            <p class="text-sm text-gray-500">Sisa Pembayaran</p>
                            <p class="text-xl font-bold text-red-500">Rp {{ number_format($record->remaining_payment, 0, ',', '.') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="payment-card bg-white rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-500 py-4 px-6">
                        <h3 class="text-white text-lg font-semibold flex items-center">
                            <i class="fas fa-file-invoice-dollar mr-2"></i> Bukti Pembayaran
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @php
                            $extension = pathinfo($record->payment_proof, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="relative group">
                                <img src="{{ $this->paymentProofUrl }}" alt="Bukti Pembayaran"
                                    class="max-w-full h-auto rounded-lg mx-auto border border-gray-200 shadow-sm">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <a href="{{ $this->paymentProofUrl }}" target="_blank" class="bg-white p-3 rounded-full shadow-lg hover:bg-green-50 transition-all">
                                        <i class="fas fa-search-plus text-green-600"></i>
                                    </a>
                                </div>
                            </div>
                        @elseif(strtolower($extension) === 'pdf')
                            <div class="flex flex-col items-center justify-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <div class="text-red-500 text-5xl mb-4">
                                    <i class="far fa-file-pdf"></i>
                                </div>
                                <p class="text-gray-600 mb-4 text-center">Bukti pembayaran dalam format PDF</p>
                                <a href="{{ $this->paymentProofUrl }}" target="_blank" 
                                   class="btn-primary inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                    <i class="fas fa-download mr-2"></i> Download PDF
                                </a>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <div class="text-blue-500 text-5xl mb-4">
                                    <i class="far fa-file-alt"></i>
                                </div>
                                <p class="text-gray-600 mb-4 text-center">
                                    Bukti pembayaran berupa file <strong>{{ strtoupper($extension) }}</strong>
                                </p>
                                <a href="{{ $this->paymentProofUrl }}" target="_blank" 
                                   class="btn-primary inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                    <i class="fas fa-download mr-2"></i> Download File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @if($record->payment_notes)
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Catatan Pembayaran:</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! $record->payment_notes !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-white rounded-b-xl shadow-sm p-6 text-center text-gray-500 text-sm border-t border-gray-200">
            <p>Dokumen ini dikeluarkan secara elektronik dan tidak memerlukan tanda tangan.</p>
            <p class="mt-1">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Add zoom functionality to images if needed
        document.addEventListener('DOMContentLoaded', function() {
            const paymentImage = document.querySelector('img[alt="Bukti Pembayaran"]');
            if (paymentImage) {
                paymentImage.addEventListener('click', function() {
                    window.open(this.src, '_blank');
                });
            }
        });
    </script>
</body>
</html>