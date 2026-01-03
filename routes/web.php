<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\LabourController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/camera_web', function () {
    return view('camera_web');
    // return 'hello';
});

Route::get('/camera_scan', function () {
    return view('camera_scan');
    // return 'hello';
});



Route::get('/login', [RegisterController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/', [ProjectController::class, 'dashboard'])->name('dashboard');
Route::get('/settings', [ProjectController::class,'settings'])->name('settings');
Route::post('/settings/store', [ProjectController::class,'settings_store'])->name('settings.store');
Route::post('/settings/update', [ProjectController::class,'settings_update'])->name('settings.update');
Route::delete('/settings/{id}', [ProjectController::class,'settings_destroy'])->name('settings.delete');
Route::post('/settings/get', [ProjectController::class,'settings_getCategory'])->name('settings.get');

Route::get('/project', [ProjectController::class, 'index'])->name('project');
Route::get('/project/view', [ProjectController::class, 'view'])->name('project.view');
Route::get('/project/add', [ProjectController::class, 'add'])->name('project.add');
Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
Route::get('/project/edit', [ProjectController::class, 'edit'])->name('project.edit');
Route::post('/project/update', [ProjectController::class, 'update'])->name('project.update');

Route::get('/bulk-upload', [ProjectController::class, 'bulk_upload'])->name('bulk.upload');
Route::get('/attendence', [ProjectController::class, 'attendence'])->name('attendence');

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
Route::get('/employee/view', [EmployeeController::class, 'view'])->name('employee.view');
Route::get('/employee/add', [EmployeeController::class, 'add'])->name('employee.add');
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
Route::get('/employee/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::post('/employee/update', [EmployeeController::class, 'update'])->name('employee.update');

Route::get('/contractor', [ContractorController::class, 'index'])->name('contractor');
Route::get('/contractor/view', [ContractorController::class, 'view'])->name('contractor.view');
Route::get('/contractor/add', [ContractorController::class, 'add'])->name('contractor.add');
Route::post('/contractor/store', [ContractorController::class, 'store'])->name('contractor.store');
Route::get('/contractor/edit', [ContractorController::class, 'edit'])->name('contractor.edit');
Route::post('/contractor/update', [ContractorController::class, 'update'])->name('contractor.update');

Route::get('/labour', [LabourController::class, 'index'])->name('labour');
Route::get('/labour/view', [LabourController::class, 'view'])->name('labour.view');
Route::get('/labour/add', [LabourController::class, 'add'])->name('labour.add');
Route::post('/labour/store', [LabourController::class, 'store'])->name('labour.store');
Route::get('/labour/edit', [LabourController::class, 'edit'])->name('labour.edit');
Route::post('/labour/update', [LabourController::class, 'update'])->name('labour.update');

Route::get('/labour-strength', [ReportController::class, 'labour_strength'])->name('labour_strength');
Route::get('/contractor-report', [ReportController::class, 'contractor_report'])->name('contractor.report');
Route::get('/nmr-report', [ReportController::class, 'contractor_report'])->name('nmr_labour');
