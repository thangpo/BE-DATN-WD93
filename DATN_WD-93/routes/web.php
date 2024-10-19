<?php

use Illuminate\Support\Facades\Auth;
//admin
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SpecialtyController;
//client
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Client\ContactController;


// Route::get('/', function () {
//     return view('welcome');
// });
//Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
//Login + signup
Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/loginSuccess', [AuthController::class, 'loginSuccess'])->name('loginSuccess')->middleware('auth');
Route::get('/account', [AuthController::class, 'account'])->name('account');
Route::get('/viewRegister', [AuthController::class, 'viewRegister'])->name('viewRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//login success + admin
Route::middleware('auth')->group(function () {
    Route::get('/loginSuccess', [AuthController::class, 'loginSuccess'])->name('loginSuccess')->middleware('auth');
    Route::middleware('auth.admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });
});

Auth::routes();
//user management
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/viewEditAcc', [AuthController::class, 'viewEditAcc'])->name('viewEditAcc');
Route::post('/editAcc', [AuthController::class, 'editAcc'])->name('editAcc');

//admin
Route::middleware(['auth', 'auth.admin'])->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashborad', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        //categories
        Route::prefix('categories')
            ->as('categories.')
            ->group(function () {
                Route::get('/categoriesList', [CategoryController::class, 'categoriesList'])->name('categoriesList');
                Route::get('/viewCateAdd', [CategoryController::class, 'viewCateAdd'])->name('viewCateAdd');
                Route::post('/cateAdd', [CategoryController::class, 'cateAdd'])->name('cateAdd');
                Route::get('/cateUpdateForm/{id}', [CategoryController::class, 'cateUpdateForm'])->name('cateUpdateForm');
                Route::post('/cateUpdate', [CategoryController::class, 'cateUpdate'])->name('cateUpdate');
                Route::delete('/cateDestroy/{id}', [CategoryController::class, 'cateDestroy'])->name('cateDestroy');
            });
        //products
        Route::prefix('products')
            ->as('products.')
            ->group(function () {
                Route::get('/productList', [ProductController::class, 'productList'])->name('productList');
                Route::get('/viewProAdd', [ProductController::class, 'viewProAdd'])->name('viewProAdd');
                Route::post('/productAdd', [ProductController::class, 'productAdd'])->name('productAdd');
                Route::get('/productUpdateForm/{id}', [ProductController::class, 'productUpdateForm'])->name('productUpdateForm');
                Route::post('/productUpdate', [ProductController::class, 'productUpdate'])->name('productUpdate');
                Route::delete('/productDestroy/{id}', [ProductController::class, 'productDestroy'])->name('productDestroy');
            });
        //specialties
        Route::prefix('specialties')
            ->as('specialties.')
            ->group(function () {
                Route::get('/specialtyList', [SpecialtyController::class, 'index'])->name('specialtyList');
                Route::post('/specialtyAdd', [SpecialtyController::class, 'store']);
                Route::put('/specialtyUpdate/{id}', [SpecialtyController::class, 'update']);
                Route::delete('/specialtyDestroy/{id}', [SpecialtyController::class, 'destroy']);
            });
        //doctors
        Route::prefix('doctors')
            ->as('doctors.')
            ->group(function () {
                Route::get('/doctorsList', [DoctorController::class, 'index'])->name('doctors.index');
                Route::post('/doctorsAdd', [DoctorController::class, 'store'])->name('doctors.store');
                Route::get('/doctorsEdit/{id}', [DoctorController::class, 'show'])->name('doctors.show');
                Route::get('/doctorsDetails/{id}', [DoctorController::class, 'showDetails']);
                Route::put('/doctorsUpdate/{id}', [DoctorController::class, 'update'])->name('doctors.update');
                Route::delete('/doctorsDestroy/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

                Route::get('/doctor/schedule/{doctorId}', [DoctorController::class, 'showSchedule'])->name('doctor.schedule');
                Route::post('/doctor/scheduleAdd', [DoctorController::class, 'scheduleAdd']);
                Route::get('/doctor/scheduleEdit/{id}', [DoctorController::class, 'scheduleEdit']);
                Route::put('/doctor/scheduleUpdate/{id}', [DoctorController::class, 'scheduleUpdate']);
                Route::delete('/doctor/scheduleDestroy/{id}', [DoctorController::class, 'scheduleDestroy']);
            });
        //order
        // Route::prefix('bills')
        //     ->as('bills.')
        //     ->group(function () {
        //         Route::get('/',               [BillsController::class, 'index'])->name('index');
        //         Route::get('/show/{id}',     [BillsController::class, 'show'])->name('show');
        //         Route::put('{id}/update',    [BillsController::class, 'update'])->name('update');
        //         Route::delete('{id}/destroy', [BillsController::class, 'destroy'])->name('destroy');
        //     });
        //account
        // Route::prefix('account')
        //     ->as('account.')
        //     ->group(function () {
        //         Route::get('/accountList', [AccountController::class, 'accountList'])->name('accountList');
        //         Route::get('/viewAccAdd', [AccountController::class, 'viewAccAdd'])->name('viewAccAdd');
        //         Route::post('/accAdd', [AccountController::class, 'accAdd'])->name('accAdd');
        //         Route::get('/accUpdateForm/{id}', [AccountController::class, 'accUpdateForm'])->name('accUpdateForm');
        //         Route::post('/accUpdate', [AccountController::class, 'accUpdate'])->name('accUpdate');
        //         Route::delete('/accDestroy/{id}', [AccountController::class, 'accDestroy'])->name('accDestroy');
        //     });
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
