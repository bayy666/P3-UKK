<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\ScheduleController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\UserBookingController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\SlotBookingController;
use App\Http\Controllers\Web\JadwalRegulerController;
use Illuminate\Support\Facades\Route;

// Rute publik
Route::get('/', function () {
    return redirect()->route('login');
});

// (Dihapus) Test route - tidak diperlukan di produksi


// Rute autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Fallback: izinkan GET /logout untuk mencegah error jika ada link GET yang terpasang
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Forgot password (reset password via email)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');
Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
    return back()->with('status', __($status));
})->name('password.email');

// Rute terproteksi - Memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Jadwal Ruang (semua peran)
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    
    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/staff', [ProfileController::class, 'updateStaff'])->name('profile.staff-update');

    // Rute untuk user (role 3)
    Route::prefix('user')->group(function () {
        Route::get('/slot-booking', [SlotBookingController::class, 'index'])->name('user.slot-booking.index');
        Route::get('/slot-booking/room/{id}', [SlotBookingController::class, 'show'])->name('user.slot-booking.show');
    Route::get('/slot-booking/form', [SlotBookingController::class, 'form'])->name('user.slot-booking.form');
        Route::post('/slot-booking', [SlotBookingController::class, 'store'])->name('user.slot-booking.store');
        Route::get('/slot-booking/confirm/{id}', [SlotBookingController::class, 'confirm'])->name('user.slot-booking.confirm');
    Route::get('/slot-booking/confirm/{id}/pdf', [SlotBookingController::class, 'confirmPdf'])->name('user.slot-booking.confirm.pdf');
        // Cek ketersediaan slot (AJAX)
        Route::get('/slot-booking/available', [SlotBookingController::class, 'available'])->name('user.slot-booking.available');
        Route::get('/bookings', [UserBookingController::class, 'index'])->name('user.bookings.index');
        Route::post('/bookings', [UserBookingController::class, 'store'])->name('user.bookings.store');
        Route::delete('/bookings/{id}/cancel', [UserBookingController::class, 'cancel'])->name('user.bookings.cancel');
        // Riwayat booking (kembali diaktifkan)
        Route::get('/bookings/history', [UserBookingController::class, 'history'])->name('user.bookings.history');
    });

    // Rute untuk admin dan petugas
    // Manajemen peminjaman
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::put('/bookings/{id}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::put('/bookings/{id}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

    // Jadwal Reguler (admin & petugas)
    Route::resource('jadwal-reguler', JadwalRegulerController::class)->except(['show']);

    // Rute hanya untuk admin
    // Manajemen ruangan
    Route::resource('rooms', RoomController::class);
    
    // Manajemen petugas
    Route::resource('staff', StaffController::class);
    
    // Manajemen user
    Route::resource('users', UserController::class);

    // Laporan (admin & petugas) - kontrol akses di controller
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});
