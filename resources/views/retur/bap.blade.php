<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BAP Retur {{ $retur->kd_retur }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #181c23; font-size: 11px; }
        h1 { font-size: 16px; margin: 0 0 2px 0; }
        .subtitle { font-size: 11px; color: #414754; margin: 0 0 16px 0; }

        table.meta-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.meta-table td { padding: 3px 0; font-size: 11px; vertical-align: top; }
        table.meta-table td.label { color: #414754; width: 140px; }

        table.item-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.item-table th {
            background-color: #f2f3f8; text-align: left; padding: 6px 8px;
            font-size: 10px; text-transform: uppercase; border-bottom: 1px solid #e0e2ed;
        }
        table.item-table td { padding: 6px 8px; font-size: 11px; border-bottom: 1px solid #eceef4; vertical-align: top; }
        table.item-table td.right { text-align: right; }

        .total-row td { font-weight: bold; border-top: 2px solid #181c23; }

        .sign-box { width: 100%; margin-top: 40px; }
        .sign-col { width: 45%; display: inline-block; text-align: center; vertical-align: top; }
        .sign-line { margin-top: 50px; border-top: 1px solid #181c23; padding-top: 4px; }
    </style>
</head>
<body>

    <h1>Berita Acara Pemeriksaan (BAP) Retur Barang</h1>
    <p class="subtitle">Nomor Dokumen: {{ $retur->kd_retur }}</p>

    <table class="meta-table">
        <tr>
            <td class="label">Tanggal Retur</td>
            <td>: {{ $retur->tgl_retur?->translatedFormat('d F Y') }}</td>
            <td class="label">Status</td>
            <td>: {{ $retur->statusRetur?->nm_status_retur }}</td>
        </tr>
        <tr>
            <td class="label">No. GRN Sumber</td>
            <td>: {{ $retur->penerimaanBarang?->kd_penerimaan }}</td>
            <td class="label">No. PO</td>
            <td>: {{ $retur->penerimaanBarang?->po?->kd_po }}</td>
        </tr>
        <tr>
            <td class="label">Supplier</td>
            <td colspan="3">: {{ $retur->supplier?->nm_master_supplier ?? '-' }}</td>
        </tr>
        @if($retur->catatan_retur)
        <tr>
            <td class="label">Catatan</td>
            <td colspan="3">: {{ $retur->catatan_retur }}</td>
        </tr>
        @endif
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Alasan Kerusakan</th>
                <th class="right">Qty Reject QC</th>
                <th class="right">Qty Diretur</th>
                <th class="right">Harga Satuan</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($retur->details as $detail)
                <tr>
                    <td>
                        {{ $detail->barang?->nm_master_barang }}
                        @if($detail->catatan_detail)
                            <br><span style="color:#727685;">{{ $detail->catatan_detail }}</span>
                        @endif
                    </td>
                    <td>{{ $detail->alasan->pluck('nm_alasan_retur')->join(', ') }}</td>
                    <td class="right">{{ $detail->qty_reject_qc }} {{ $detail->barang?->satuan?->nm_satuan ?? '' }}</td>
                    <td class="right">{{ $detail->qty_diretur }} {{ $detail->barang?->satuan?->nm_satuan ?? '' }}</td>
                    <td class="right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($detail->subtotal_retur, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" class="right">Total Nilai Retur</td>
                <td class="right">Rp {{ number_format($retur->nilai_total_retur, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="sign-box">
        <div class="sign-col">
            Diajukan oleh,
            <div class="sign-line">{{ $retur->submittedBy?->name ?? '-' }}</div>
        </div>
        <div class="sign-col">
            Disetujui oleh (Supplier),
            <div class="sign-line">&nbsp;</div>
        </div>
    </div>

</body>
</html>