@extends('layouts.admin')

@section('title', 'Grafik Analisis Penjualan')

@section('content')
<div class="ruto-page-header ruto-fade-in mb-6">
    <div>
        <p class="ruto-page-desc">Visualisasi performa penjualan, volume transaksi harian, kategori produk terpopuler, serta rasio metode pemesanan pelanggan.</p>
    </div>
</div>

<form method="GET" class="ruto-card ruto-card-padded mb-6 flex flex-wrap gap-4 items-end ruto-fade-in">
    <div class="ruto-field mb-0">
        <label>Dari Tanggal</label>
        <input type="date" name="dari" value="{{ $dari }}" class="ruto-input" style="max-width: 180px;">
    </div>
    <div class="ruto-field mb-0">
        <label>Sampai Tanggal</label>
        <input type="date" name="sampai" value="{{ $sampai }}" class="ruto-input" style="max-width: 180px;">
    </div>
    <button type="submit" class="ruto-btn-primary">
        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        Filter Periode
    </button>
</form>

<div class="ruto-stat-grid ruto-fade-in mb-6">
    <div class="ruto-stat-card">
        <svg class="ruto-stat-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="ruto-stat-label">Total Pendapatan</p>
        <p class="ruto-stat-value highlight">Rp {{ number_format($penjualanPeriodeIni, 0, ',', '.') }}</p>
    </div>
    <div class="ruto-stat-card">
        <svg class="ruto-stat-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        <p class="ruto-stat-label">Jumlah Transaksi</p>
        <p class="ruto-stat-value">{{ $totalTransaksi }}</p>
    </div>
    <div class="ruto-stat-card">
        <svg class="ruto-stat-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        <p class="ruto-stat-label">Rata-rata per Transaksi</p>
        <p class="ruto-stat-value">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</p>
    </div>
    <div class="ruto-stat-card">
        <svg class="ruto-stat-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="ruto-stat-label">Total Item Terjual</p>
        <p class="ruto-stat-value">{{ $totalProdukTerjual }} unit</p>
    </div>
</div>

<div class="ruto-grid-2 mb-6">
    <div class="ruto-card ruto-card-padded ruto-fade-in-delay-1">
        <h3 class="ruto-card-title">Grafik Perkembangan Penjualan</h3>
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="chartHarian"></canvas>
        </div>
    </div>
    <div class="ruto-card ruto-card-padded ruto-fade-in-delay-2">
        <h3 class="ruto-card-title">Tren Volume Transaksi</h3>
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="chartTransaksi"></canvas>
        </div>
    </div>
</div>

<div class="ruto-grid-2 mb-6">
    <div class="ruto-card ruto-card-padded ruto-fade-in-delay-3">
        <h3 class="ruto-card-title">Top 5 Produk Terlaris (Qty)</h3>
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="chartProdukTerlaris"></canvas>
        </div>
    </div>
    <div class="ruto-card ruto-card-padded ruto-fade-in-delay-4">
        <h3 class="ruto-card-title">Penjualan per Kategori</h3>
        <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="chartKategori"></canvas>
        </div>
    </div>
</div>

