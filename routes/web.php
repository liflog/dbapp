<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use PHPUnit\Framework\Constraint\Operator;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ChangePasswordController;
use App\Models\User;

Route::get('/cc', function () {
    Artisan::call('cache:clear');
    echo '<script>alert("cache clear Success")</script>';
});
Route::get('/ccc', function () {
    Artisan::call('config:cache');
    echo '<script>alert("config cache Success")</script>';
});
Route::get('/vc', function () {
    Artisan::call('view:clear');
    echo '<script>alert("view clear Success")</script>';
});
Route::get('/cr', function () {
    Artisan::call('route:cache');
    echo '<script>alert("route clear Success")</script>';
});
Route::get('/coc', function () {
    Artisan::call('config:clear');
    echo '<script>alert("config clear Success")</script>';
});
Route::get('/storage123', function () {
    Artisan::call('storage:link');
    echo '<script>alert("linked")</script>';
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);

// ROUTE::ADMIN
Route::middleware('role:admin')->group(function () {
    Route::resource('user', UserController::class);
    Route::prefix('/admin')->group(function () {
        Route::get('/db_settings',[AdminController::class,'dbSettings']);
        Route::get('/users',[UserController::class,'index'])->name('admin.users');
        Route::get('/edit_db_set/{id}',[AdminController::class,'editDbset'])->name('admin.editDbset');
        Route::delete('/hapus_db_set/{id}',[AdminController::class,'hapusDbset'])->name('admin.hapusDbset');
        
        Route::post('/users/import',[UserController::class,'import'])->name('admin.import_users');
        Route::post('/students/import',[StudentController::class,'import'])->name('admin.import_students');
        Route::get('/students/export',[StudentController::class,'export'])->name('admin.export_students');

    });
});

// ROUTE::OPERATOR
Route::middleware('role:operator|admin')->group(function () {
    Route::prefix('operator')->group(function () {
        Route::get('/students',[OperatorController::class,'getStudents'])->name('students');
        Route::get('/student/{id}',[OperatorController::class,'getStudent'])->name('student_detail');
        Route::get('/student/edit/{id}',[OperatorController::class,'editStudent'])->name('student_edit');
        Route::put('/student/edit/{id}',[OperatorController::class,'updateStudent'])->name('student_update');
        Route::delete('/student/{id}',[OperatorController::class,'destroy'])->name('student_delete');
        Route::get('/import',[OperatorController::class,'import']);
        
        Route::get('/teachers',[OperatorController::class,'getTeachers'])->name('teachers');
        Route::get('/teacher/{id}',[OperatorController::class,'getTeacher'])->name('teacher_detail');
        Route::get('/teacher/edit/{id}',[OperatorController::class,'editTeacher'])->name('teacher_edit');
        Route::put('/teacher/edit/{id}',[OperatorController::class,'updateTeacher'])->name('teacher_update');
        Route::delete('/teacher/{id}',[OperatorController::class,'destroyTeacher'])->name('teacher_delete');
        
        Route::get('/revisi_data',[OperatorController::class,'revisiData'])->name('operator.revisi_data');
        Route::get('/compare_revisi/{id}',[OperatorController::class,'compareRevisi'])->name('compare_revisi');
    });
});

// Route::resource('students', StudentController::class);



// ROUTE::GURU
route::get('/guru/input',[TeacherController::class,'input'])->name('guru.input');
Route::middleware('role:guru|karyawan}')->group(function () {
    Route::prefix('guru')->group(function () {
        route::post('input',[TeacherController::class,'inputData'])->name('guru.input_data');
        route::get('/biodata',[TeacherController::class,'biodata'])->name('guru.biodata');
        Route::get('/edit',[TeacherController::class,'editTeacher'])->name('guru.edit');
        Route::put('/edit',[TeacherController::class,'updateTeacher'])->name('guru.update');

        route::get('/tambah_pendidikan',function ()
        {
            return view('guru.tambah_pendidikan');
        })->name('guru.tambah_pendidikan');
        route::post('/tambah_pendidikan',[TeacherController::class,'inputPendidikan'])->name('guru.input_pendidikan');


        route::get('/tambah_anak',function ()
        {
            return view('guru.tambah_anak');
        })->name('guru.tambah_anak');
        route::post('/tambah_anak',[TeacherController::class,'inputAnak'])->name('guru.input_anak');

        route::get('/tambah_diklat',function ()
        {
            return view('guru.tambah_diklat');
        })->name('guru.tambah_diklat');
        route::post('/tambah_diklat',[TeacherController::class,'inputDiklat'])->name('guru.input_diklat');
       
        
    });
});


// ROUTE::SISWA
Route::middleware('role:siswa')->group(function () {
    Route::prefix('siswa')->group(function () {
        Route::get('/data', [SiswaController::class,'data'])->name('siswa.data');
        Route::get('/student/edit',[SiswaController::class,'editStudent'])->name('siswa_edit');
        Route::put('/student/edit',[SiswaController::class,'ajukanUpdate'])->name('siswa_update');
        Route::get('/prestasi',[SiswaController::class,'achievement'])->name('siswa_prestasi');
        Route::post('/input_prestasi',[SiswaController::class,'inputAchievement'])->name('siswa.input_prestasi');
        Route::delete('/hapus_prestasi/{id}',[SiswaController::class,'deleteAchievement'])->name('siswa.hapus_prestasi');
        Route::get('/pengajuan_revisi',[SiswaController::class,'pengajuanRevisi'])->name('siswa.pengajuan_revisi');
       
    });
});


route::get('keluar',[LoginController::class,'keluar'])->name('keluar');
route::get('klaim_nis',function()
{
    return view('auth.cek_nis');
})->name('klaim_nis');

route::post('input_klaim_nis',[SocialiteController::class,'inputKlaimNis'])->name('input_klaim_nis');

route::get('cek_nis',[LoginController::class,'cekNis'])->name('cek_nis');

//Login Google
Route::get('auth/google',[SocialiteController::class,'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback',[SocialiteController::class,'handleGoogleCallback']);


Route::get('change-password', [ChangePasswordController::class,'index'])->name('ganti-pass');

Route::post('change-password', [ChangePasswordController::class,'store'])->name('change.password');

 Route::get('siswa/contact_center',[SiswaController::class,'contactCenter'])->name('siswa.contact_center');

