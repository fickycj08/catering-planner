<x-filament::page>
    <div class="space-y-4">
        <h1 class="text-2xl font-bold">Analytics</h1>

        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <p class="text-gray-500">Total Revenue</p>
                <p class="text-lg font-semibold">{{ number_format($revenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <p class="text-gray-500">Total Orders</p>
                <p class="text-lg font-semibold">{{ $orders }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
                <p class="text-gray-500">Total Customers</p>
                <p class="text-lg font-semibold">{{ $customers }}</p>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Month</th>
                    <th class="px-4 py-2 text-left">Revenue</th>
                    <th class="px-4 py-2 text-left">Orders</th>
                    <th class="px-4 py-2 text-left">New Customers</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                @foreach($monthlyData as $row)
                    <tr>
                        <td class="px-4 py-2">{{ $row['month'] }}</td>
                        <td class="px-4 py-2">{{ number_format($row['revenue'], 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $row['orders'] }}</td>
                        <td class="px-4 py-2">{{ $row['customers'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::page>
