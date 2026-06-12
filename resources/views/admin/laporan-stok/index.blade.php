@extends('layouts.admin')

@section('title', 'Laporan Stok Dapur')

@section('content')
<div class="ruto-page-header ruto-fade-in">
    <p class="ruto-page-desc">Riwayat laporan stok bahan baku dari kasir</p>
</div>

<div class="ruto-card ruto-fade-in-delay-1">
    <div class="ruto-table-wrap">
        <table class="ruto-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelapor (Kasir)</th>
                    <th class="text-center">Item Menipis / Habis</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td class="font-medium" style="color:var(--ruto-text)">
                            {{ \Carbon\Carbon::parse($report->tanggal)->format('d/m/Y') }}
                        </td>
                        <td style="color:var(--ruto-text)">{{ $report->user->name }}</td>
                        <td class="text-center">
                            <span class="ruto-badge ruto-badge-danger">
                                {{ $report->details->count() }} item
                            </span>
                        </td>
                        <td style="color:var(--ruto-text-muted)" class="truncate max-w-xs">
                            {{ $report->catatan ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.laporan-stok.show', $report) }}" class="ruto-link">Detail / Cetak</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="ruto-empty">Belum ada laporan stok dapur.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
