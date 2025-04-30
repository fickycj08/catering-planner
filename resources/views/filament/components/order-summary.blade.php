<div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Detail Pesanan</h3>
        <span class="px-4 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">{{ $totalItems }} Item</span>
    </div>
    
    @if($menuItems->isNotEmpty())
        <div class="mb-6">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-700">Menu Satuan</h4>
            </div>
            
            <div class="space-y-3">
                @foreach($menuItems as $item)
                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                       
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($packageItems->isNotEmpty())
        <div class="mb-6">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-gray-700">Paket Menu</h4>
            </div>
            
            <div class="space-y-3">
                @foreach($packageItems as $item)
                    <div class="flex justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($totalItems === 0)
        <div class="py-10 flex flex-col items-center justify-center text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <p class="text-gray-500 font-medium">Belum ada menu atau paket yang dipilih.</p>
            <p class="text-sm text-gray-400 mt-2">Pilih menu atau paket untuk melanjutkan pesanan Anda</p>
        </div>
    @else
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Total Menu/Paket:</span>
                <span class="font-semibold text-gray-800">{{ $totalItems }}</span>
            </div>
           
            <div class="mt-4 pt-3 border-t border-gray-200 flex justify-between items-center">
               
            </div>
        </div>
    @endif
</div>