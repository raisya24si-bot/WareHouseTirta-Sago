<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Akurasi Penerimaan</title>
    <style>
        @page { margin: 28px 32px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #181c23; font-size: 11px; }
        h1 { font-size: 18px; margin: 0 0 2px 0; color: #181c23; }
        .subtitle { font-size: 11px; color: #414754; margin: 0 0 16px 0; }
        .meta { font-size: 10px; color: #414754; margin-bottom: 18px; }
        .meta span { display: inline-block; margin-right: 16px; }

        .summary-box {
            border: 1px solid #e0e2ed;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }
        .summary-title { font-size: 13px; font-weight: bold; margin: 0 0 10px 0; }

        table.summary-table { width: 100%; border-collapse: collapse; }
        table.summary-table td { padding: 4px 0; font-size: 11px; vertical-align: middle; }
        table.summary-table td.label { color: #414754; width: 60%; }
        table.summary-table td.value { text-align: right; font-weight: bold; }
        table.summary-table td.value.error { color: #ba1a1a; }

        .accuracy-pct {
            font-size: 30px;
            font-weight: bold;
            color: #0059bb;
            text-align: center;
        }
        .accuracy-label { font-size: 9px; color: #414754; text-align: center; margin-bottom: 8px; }

        .gauge-track { width: 100%; height: 10px; background-color: #e0e2ed; border-radius: 5px; margin-top: 6px; }
        .gauge-fill { height: 10px; background-color: #0059bb; border-radius: 5px; }

        table.report-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.report-table th {
            background-color: #f1f3fe;
            text-align: left;
            font-size: 9.5px;
            padding: 6px 6px;
            border-bottom: 1px solid #e0e2ed;
            color: #414754;
        }
        table.report-table td {
            font-size: 9.5px;
            padding: 5px 6px;
            border-bottom: 1px solid #e0e2ed;
        }
        table.report-table td.num, table.report-table th.num { text-align: right; }

        h2.section-title {
            font-size: 13px;
            margin: 22px 0 6px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #e0e2ed;
        }

        .footer-note { margin-top: 18px; font-size: 9px; color: #414754; }
    </style>
</head>
<body>
    <h1>Laporan Akurasi Penerimaan Barang</h1>
    <p class="subtitle">Pencapaian kesesuaian fisik vs dokumen penerimaan yang tersimpan di database.</p>

    <div class="meta">
        <span>Dicetak: {{ $generatedAt->translatedFormat('d F Y H:i') }}</span>
        @if(!empty(array_filter($filters)))
            <span>
                Filter:
                @foreach(array_filter($filters) as $key => $value)
                    {{ $key }}="{{ $value }}"@if(!$loop->last), @endif
                @endforeach
            </span>
        @endif
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="width: 32%; vertical-align: middle; border: 1px solid #e0e2ed; border-radius: 6px; padding: 14px;">
                <div class="accuracy-pct">{{ number_format($summary['accuracy_percentage'], 1) }}%</div>
                <div class="accuracy-label">Akurasi Penerimaan</div>
                <div class="gauge-track">
                    <div class="gauge-fill" style="width: {{ min(100, max(0, $summary['accuracy_percentage'])) }}%;"></div>
                </div>
            </td>
            <td style="width: 4%;"></td>
            <td style="vertical-align: middle; border: 1px solid #e0e2ed; border-radius: 6px; padding: 14px;">
                <table class="summary-table">
                    <tr>
                        <td class="label">Item Sesuai</td>
                        <td class="value">{{ number_format($summary['item_sesuai']) }} Unit</td>
                    </tr>
                    <tr>
                        <td class="label">Discrepancy / Rusak</td>
                        <td class="value error">{{ number_format($summary['item_discrepancy']) }} Unit ({{ number_format($summary['discrepancy_percentage'], 1) }}%)</td>
                    </tr>
                    <tr>
                        <td class="label">Rata-rata Waktu Verifikasi</td>
                        <td class="value">{{ number_format($summary['avg_verifikasi_minutes']) }} Menit</td>
                    </tr>
                    <tr>
                        <td class="label">Total Dokumen Penerimaan</td>
                        <td class="value">{{ number_format($rows->count()) }} Dokumen</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h2 class="section-title">Rekonsiliasi per Supplier</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>Supplier</th>
                <th class="num">Jumlah Dokumen</th>
                <th class="num">Item Sesuai</th>
                <th class="num">Item Rusak</th>
                <th class="num">Akurasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supplierBreakdown as $supplierName => $data)
                <tr>
                    <td>{{ $supplierName }}</td>
                    <td class="num">{{ number_format($data['jumlah_dokumen']) }}</td>
                    <td class="num">{{ number_format($data['qty_baik']) }}</td>
                    <td class="num">{{ number_format($data['qty_rusak']) }}</td>
                    <td class="num">{{ number_format($data['akurasi'], 1) }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #414754;">Tidak ada data untuk ditampilkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2 class="section-title">Detail Dokumen Penerimaan</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>No. Penerimaan</th>
                <th>Tanggal</th>
                <th>No. PO</th>
                <th>Supplier</th>
                <th class="num">Total Qty</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $penerimaan)
                <tr>
                    <td>{{ $penerimaan->kd_penerimaan }}</td>
                    <td>{{ $penerimaan->tgl_penerimaan_barang?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $penerimaan->po?->kd_po ?? '-' }}</td>
                    <td>{{ $penerimaan->po?->supplier?->nm_master_supplier ?? '-' }}</td>
                    <td class="num">{{ number_format($penerimaan->details->sum('qty_request')) }}</td>
                    <td>{{ $penerimaan->statusPenerimaan?->nm_status_penerimaan_barang ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #414754;">Tidak ada dokumen penerimaan yang cocok dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer-note">Laporan ini dihasilkan otomatis oleh sistem MasterData berdasarkan data penerimaan barang yang tersimpan di database.</p>
</body>
</html>