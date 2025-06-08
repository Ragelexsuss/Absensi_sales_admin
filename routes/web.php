<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {return view('login');})->name('login');
Route::middleware('auth')->group(function () {
    route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    route::name('home.')->group(function () {
        route::get('/home/kelola_map', function () {
            return view('kelola_map');
        })->name('kelola_map');
        route::get('/home/kelola_map/map', [\App\Http\Controllers\LokasiMap::class, 'index'])->name('map');
        route::get('/home/laporan_sales', function () {
            return view('laporan_sales');
        })->name('laporan_sales');
        route::get('/home/laporan_sales/detail_laporan_sales', function () {
            return view('detail_laporan_sales');
        })->name('detail_laporan_sales');
        route::get('/home/laporan_sales/detail_laporan_sales/hari', function () {
            return view('detail_laporan_sales_hari');
        })->name('detail_laporan_sales_hari');
    });



    Route::middleware('authlogin:supervisor')->group(function () {
        route::name('home.')->group(function () {
            route::get('/home/kelola_akun', function () {
                return view('kelola-akun');
            })->name('kelola_akun');
            route::get('/home/kelola_akun/mission', function () {
                return view('mission');
            })->name('mission');
            route::get('/home/salesorder', function () {
                return view('salesorder');
            })->name('salesorder');
            route::get('/home/salesorder/detail_order', function () {
                return view('detail_sales_order');
            })->name('detail_order');
            route::get('/home/stokbarang', function () {
                return view('stokbarang');
            })->name('stokbarang');
            route::get('/home/kelolabarang', function () {
                return view('gudang');
            })->name('gudang');


        });


    });

    Route::middleware('authlogin:admin')->group(function () {
        route::name('home.')->group(function () {
            route::get('/home/kelola_akun_supervisor', function () {
                return view('kelola_akun_admin');
            })->name('kelola_akun_admin');

        });
    });
});
