<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    //dummy data 
    
    private function dummyData()
    {
        return [
            [
                'id' => 1,
                'no_penerimaan' => 'GRN-2026-0001',
                'tanggal' => '07 Sep 2026',
                'jam' => '09:15 WIB',
                'no_po' => 'PO-2026-0091',
                'invoice' => 'INV-PMN-8812',
                'supplier' => 'PT. Pipa Mas Nusantara',
                'item' => 'Pipa HDPE & Valve Distribusi',
                'sku' => 3,
                'qty' => 65,
                'satuan' => 'Unit',
                'pic' => 'Wahyu H.',
                'status' => 'Menunggu Verifikasi',
                'status_type' => 'waiting',
            ],

            [
                'id' => 2,
                'no_penerimaan' => 'GRN-2026-0002',
                'tanggal' => '07 Sep 2026',
                'jam' => '08:30 WIB',
                'no_po' => 'PO-2026-0087',
                'invoice' => 'INV-BAI-7719',
                'supplier' => 'PT. Barindo Anggun Industri',
                'item' => 'Meter Air Kuningan & Aksesoris SR',
                'sku' => 4,
                'qty' => 350,
                'satuan' => 'Unit',
                'pic' => 'Budi Santoso',
                'status' => 'Menunggu Verifikasi',
                'status_type' => 'waiting',
            ],

            [
                'id' => 3,
                'no_penerimaan' => 'GRN-2026-0003',
                'tanggal' => '06 Sep 2026',
                'jam' => '16:40 WIB',
                'no_po' => 'PO-2026-0082',
                'invoice' => 'INV-VJM-0941',
                'supplier' => 'PT. Vinilon Jaya Mandiri',
                'item' => 'Pipa uPVC Limbah & Air Bersih SNI',
                'sku' => 2,
                'qty' => 80,
                'satuan' => 'Batang',
                'pic' => 'Wahyu H.',
                'status' => 'Dalam Alokasi',
                'status_type' => 'process',
            ],

            [
                'id' => 4,
                'no_penerimaan' => 'GRN-2026-0004',
                'tanggal' => '06 Sep 2026',
                'jam' => '14:10 WIB',
                'no_po' => 'PO-2026-0075',
                'invoice' => 'INV-TKE-5520',
                'supplier' => 'CV. Tirta Kencana Engineering',
                'item' => 'Clamp Saddle, Flange & Gibault',
                'sku' => 12,
                'qty' => 450,
                'satuan' => 'Pcs',
                'pic' => 'Deni Anggara',
                'status' => 'Disetujui / Selesai',
                'status_type' => 'success',
            ],

            [
                'id' => 5,
                'no_penerimaan' => 'GRN-2026-0005',
                'tanggal' => '05 Sep 2026',
                'jam' => '11:20 WIB',
                'no_po' => 'PO-2026-0064',
                'invoice' => 'INV-ALT-3310',
                'supplier' => 'PT. Adhi Karya Logistik Tirta',
                'item' => 'Pompa Submersible & Panel Inverter',
                'sku' => 2,
                'qty' => 4,
                'satuan' => 'Unit',
                'pic' => 'Wahyu H.',
                'status' => 'Disetujui / Selesai',
                'status_type' => 'success',
            ],

            [
                'id' => 6,
                'no_penerimaan' => 'GRN-2026-0006',
                'tanggal' => '05 Sep 2026',
                'jam' => '09:05 WIB',
                'no_po' => 'PO-2026-0059',
                'invoice' => 'SJ-BPI-11',
                'supplier' => 'PT. Bakrie Pipe Industries',
                'item' => 'Pipa Baja GI & Fitting Spesial',
                'sku' => 3,
                'qty' => 24,
                'satuan' => 'Batang',
                'pic' => 'Budi Santoso',
                'status' => 'Draft',
                'status_type' => 'draft',
            ],
        ];
    }


    /**
     * Dummy detail untuk halaman verifikasi.
     */
    private function dummyDetail($id)
    {
        $items = [
            [
                'kode' => 'PDAM-0102',
                'sku' => 'SKU-PIP-HDPE',
                'nama' => 'Pipa HDPE PE-100 PN 10',
                'spesifikasi' => 'OD 63mm / 2 Inch - Roll 100m',
                'sertifikasi' => 'SNI 4829.2:2015 • Grade SDR 17',
                'qty_po' => 50,
                'qty_baik' => 50,
                'qty_rusak' => 0,
                'satuan' => 'Roll',
                'harga' => 325000,
                'status' => 'Sesuai Fisik',
                'lokasi' => 'BIN-A-12',
                'lokasi_detail' => 'Gudang Distribusi • Rak Pipa & Fitting',
                'has_location' => true,
                'has_reject' => false,
            ],

            [
                'kode' => 'PDAM-0205',
                'sku' => 'SKU-WMR-050',
                'nama' => 'Water Meter / Meteran Air Rumah Tangga 1/2 Inch',
                'spesifikasi' => 'Brass Body - Dry Dial Multi-Jet',
                'sertifikasi' => 'SNI ISO 4064, Kelas B',
                'qty_po' => 100,
                'qty_baik' => 78,
                'qty_rusak' => 2,
                'satuan' => 'Unit',
                'harga' => 215000,
                'status' => 'Selisih (-20 Unit)',
                'lokasi' => 'BIN-B-04',
                'lokasi_detail' => '78 Unit Baik',
                'has_location' => true,
                'has_reject' => true,
                'reject_location' => 'BIN-RETUR-01',
                'reject_detail' => '2 Unit Reject',
                'reject_note' => 'Kaca Dial Retak & Segel Kalibrasi Rusak',
            ],

            [
                'kode' => 'PDAM-0312',
                'sku' => 'SKU-VLV-DN80',
                'nama' => 'Gate Valve Flange Cast Iron 3 Inch (DN 80)',
                'spesifikasi' => 'Resilient Seated PN 16, Handwheel Operated',
                'sertifikasi' => 'Hydrostatic Test Passed',
                'qty_po' => 10,
                'qty_baik' => 10,
                'qty_rusak' => 0,
                'satuan' => 'Unit',
                'harga' => 1450000,
                'status' => 'Menunggu Alokasi',
                'lokasi' => null,
                'lokasi_detail' => null,
                'has_location' => false,
                'has_reject' => false,
            ],
        ];

        return [
            'id' => $id,
            'no_penerimaan' => 'GRN-2026-0001',
            'status' => 'In Verification',
            'no_po' => 'PO-2026-0091',
            'supplier' => 'PT. Pipa Mas Nusantara',
            'invoice' => 'INV-PMN-8812',
            'surat_jalan' => 'SJ-8812',
            'tanggal' => '07 Sep 2026',
            'jam' => '09:30 WIB',
            'pic' => 'Wahyu Hidayat',
            'total_baik' => 138,
            'total_rusak' => 2,
            'discrepancy' => -20,
            'total_nilai' => 47520000,
            'items' => $items,
        ];
    }


    /**
     * Halaman daftar penerimaan.
     */
    public function index()
    {
        $penerimaans = $this->dummyData();

        return view('penerimaan.index', [
            'penerimaans' => $penerimaans,
        ]);
    }


    /**
     * Halaman verifikasi penerimaan.
     */
    public function verifikasi($id)
    {
        $penerimaan = $this->dummyDetail($id);

        return view('penerimaan.verifikasi', [
            'penerimaan' => $penerimaan,
        ]);
    }


    /**
     * Simulasi simpan draft.
     */
    public function saveDraft(Request $request, $id)
    {
        return redirect()
            ->route('penerimaan.verifikasi', $id)
            ->with('success', 'Draft verifikasi penerimaan berhasil disimpan.');
    }


    /**
     * Simulasi submit final.
     */
    public function submit(Request $request, $id)
    {
        return redirect()
            ->route('penerimaan.index')
            ->with('success', 'Penerimaan berhasil diverifikasi dan disubmit.');
    }
}


