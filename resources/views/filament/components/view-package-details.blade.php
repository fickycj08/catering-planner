<div class="p-4">
    <h3>Detail Paket</h3>
    @if($package)
        <p>Nama: {{ $package->name }}</p>
        <p>Total Harga: Rp {{ number_format($package->total_price, 0, ',', '.') }}</p>
    @else
        <p>Data paket tidak ditemukan.</p>
    @endif
</div>
