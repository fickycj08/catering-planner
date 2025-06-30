<x-filament::page>
    <div class="space-y-6">

        {{-- Bagian Statistik Utama dengan Card dan Ikon (Tetap sama) --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            {{-- Card Total Revenue --}}
            <x-filament::card>
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-primary-500/10 dark:bg-primary-500/20 rounded-xl">
                        <svg class="w-6 h-6 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.75A.75.75 0 013 4.5h.75m0 0h.75A.75.75 0 015.25 6v.75m0 0v.75a.75.75 0 01-.75.75h-.75m0 0H3.75m0 0h-.75a.75.75 0 01-.75-.75V6.75m0 0v-.75A.75.75 0 013 5.25h.75M12 18.75v-6.75a3.375 3.375 0 00-3.375-3.375H8.25m5.231 9.348a3.007 3.007 0 00-3.41-2.922H8.25a3.375 3.375 0 00-3.375 3.375v6.75m3.375-3.375h2.25a2.25 2.25 0 002.25-2.25v-1.5a2.25 2.25 0 00-2.25-2.25H8.25m9-1.5v-1.5A2.25 2.25 0 0015.75 6H12m0 0v-1.5a2.25 2.25 0 00-2.25-2.25H8.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </x-filament::card>

            {{-- Card Total Orders --}}
            <x-filament::card>
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-success-500/10 dark:bg-success-500/20 rounded-xl">
                         <svg class="w-6 h-6 text-success-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $orders }}</p>
                    </div>
                </div>
            </x-filament::card>

            {{-- Card Total Customers --}}
            <x-filament::card>
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-warning-500/10 dark:bg-warning-500/20 rounded-xl">
                        <svg class="w-6 h-6 text-warning-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zm-9 5.192A2.25 2.25 0 015.25 18h4.992a2.25 2.25 0 012.25 2.25v.01H5.25a2.25 2.25 0 01-2.25-2.25z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $customers }}</p>
                    </div>
                </div>
            </x-filament::card>
        </div>

        {{-- BARIS INI MENGGANTIKAN TABEL LAMA DENGAN GRAFIK BARU --}}
        @livewire(\App\Filament\Widgets\MonthlyRevenueChart::class)

    </div>
</x-filament::page>