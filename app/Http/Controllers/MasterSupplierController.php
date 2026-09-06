<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasPerPage;
use App\Models\MasterSupplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterSupplierController extends Controller
{
    use HasPerPage;

    public function index(Request $request)
    {
        $perPage = $this->perPageOption($request);

        $query = MasterSupplier::query();

        // Search berdasarkan kode, nama, atau kontak
        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());

            $query->where(function ($q) use ($search) {
                $q->where('kd_master_supplier', 'like', "%{$search}%")
                    ->orWhere('nm_master_supplier', 'like', "%{$search}%")
                    ->orWhere('kontak_supplier', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where(
                'status_master_supplier',
                $request->string('status')->toString()
            );
        }

        $suppliers = $query
            ->latest('id_master_supplier')
            ->paginate($this->resolvePerPage($request, $query))
            ->withQueryString();

        return view('master.supplier.index', compact('suppliers', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateSupplier($request);

        $validated['created_by'] = auth()->id() ?? 1;

        MasterSupplier::create($validated);

        return back()->with(
            'success',
            'Supplier berhasil ditambahkan. Kode supplier dibuat otomatis.'
        );
    }

    public function update(
        Request $request,
        MasterSupplier $masterSupplier
    ) {
        $validated = $this->validateSupplier(
            $request,
            $masterSupplier
        );

        $validated['updated_by'] = auth()->id() ?? 1;

        $masterSupplier->update($validated);

        return back()->with(
            'success',
            'Data supplier berhasil diperbarui.'
        );
    }

    public function destroy(MasterSupplier $masterSupplier)
    {
        $masterSupplier->update([
            'status_master_supplier' => 'TIDAK AKTIF',
            'deleted_by' => auth()->id() ?? 1,
        ]);

        $masterSupplier->delete();

        return back()->with(
            'success',
            'Supplier berhasil dinonaktifkan.'
        );
    }

    private function validateSupplier(
        Request $request,
        ?MasterSupplier $supplier = null
    ): array {
        return $request->validate([
            'nm_master_supplier' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'tbl_master_supplier',
                    'nm_master_supplier'
                )->ignore(
                    $supplier?->id_master_supplier,
                    'id_master_supplier'
                ),
            ],

            'alamat_supplier' => [
                'required',
                'string',
                'max:500',
            ],

            /*
             * Nomor telepon:
             * - wajib diisi
             * - hanya angka
             * - minimal 10 digit
             * - maksimal 13 digit
             */
            'kontak_supplier' => [
                'required',
                'digits_between:10,13',
            ],

            'status_master_supplier' => [
                'required',
                Rule::in([
                    'AKTIF',
                    'TIDAK AKTIF',
                ]),
            ],
        ], [
            'nm_master_supplier.required'
                => 'Nama supplier wajib diisi.',

            'nm_master_supplier.unique'
                => 'Nama supplier sudah terdaftar.',

            'alamat_supplier.required'
                => 'Alamat supplier wajib diisi.',

            'alamat_supplier.max'
                => 'Alamat supplier maksimal 500 karakter.',

            'kontak_supplier.required'
                => 'Nomor telepon supplier wajib diisi.',

            'kontak_supplier.digits_between'
                => 'Nomor telepon harus terdiri dari 10 sampai 13 digit angka.',

            'status_master_supplier.required'
                => 'Status supplier wajib dipilih.',

            'status_master_supplier.in'
                => 'Status supplier tidak valid.',
        ]);
    }
}