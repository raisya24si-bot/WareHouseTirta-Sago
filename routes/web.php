<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ManajemenStokController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterGudangController;
use App\Http\Controllers\MasterKategoriController;
use App\Http\Controllers\MasterRakController;
use App\Http\Controllers\MasterRowController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\MasterSupplierController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StrukturLokasiController;
use Illuminate\Support\Facades\Route;


//auth

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'attempt'])
        ->name('login.attempt');
});

Route::middleware('auth')->post(
    '/logout',
    [LoginController::class, 'destroy']
)->name('logout');


// authentikasi route

Route::middleware('auth')->group(function () {

    // Dashboard / Home (index Master Barang dipakai sebagai halaman utama)
    Route::get(
        '/',
        [MasterBarangController::class, 'index']
    )->name('barang.index');


    // Search
    Route::prefix('search')->group(function () {

        Route::get(
            '/',
            [SearchController::class, 'index']
        )->name('search');
    });


    // Notifications
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {

        Route::get(
            '/',
            [NotificationsController::class, 'index']
        )->name('index');

        Route::get(
            '/{notifikasi}',
            [NotificationsController::class, 'open']
        )->name('open');

        Route::post(
            '/mark-all-read',
            [NotificationsController::class, 'markAllRead']
        )->name('mark-all-read');
    });


    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get(
            '/',
            [ProfileController::class, 'show']
        )->name('show');

        Route::put(
            '/',
            [ProfileController::class, 'update']
        )->name('update');
    });


    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {

        Route::get(
            '/',
            [SettingsController::class, 'show']
        )->name('show');

        Route::put(
            '/password',
            [SettingsController::class, 'updatePassword']
        )->name('update-password');

        Route::put(
            '/preferences',
            [SettingsController::class, 'updatePreferences']
        )->name('update-preferences');
    });


    // Master Barang
    Route::prefix('barang')->name('barang.')->group(function () {

        Route::post(
            '/',
            [MasterBarangController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterBarang}',
            [MasterBarangController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterBarang}',
            [MasterBarangController::class, 'destroy']
        )->name('destroy');

        Route::post(
            '/import',
            [MasterBarangController::class, 'import']
        )->name('import');

        Route::get(
            '/import/template',
            [MasterBarangController::class, 'importTemplate']
        )->name('import-template');
    });


    // Master Kategori
    Route::prefix('master-kategori')->name('master-kategori.')->group(function () {

        Route::get(
            '/',
            [MasterKategoriController::class, 'index']
        )->name('index');

        Route::post(
            '/',
            [MasterKategoriController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterKategori}',
            [MasterKategoriController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterKategori}',
            [MasterKategoriController::class, 'destroy']
        )->name('destroy');
    });


    // Master Satuan
    Route::prefix('master-satuan')->name('master-satuan.')->group(function () {

        Route::get(
            '/',
            [MasterSatuanController::class, 'index']
        )->name('index');

        Route::post(
            '/',
            [MasterSatuanController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterSatuan}',
            [MasterSatuanController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterSatuan}',
            [MasterSatuanController::class, 'destroy']
        )->name('destroy');
    });


    // Master Supplier
    Route::prefix('master-supplier')->name('master-supplier.')->group(function () {

        Route::get(
            '/',
            [MasterSupplierController::class, 'index']
        )->name('index');

        Route::post(
            '/',
            [MasterSupplierController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterSupplier}',
            [MasterSupplierController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterSupplier}',
            [MasterSupplierController::class, 'destroy']
        )->name('destroy');
    });


    // Master Gudang
    Route::prefix('master-gudang')->name('master-gudang.')->group(function () {

        Route::get(
            '/',
            [MasterGudangController::class, 'index']
        )->name('index');

        Route::post(
            '/',
            [MasterGudangController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterGudang}',
            [MasterGudangController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterGudang}',
            [MasterGudangController::class, 'destroy']
        )->name('destroy');
    });


    // Master Rak
    Route::prefix('master-rak')->name('master-rak.')->group(function () {

        Route::post(
            '/',
            [MasterRakController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterRak}',
            [MasterRakController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterRak}',
            [MasterRakController::class, 'destroy']
        )->name('destroy');
    });


    // Master Row
    Route::prefix('master-row')->name('master-row.')->group(function () {

        Route::post(
            '/',
            [MasterRowController::class, 'store']
        )->name('store');

        Route::put(
            '/{masterRow}',
            [MasterRowController::class, 'update']
        )->name('update');

        Route::delete(
            '/{masterRow}',
            [MasterRowController::class, 'destroy']
        )->name('destroy');
    });


    // Struktur Lokasi / BIN
    Route::prefix('struktur-lokasi')->name('struktur-lokasi.')->group(function () {

        Route::post(
            '/',
            [StrukturLokasiController::class, 'store']
        )->name('store');

        Route::put(
            '/{strukturLokasi}',
            [StrukturLokasiController::class, 'update']
        )->name('update');

        Route::delete(
            '/{strukturLokasi}',
            [StrukturLokasiController::class, 'destroy']
        )->name('destroy');
    });


    // Stock Opname
    Route::prefix('opname')->name('opname.')->group(function () {

        Route::get(
            '/',
            [OpnameController::class, 'index']
        )->name('index');

        Route::post(
            '/',
            [OpnameController::class, 'store']
        )->name('store');

        Route::get(
            '/{opname}',
            [OpnameController::class, 'show']
        )->name('show');

        Route::put(
            '/{opname}',
            [OpnameController::class, 'update']
        )->name('update');

        Route::any(
            '/{opname}/submit-adjustment',
            [OpnameController::class, 'submitAdjustment']
        )->name('submit-adjustment');

        Route::post(
            '/{opname}/items',
            [OpnameController::class, 'addItem']
        )->name('add-item');

        Route::put(
            '/{opname}/items/{item}',
            [OpnameController::class, 'updateItem']
        )->name('update-item');

        Route::delete(
            '/{opname}/items/{item}',
            [OpnameController::class, 'deleteItem']
        )->name('delete-item');

        Route::delete(
            '/{opname}/bins/{lokasi}',
            [OpnameController::class, 'deleteBin']
        )->name('delete-bin');

        Route::delete(
            '/{opname}',
            [OpnameController::class, 'destroy']
        )->name('destroy');
    });


    // Manajemen Stok
    Route::prefix('manajemen-stok')->name('manajemen-stok.')->group(function () {

        Route::get(
            '/',
            [ManajemenStokController::class, 'index']
        )->name('index');

        Route::get(
            '/barang/{masterBarang}',
            [ManajemenStokController::class, 'show']
        )->name('show');

        Route::get(
            '/stok/{stokLokasi}/edit',
            [ManajemenStokController::class, 'edit']
        )->name('edit');

        Route::put(
            '/stok/{stokLokasi}',
            [ManajemenStokController::class, 'update']
        )->name('update');

        Route::post(
            '/add-bin',
            [ManajemenStokController::class, 'addBin']
        )->name('add-bin');

        Route::delete(
            '/stok/{stokLokasi}',
            [ManajemenStokController::class, 'destroy']
        )->name('destroy');
    });


    // Procurement (Stock Monitoring & Procurement, draft PO, lifecycle PO)
    Route::prefix('procurement')->name('procurement.')->group(function () {

        Route::get(
            '/',
            [ProcurementController::class, 'index']
        )->name('index');


        // Draft
        Route::post(
            '/draft/items',
            [ProcurementController::class, 'addToDraft']
        )->name('draft.add-item');

        Route::put(
            '/draft/items/{masterBarang}',
            [ProcurementController::class, 'updateDraftQty']
        )->name('draft.update-item');

        Route::delete(
            '/draft/items/{masterBarang}',
            [ProcurementController::class, 'removeDraftItem']
        )->name('draft.remove-item');

        Route::post(
            '/draft/supplier',
            [ProcurementController::class, 'setDraftSupplier']
        )->name('draft.set-supplier');

        Route::post(
            '/draft/create',
            [ProcurementController::class, 'createPurchaseOrder']
        )->name('draft.create');


        // Purchase Order
        Route::get(
            '/{po}',
            [ProcurementController::class, 'show']
        )->name('show');

        Route::get(
            '/{po}/edit',
            [ProcurementController::class, 'edit']
        )->name('edit');

        Route::put(
            '/{po}',
            [ProcurementController::class, 'update']
        )->name('update');

        Route::post(
            '/{po}/items',
            [ProcurementController::class, 'addItem']
        )->name('add-item');

        Route::delete(
            '/{po}/items/{item}',
            [ProcurementController::class, 'removeItem']
        )->name('remove-item');

        Route::post(
            '/{po}/submit',
            [ProcurementController::class, 'submit']
        )->name('submit');

        Route::delete(
            '/{po}',
            [ProcurementController::class, 'destroy']
        )->name('destroy');

    });


    // Antrean Persetujuan PO Kasubag -> Kabag -> Direktur
    Route::prefix('approval')
        ->name('approval.')
        ->where(['level' => 'kasubag|kabag|direktur'])
        ->group(function () {

            Route::get(
                '/{level}',
                [ApprovalController::class, 'index']
            )->name('index');

            Route::get(
                '/{level}/{po}',
                [ApprovalController::class, 'review']
            )->name('review');

            Route::post(
                '/{level}/{po}/approve',
                [ApprovalController::class, 'approve']
            )->name('approve');

            Route::post(
                '/{level}/{po}/reject',
                [ApprovalController::class, 'reject']
            )->name('reject');

        });

        Route::get('/]penerimaan', function () {
        return view('penerimaan.index');
        })->name('penerimaan.index');

        
        Route::get('/]penerimaan/verifikasi', function () {
        return view('penerimaan.verifikasi');
        })->name('penerimaan.verifiaksi');

});
