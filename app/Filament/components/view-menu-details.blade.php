<div class="p-4">
    <h3>Detail Menu</h3>
    @if($menu)
        <p>Nama: {{ $menu->name }}</p>
        <p>Harga: Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
    @else
        <p>Data menu tidak ditemukan.</p>
    @endif
</div>
