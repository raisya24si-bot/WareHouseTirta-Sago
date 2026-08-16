<?php

use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterGudangController;
use App\Http\Controllers\MasterKategoriController;
use App\Http\Controllers\MasterRakController;
use App\Http\Controllers\MasterRowController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\MasterSupplierController;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\StrukturLokasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MasterBarangController::class, 'index'])->name('barang.index');
Route::post('/barang', [MasterBarangController::class, 'store'])->name('barang.store');
Route::put('/barang/{masterBarang}', [MasterBarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{masterBarang}', [MasterBarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/master-kategori', [MasterKategoriController::class, 'index'])->name('master-kategori.index');
Route::post('/master-kategori', [MasterKategoriController::class, 'store'])->name('master-kategori.store');
Route::put('/master-kategori/{masterKategori}', [MasterKategoriController::class, 'update'])->name('master-kategori.update');
Route::delete('/master-kategori/{masterKategori}', [MasterKategoriController::class, 'destroy'])->name('master-kategori.destroy');

Route::get('/master-satuan', [MasterSatuanController::class, 'index'])->name('master-satuan.index');
Route::post('/master-satuan', [MasterSatuanController::class, 'store'])->name('master-satuan.store');
Route::put('/master-satuan/{masterSatuan}', [MasterSatuanController::class, 'update'])->name('master-satuan.update');
Route::delete('/master-satuan/{masterSatuan}', [MasterSatuanController::class, 'destroy'])->name('master-satuan.destroy');

Route::get('/master-supplier', [MasterSupplierController::class, 'index'])->name('master-supplier.index');
Route::post('/master-supplier', [MasterSupplierController::class, 'store'])->name('master-supplier.store');
Route::put('/master-supplier/{masterSupplier}', [MasterSupplierController::class, 'update'])->name('master-supplier.update');
Route::delete('/master-supplier/{masterSupplier}', [MasterSupplierController::class, 'destroy'])->name('master-supplier.destroy');

// MASTER GUDANG - satu halaman untuk Gudang, Rak, Row, dan Struktur Lokasi/Bin.
Route::get('/master-gudang', [MasterGudangController::class, 'index'])->name('master-gudang.index');

Route::post('/master-gudang', [MasterGudangController::class, 'store'])->name('master-gudang.store');
Route::put('/master-gudang/{masterGudang}', [MasterGudangController::class, 'update'])->name('master-gudang.update');
Route::delete('/master-gudang/{masterGudang}', [MasterGudangController::class, 'destroy'])->name('master-gudang.destroy');

Route::post('/master-rak', [MasterRakController::class, 'store'])->name('master-rak.store');
Route::put('/master-rak/{masterRak}', [MasterRakController::class, 'update'])->name('master-rak.update');
Route::delete('/master-rak/{masterRak}', [MasterRakController::class, 'destroy'])->name('master-rak.destroy');

Route::post('/master-row', [MasterRowController::class, 'store'])->name('master-row.store');
Route::put('/master-row/{masterRow}', [MasterRowController::class, 'update'])->name('master-row.update');
Route::delete('/master-row/{masterRow}', [MasterRowController::class, 'destroy'])->name('master-row.destroy');

Route::post('/struktur-lokasi', [StrukturLokasiController::class, 'store'])->name('struktur-lokasi.store');
Route::put('/struktur-lokasi/{strukturLokasi}', [StrukturLokasiController::class, 'update'])->name('struktur-lokasi.update');
Route::delete('/struktur-lokasi/{strukturLokasi}', [StrukturLokasiController::class, 'destroy'])->name('struktur-lokasi.destroy');

// STOCK OPNAME - modul terpisah, bukan bagian dari dropdown Master Data.
Route::get('/opname', [OpnameController::class, 'index'])->name('opname.index');
Route::post('/opname', [OpnameController::class, 'store'])->name('opname.store');
Route::get('/opname/{opname}', [OpnameController::class, 'show'])->name('opname.show');
Route::put('/opname/{opname}', [OpnameController::class, 'update'])->name('opname.update');
Route::post('/opname/{opname}/items', [OpnameController::class, 'addItem'])->name('opname.add-item');
Route::put('/opname/{opname}/items/{item}', [OpnameController::class, 'updateItem'])->name('opname.update-item');
Route::delete('/opname/{opname}/items/{item}', [OpnameController::class, 'deleteItem'])->name('opname.delete-item');
Route::delete('/opname/{opname}/bins/{lokasi}', [OpnameController::class, 'deleteBin'])->name('opname.delete-bin');
Route::delete('/opname/{opname}', [OpnameController::class, 'destroy'])->name('opname.destroy');