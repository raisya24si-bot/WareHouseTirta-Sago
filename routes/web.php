<?php

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


/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Search
    Route::get(
        '/search',
        [SearchController::class, 'index']
    )->name('search');


    // Notifications
    Route::get(
        '/notifikasi',
        [NotificationsController::class, 'index']
    )->name('notifikasi.index');

    Route::get(
        '/notifikasi/{notifikasi}',
        [NotificationsController::class, 'open']
    )->name('notifikasi.open');

    Route::post(
        '/notifikasi/mark-all-read',
        [NotificationsController::class, 'markAllRead']
    )->name('notifikasi.mark-all-read');


    // Profile
    Route::get(
        '/profile',
        [ProfileController::class, 'show']
    )->name('profile.show');

    Route::put(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    // Settings
    Route::get(
        '/settings',
        [SettingsController::class, 'show']
    )->name('settings.show');

    Route::put(
        '/settings/password',
        [SettingsController::class, 'updatePassword']
    )->name('settings.update-password');

    Route::put(
        '/settings/preferences',
        [SettingsController::class, 'updatePreferences']
    )->name('settings.update-preferences');


    // Master Barang
    Route::get(
        '/',
        [MasterBarangController::class, 'index']
    )->name('barang.index');

    Route::post(
        '/barang',
        [MasterBarangController::class, 'store']
    )->name('barang.store');

    Route::put(
        '/barang/{masterBarang}',
        [MasterBarangController::class, 'update']
    )->name('barang.update');

    Route::delete(
        '/barang/{masterBarang}',
        [MasterBarangController::class, 'destroy']
    )->name('barang.destroy');

    Route::post(
        '/barang/import',
        [MasterBarangController::class, 'import']
    )->name('barang.import');

    Route::get(
        '/barang/import/template',
        [MasterBarangController::class, 'importTemplate']
    )->name('barang.import-template');


    // Master Kategori
    Route::get(
        '/master-kategori',
        [MasterKategoriController::class, 'index']
    )->name('master-kategori.index');

    Route::post(
        '/master-kategori',
        [MasterKategoriController::class, 'store']
    )->name('master-kategori.store');

    Route::put(
        '/master-kategori/{masterKategori}',
        [MasterKategoriController::class, 'update']
    )->name('master-kategori.update');

    Route::delete(
        '/master-kategori/{masterKategori}',
        [MasterKategoriController::class, 'destroy']
    )->name('master-kategori.destroy');


    // Master Satuan
    Route::get(
        '/master-satuan',
        [MasterSatuanController::class, 'index']
    )->name('master-satuan.index');

    Route::post(
        '/master-satuan',
        [MasterSatuanController::class, 'store']
    )->name('master-satuan.store');

    Route::put(
        '/master-satuan/{masterSatuan}',
        [MasterSatuanController::class, 'update']
    )->name('master-satuan.update');

    Route::delete(
        '/master-satuan/{masterSatuan}',
        [MasterSatuanController::class, 'destroy']
    )->name('master-satuan.destroy');


    // Master Supplier
    Route::get(
        '/master-supplier',
        [MasterSupplierController::class, 'index']
    )->name('master-supplier.index');

    Route::post(
        '/master-supplier',
        [MasterSupplierController::class, 'store']
    )->name('master-supplier.store');

    Route::put(
        '/master-supplier/{masterSupplier}',
        [MasterSupplierController::class, 'update']
    )->name('master-supplier.update');

    Route::delete(
        '/master-supplier/{masterSupplier}',
        [MasterSupplierController::class, 'destroy']
    )->name('master-supplier.destroy');


    // Master Gudang
    Route::get(
        '/master-gudang',
        [MasterGudangController::class, 'index']
    )->name('master-gudang.index');

    Route::post(
        '/master-gudang',
        [MasterGudangController::class, 'store']
    )->name('master-gudang.store');

    Route::put(
        '/master-gudang/{masterGudang}',
        [MasterGudangController::class, 'update']
    )->name('master-gudang.update');

    Route::delete(
        '/master-gudang/{masterGudang}',
        [MasterGudangController::class, 'destroy']
    )->name('master-gudang.destroy');


    // Master Rak
    Route::post(
        '/master-rak',
        [MasterRakController::class, 'store']
    )->name('master-rak.store');

    Route::put(
        '/master-rak/{masterRak}',
        [MasterRakController::class, 'update']
    )->name('master-rak.update');

    Route::delete(
        '/master-rak/{masterRak}',
        [MasterRakController::class, 'destroy']
    )->name('master-rak.destroy');


    // Master Row
    Route::post(
        '/master-row',
        [MasterRowController::class, 'store']
    )->name('master-row.store');

    Route::put(
        '/master-row/{masterRow}',
        [MasterRowController::class, 'update']
    )->name('master-row.update');

    Route::delete(
        '/master-row/{masterRow}',
        [MasterRowController::class, 'destroy']
    )->name('master-row.destroy');


    // Struktur Lokasi / BIN
    Route::post(
        '/struktur-lokasi',
        [StrukturLokasiController::class, 'store']
    )->name('struktur-lokasi.store');

    Route::put(
        '/struktur-lokasi/{strukturLokasi}',
        [StrukturLokasiController::class, 'update']
    )->name('struktur-lokasi.update');

    Route::delete(
        '/struktur-lokasi/{strukturLokasi}',
        [StrukturLokasiController::class, 'destroy']
    )->name('struktur-lokasi.destroy');


    // Stock Opname
    Route::get(
        '/opname',
        [OpnameController::class, 'index']
    )->name('opname.index');

    Route::post(
        '/opname',
        [OpnameController::class, 'store']
    )->name('opname.store');

    Route::get(
        '/opname/{opname}',
        [OpnameController::class, 'show']
    )->name('opname.show');

    Route::put(
        '/opname/{opname}',
        [OpnameController::class, 'update']
    )->name('opname.update');

    Route::any(
        '/opname/{opname}/submit-adjustment',
        [OpnameController::class, 'submitAdjustment']
    )->name('opname.submit-adjustment');

    Route::post(
        '/opname/{opname}/items',
        [OpnameController::class, 'addItem']
    )->name('opname.add-item');

    Route::put(
        '/opname/{opname}/items/{item}',
        [OpnameController::class, 'updateItem']
    )->name('opname.update-item');

    Route::delete(
        '/opname/{opname}/items/{item}',
        [OpnameController::class, 'deleteItem']
    )->name('opname.delete-item');

    Route::delete(
        '/opname/{opname}/bins/{lokasi}',
        [OpnameController::class, 'deleteBin']
    )->name('opname.delete-bin');

    Route::delete(
        '/opname/{opname}',
        [OpnameController::class, 'destroy']
    )->name('opname.destroy');


    // Manajemen Stok
    Route::get(
        '/manajemen-stok',
        [ManajemenStokController::class, 'index']
    )->name('manajemen-stok.index');

    Route::get(
        '/manajemen-stok/barang/{masterBarang}',
        [ManajemenStokController::class, 'show']
    )->name('manajemen-stok.show');

    Route::get(
        '/manajemen-stok/stok/{stokLokasi}/edit',
        [ManajemenStokController::class, 'edit']
    )->name('manajemen-stok.edit');

    Route::put(
        '/manajemen-stok/stok/{stokLokasi}',
        [ManajemenStokController::class, 'update']
    )->name('manajemen-stok.update');

    Route::post(
        '/manajemen-stok/add-bin',
        [ManajemenStokController::class, 'addBin']
    )->name('manajemen-stok.add-bin');

    Route::delete(
        '/manajemen-stok/stok/{stokLokasi}',
        [ManajemenStokController::class, 'destroy']
    )->name('manajemen-stok.destroy');


    // Procurement
    Route::get(
        '/procurement',
        [ProcurementController::class, 'index']
    )->name('procurement.index');


    // Procurement Draft
    Route::post(
        '/procurement/draft/items',
        [ProcurementController::class, 'addToDraft']
    )->name('procurement.draft.add-item');

    Route::put(
        '/procurement/draft/items/{masterBarang}',
        [ProcurementController::class, 'updateDraftQty']
    )->name('procurement.draft.update-item');

    Route::delete(
        '/procurement/draft/items/{masterBarang}',
        [ProcurementController::class, 'removeDraftItem']
    )->name('procurement.draft.remove-item');

    Route::post(
        '/procurement/draft/supplier',
        [ProcurementController::class, 'setDraftSupplier']
    )->name('procurement.draft.set-supplier');

    Route::post(
        '/procurement/draft/create',
        [ProcurementController::class, 'createPurchaseOrder']
    )->name('procurement.draft.create');


    // Purchase Order
    Route::get(
        '/procurement/{po}/edit',
        [ProcurementController::class, 'edit']
    )->name('procurement.edit');

    Route::put(
        '/procurement/{po}',
        [ProcurementController::class, 'update']
    )->name('procurement.update');

    Route::post(
        '/procurement/{po}/items',
        [ProcurementController::class, 'addItem']
    )->name('procurement.add-item');

    Route::delete(
        '/procurement/{po}/items/{item}',
        [ProcurementController::class, 'removeItem']
    )->name('procurement.remove-item');

    Route::delete(
        '/procurement/{po}',
        [ProcurementController::class, 'destroy']
    )->name('procurement.destroy');


    // Purchase Order Approval
    Route::get(
        '/procurement/{po}/approve',
        [ProcurementController::class, 'approve']
    )->name('procurement.approve');

    Route::post(
        '/procurement/{po}/approve',
        [ProcurementController::class, 'approveSubmit']
    )->name('procurement.approve.submit');

    Route::post(
        '/procurement/{po}/reject',
        [ProcurementController::class, 'reject']
    )->name('procurement.reject');

});