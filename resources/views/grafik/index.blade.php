@extends('layouts.admin')

@section('title', 'Grafik Penjualan')

@section('content')
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <p class="text-sm text-gray-500">Penjualan Bulan Ini</p>
    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($penjualanBulanIni, 0, ',', '.') }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-4">Penjualan 7 Hari Terakhir</h3>
        <canvas id="chartHarian" height="200"></canvas>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <h3 class="font-semibold mb-4">Penjualan per Kategori (Bulan Ini)</h3>
        <canvas id="chartKategori" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const dataHarian = @json($data);
    const kategoriLabels = @json($penjualanPerKategori->pluck('nama_kategori'));
    const kategoriData = @json($penjualanPerKategori->pluck('total'));

    new Chart(document.getElementById('chartHarian'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: dataHarian,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: kategoriLabels,
            datasets: [{
                data: kategoriData,
                backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4']
            }]
        }
    });
</script>
@endsection