<div class="ruto-grid-2 mb-6">
    <div class="ruto-card ruto-card-padded ruto-fade-in-delay-5">
        <h3 class="ruto-card-title">Rasio Metode Pemesanan</h3>
        <div style="position: relative; height: 220px; width: 100%;">
            <canvas id="chartSumber"></canvas>
        </div>
    </div>
    <div class="ruto-card ruto-card-padded ruto-fade-in-delay-6">
        <h3 class="ruto-card-title">Rangkuman Kinerja Penjualan</h3>
        <div class="ruto-table-wrap">
            <table class="ruto-table">
                <thead>
                    <tr>
                        <th>Parameter Analisis</th>
                        <th class="text-right">Nilai Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Penjualan Kotor</td>
                        <td class="text-right font-medium">Rp {{ number_format($penjualanPeriodeIni, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Volume Transaksi Masuk</td>
                        <td class="text-right font-medium">{{ $totalTransaksi }} pesanan</td>
                    </tr>
                    <tr>
                        <td>Rata-rata Nilai Keranjang (AOV)</td>
                        <td class="text-right font-medium">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Produk Sukses Disajikan</td>
                        <td class="text-right font-medium">{{ $totalProdukTerjual }} unit</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Theme Configuration Helpers
    const getChartColors = () => {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        return {
            gridColor: isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(230, 162, 39, 0.08)',
            textColor: isDark ? '#a89f92' : '#6b6560',
        };
    };

    // 2. Formatting Helper
    const rupiahFormatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    // 3. Styles
    const rutoBrand = '#e6a227';
    const rutoBrandDark = '#c4881a';
    const rutoPalette = ['#e6a227', '#c4881a', '#f5d998', '#5c3d2e', '#8b7355', '#d4a84b', '#a87c37', '#eec980'];

    // --- CHART 1: LINE CHART (Penjualan Harian) ---
    const ctxHarian = document.getElementById('chartHarian').getContext('2d');
    let gradHarian = ctxHarian.createLinearGradient(0, 0, 0, 250);
    gradHarian.addColorStop(0, 'rgba(230, 162, 39, 0.35)');
    gradHarian.addColorStop(1, 'rgba(230, 162, 39, 0.02)');

    const chartHarian = new Chart(ctxHarian, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: @json($dataPenjualan),
                borderColor: rutoBrand,
                backgroundColor: gradHarian,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: rutoBrandDark,
                pointBorderColor: '#fff',
                pointBorderWidth: 1.5,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 800, easing: 'easeOutQuart' },
            plugins: {
                legend: {
                    labels: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            label += rupiahFormatter.format(context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: getChartColors().gridColor },
                    ticks: { color: getChartColors().textColor, font: { family: 'Outfit' } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: getChartColors().gridColor },
                    ticks: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit' },
                        callback: function(value) {
                            return rupiahFormatter.format(value);
                        }
                    }
                }
            }
        }
    });

    // --- CHART 2: BAR CHART (Jumlah Transaksi Harian) ---
    const ctxTransaksi = document.getElementById('chartTransaksi').getContext('2d');
    const chartTransaksi = new Chart(ctxTransaksi, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: @json($dataTransaksi),
                backgroundColor: 'rgba(92, 61, 46, 0.75)',
                borderColor: '#5c3d2e',
                borderWidth: 1.5,
                borderRadius: 5,
                maxBarThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 800, easing: 'easeOutQuart' },
            plugins: {
                legend: {
                    labels: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit' }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: getChartColors().gridColor },
                    ticks: { color: getChartColors().textColor, font: { family: 'Outfit' } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: getChartColors().gridColor },
                    ticks: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit' },
                        stepSize: 1
                    }
                }
            }
        }
    });

    // --- CHART 3: HORIZONTAL BAR CHART (Top 5 Produk) ---
    const ctxProduk = document.getElementById('chartProdukTerlaris').getContext('2d');
    const chartProdukTerlaris = new Chart(ctxProduk, {
        type: 'bar',
        data: {
            labels: @json($produkTerlaris->pluck('nama_produk')),
            datasets: [{
                label: 'Kuantitas Terjual',
                data: @json($produkTerlaris->pluck('total_qty')),
                backgroundColor: 'rgba(196, 136, 26, 0.75)',
                borderColor: rutoBrandDark,
                borderWidth: 1.5,
                borderRadius: 5,
                maxBarThickness: 24
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 900 },
            plugins: {
                legend: {
                    labels: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit' }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: getChartColors().gridColor },
                    ticks: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit' },
                        stepSize: 1
                    }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: getChartColors().textColor, font: { family: 'Outfit' } }
                }
            }
        }
    });

    // --- CHART 4: DOUGHNUT CHART (Penjualan Kategori) ---
    const ctxKategori = document.getElementById('chartKategori').getContext('2d');
    const chartKategori = new Chart(ctxKategori, {
        type: 'doughnut',
        data: {
            labels: @json($penjualanPerKategori->pluck('nama_kategori')),
            datasets: [{
                data: @json($penjualanPerKategori->pluck('total')),
                backgroundColor: rutoPalette,
                borderWidth: 2,
                borderColor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1f1c17' : '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { animateRotate: true, duration: 900 },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit', size: 11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return ` ${label}: ${rupiahFormatter.format(value)}`;
                        }
                    }
                }
            }
        }
    });

    // --- CHART 5: DOUGHNUT CHART (Sumber Pemesanan) ---
    const ctxSumber = document.getElementById('chartSumber').getContext('2d');
    const sumberLabelsRaw = @json($sumberPesanan->pluck('sumber'));
    const sumberLabels = sumberLabelsRaw.map(s => {
        if (s === 'pesanan_user') return 'Pemesanan Mandiri (QR)';
        if (s === 'langsung') return 'Kasir (Langsung)';
        return s.charAt(0).toUpperCase() + s.slice(1);
    });

    const chartSumber = new Chart(ctxSumber, {
        type: 'doughnut',
        data: {
            labels: sumberLabels,
            datasets: [{
                data: @json($sumberPesanan->pluck('total')),
                backgroundColor: ['#e6a227', '#5c3d2e', '#8b7355'],
                borderWidth: 2,
                borderColor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1f1c17' : '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { animateRotate: true, duration: 800 },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: getChartColors().textColor,
                        font: { family: 'Outfit', size: 11 }
                    }
                }
            }
        }
    });

    // 4. Live theme-toggle updater
    const themeToggleBtn = document.getElementById('ruto-theme-toggle');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            setTimeout(() => {
                const colors = getChartColors();
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const currentBorderColor = isDark ? '#1f1c17' : '#fff';

                [chartHarian, chartTransaksi, chartProdukTerlaris, chartKategori, chartSumber].forEach(chart => {
                    if (!chart) return;
                    
                    if (chart.options.scales) {
                        if (chart.options.scales.x) {
                            if (chart.options.scales.x.grid) chart.options.scales.x.grid.color = colors.gridColor;
                            chart.options.scales.x.ticks.color = colors.textColor;
                        }
                        if (chart.options.scales.y) {
                            if (chart.options.scales.y.grid) chart.options.scales.y.grid.color = colors.gridColor;
                            chart.options.scales.y.ticks.color = colors.textColor;
                        }
                    }

                    if (chart.options.plugins && chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                        chart.options.plugins.legend.labels.color = colors.textColor;
                    }

                    if (chart.config.type === 'doughnut') {
                        chart.data.datasets.forEach(dataset => {
                            dataset.borderColor = currentBorderColor;
                        });
                    }

                    chart.update();
                });
            }, 100);
        });
    }
</script>
@endpush
