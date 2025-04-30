@php
    // Mengambil data dari record yang dikirim
    $order = $record;
    $customer = $order->customer;
    $items = $order->items;
    $packages = $order->packages;

    // Format tanggal dan nomor order
    $orderDate = $order->created_at->format('d M Y');
    $orderNumber = str_pad($order->id, 5, '0', STR_PAD_LEFT);
    $dueDate = $order->scheduled_date->format('d M Y');
@endphp

<div>
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #818cf8;
            --accent-color: #c084fc;
            --dark-color: #1f2937;
            --light-color: #f9fafb;
            --danger-color: #ef4444;
            --success-color: #10b981;
            --warning-color: #f59e0b;

            /* Warna default (light mode) */
            --bg-color: #f5f5f5;
            --text-color: #333;
            --container-bg: white;
            --border-color: #e5e7eb;
        }

        /* Gaya dark mode bila class "dark" aktif di <body> */
        .dark {
            --bg-color: #121212;
            --text-color: #e0e0e0;
            --container-bg: #1e1e1e;
            --border-color: #333;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s, color 0.3s;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: var(--container-bg);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: relative;
            transition: background 0.3s;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .company-info {
            max-width: 60%;
        }

        .company-info h1 {
            color: var(--primary-color);
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .company-info p {
            color: #6b7280;
            margin: 5px 0;
            font-size: 14px;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details h2 {
            font-size: 28px;
            color: var(--primary-color);
            margin: 0;
            text-transform: uppercase;
            font-weight: 800;
        }

        .invoice-details .invoice-number {
            font-size: 18px;
            color: var(--dark-color);
            margin: 5px 0;
        }

        .invoice-details .dates {
            margin-top: 15px;
            font-size: 14px;
            color: #6b7280;
        }

        .invoice-details .dates span {
            font-weight: 600;
            color: var(--dark-color);
        }

        .client-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .client-details,
        .shipping-details {
            flex: 1;
        }

        .section-title {
            font-size: 16px;
            text-transform: uppercase;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .client-name {
            font-size: 18px;
            font-weight: 600;
            margin: 5px 0;
        }

        .client-address {
            font-size: 14px;
            color: #6b7280;
            margin: 5px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: var(--primary-color);
            color: white;
            text-align: left;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: 600;
        }

        .items-table th:first-child {
            border-top-left-radius: 8px;
        }

        .items-table th:last-child {
            border-top-right-radius: 8px;
            text-align: right;
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .items-table td:last-child {
            text-align: right;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table .item-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        .items-table .item-description {
            color: #6b7280;
            font-size: 13px;
        }

        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .summary-table {
            width: 50%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 15px;
            font-size: 14px;
        }

        .summary-table td:first-child {
            text-align: left;
        }

        .summary-table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .summary-table .total-row td {
            font-size: 18px;
            color: var(--primary-color);
            font-weight: 700;
            border-top: 2px solid var(--border-color);
            padding-top: 15px;
        }

        .payment-info {
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .dark .payment-info {
            background-color: #2a2a2a;
        }

        .payment-info .section-title {
            margin-top: 0;
        }

        .payment-method {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .payment-method .icon {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .notes-section {
            margin-bottom: 30px;
        }

        .footer {
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }

        .footer p {
            margin: 5px 0;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: var(--secondary-color);
        }

        .print-section {
            text-align: center;
            margin-top: 20px;
        }

        .print-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--dark-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #2d3748;
        }

        /* Tombol toggle dark mode */
        .toggle-dark {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 8px 12px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
       
        @media print {
    /* Sembunyikan semua elemen terlebih dahulu */
    body * {
        visibility: hidden;
    }
    
    /* Tampilkan hanya konten invoice-container */
    .invoice-container, .invoice-container * {
        visibility: visible;
    }
    
    /* Posisikan invoice di pojok kiri atas halaman */
    .invoice-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 20px;
        box-shadow: none !important;
        background-color: white !important;
        color: #333 !important;
    }
    
    /* Sembunyikan tombol-tombol yang tidak perlu */
    .toggle-dark, .print-button, .back-button, .print-section {
        display: none !important;
    }
    
    /* Pastikan semua warna teks terlihat jelas */
    .company-info p, .client-address, .item-description {
        color: #333 !important;
    }
    
    /* Pastikan tabel dan header terlihat jelas */
    .items-table th {
        background-color: #4f46e5 !important;
        color: white !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    
    /* Atur margin halaman cetak */
    @page {
        size: A4;
        margin: 0.5cm;
    }
}

    </style>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>PT. SINAN DAIVA INDONESIA</h1>
                <p>Jl. Sapta Marga No. 51, Cibinong, Bogor</p>
                <p>Telp: (021) 12345678 | Email: info@sinandaiva.com</p>
                <p>NPWP: 01.234.567.8-123.000</p>
            </div>
            <div class="invoice-details">
                <h2>Invoice</h2>
                <p class="invoice-number">No. INV-{{ $orderNumber }}</p>
                <div class="dates">
                    <p>Tanggal Invoice: <span>{{ $orderDate }}</span></p>
                    <p>Tanggal Acara: <span>{{ $dueDate }}</span></p>
                    <p>Status:
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Client Info -->
        <div class="client-info">
            <div class="client-details">
                <p class="section-title">Informasi Pelanggan</p>
                <p class="client-name">{{ $customer->name }}</p>
                <p class="client-address">{{ $customer->phone }}</p>
                <p class="client-address">{{ $customer->email ?? '-' }}</p>
                <p class="client-address">{{ $customer->address }}</p>
            </div>
            <div class="shipping-details">
                <p class="section-title">Informasi Acara</p>
                <p class="client-name">
                    {{ $order->event_type == 'Lainnya' ? $order->custom_event_type : $order->event_type }}
                </p>
                <p class="client-address">{{ $order->tujuan }}</p>
            </div>
        </div>

        <!-- Items -->
        <p class="section-title">Detail Pesanan</p>

        @if($items->count() > 0)
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="item-name">{{ $item->menu->name }}</div>
                                <div class="item-description">{{ $item->special_request ?? '-' }}</div>
                            </td>
                            <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if($packages->count() > 0)
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td>
                                <div class="item-name">{{ $package->package->name }}</div>
                                <div class="item-description">{{ $package->package->description ?? '-' }}</div>
                            </td>
                            <td>Rp {{ number_format($package->package->total_price, 0, ',', '.') }}</td>
                            <td>{{ $package->quantity }}</td>
                            <td>Rp {{ number_format($package->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Summary -->
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td>Subtotal</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>DP</td>
                    <td>Rp {{ number_format($order->down_payment, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Sisa Pembayaran</td>
                    <td>Rp {{ number_format($order->remaining_payment, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <p class="section-title">Informasi Pembayaran</p>
            <div class="payment-method">
                <div class="icon">🏦</div>
                <div>
                    <strong>Metode Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                </div>
            </div>
            <div class="payment-method">
                <div class="icon">💳</div>
                <div>
                    <strong>Rekening Perusahaan:</strong> Bank Mandiri 123-45678-9012 a/n PT. Sinan Daiva Indonesia
                </div>
            </div>
            @if($order->payment_notes)
                <div class="payment-method">
                    <div class="icon">📝</div>
                    <div>
                        <strong>Catatan Pembayaran:</strong> {!! $order->payment_notes !!}
                    </div>
                </div>
            @endif
        </div>

        @if($order->special_instructions)
            <!-- Notes -->
            <div class="notes-section">
                <p class="section-title">Instruksi Khusus</p>
                <p>{{ $order->special_instructions }}</p>
            </div>
        @endif

        <!-- Staff Info -->
        @if($order->staff->count() > 0)
            <div class="notes-section">
                <p class="section-title">Pesanan Disiapkan Oleh</p>
                <p>
                    @foreach($order->staff as $staff)
                        {{ $staff->name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kepercayaan Anda menggunakan jasa kami.</p>
            <p>Untuk pertanyaan lebih lanjut, hubungi kami di (021) 12345678 atau email ke info@sinandaiva.com</p>
            <p>&copy; {{ date('Y') }} PT. Sinan Daiva Indonesia. All rights reserved.</p>
        </div>

        <!-- Print Button -->
        <div class="print-section">
            <button class="print-button" onclick="window.print()">Cetak Invoice</button>
            <a href="{{ url()->previous() }}" class="back-button">Kembali</a>
        </div>
    </div>

    <script>
        // Fungsi untuk toggle manual dark mode
        function toggleDarkMode() {
            // Tambahkan atau hapus class 'dark' pada <body>
            document.body.classList.toggle('dark');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Mengganti teks status badge sesuai status order
            const statusBadge = document.querySelector('.status-badge');
            const status = statusBadge.classList[1].split('-')[1];

            switch (status) {
                case 'pending':
                    statusBadge.textContent = 'Menunggu';
                    break;
                case 'processing':
                    statusBadge.textContent = 'Diproses';
                    break;
                case 'completed':
                    statusBadge.textContent = 'Selesai';
                    break;
                case 'cancelled':
                    statusBadge.textContent = 'Dibatalkan';
                    break;
            }
        });
    </script>
</div>
