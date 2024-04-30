<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});



route::get('/home', [HomeController::class, 'index']);

// User (Employer) Routes

Route::get('/request-leave', function () {
    return view('emp-leave');
});

Route::post('/saveLeave',[LeaveController::class,'storeLeave']);

Route::get('/manage-leave',[LeaveController::class,'viewLeaves']);

Route::get('/editLeave/{id}', [LeaveController::class, 'editLeave']);

Route::post('/updateLeave', [LeaveController::class, 'updateLeave']);

Route::delete('/deleteLeave/{id}', [LeaveController::class, 'deleteLeave']);

Route::get('/view-my-leaves',[LeaveController::class,'viewMyLeaves']);

Route::get('/get-remaining-leaves',[LeaveController::class,'getRemainingLeaves']);




// // Supervisor Routes

// Route::get('/view-leaves',[LeaveController::class,'viewEmpLeave']);

// Route::get('/view-emp-leave/{user_id}/{leave_id}', [LeaveController::class, 'viewEmpLeaveRequest']);

// Route::post('/update-supervisor-approval', [LeaveController::class, 'updateSupervisorApproval']);

// // Management Routes

// Route::get('/view-leaves-mgt',[LeaveController::class,'viewEmpLeaveMgt']);

// Route::get('/view-mgt-leave/{user_id}/{leave_id}', [LeaveController::class, 'viewMgtLeaveRequest']);

// Route::post('/update-management-approval', [LeaveController::class, 'updateManagementApproval']);



// Routes accessible only to admins
Route::middleware(['role:admin'])->group(function () {
    Route::get('/view-users',[LeaveController::class,'viewUsers']);
    Route::get('/editUser/{id}', [LeaveController::class, 'editUser']);
    Route::post('/updateUser', [LeaveController::class, 'updateUser']);

    
});

// Routes accessible only to supervisors
Route::middleware(['role:supervisor'])->group(function () {
    Route::get('/view-leaves',[LeaveController::class,'viewEmpLeave']);

    Route::get('/view-emp-leave/{user_id}/{leave_id}', [LeaveController::class, 'viewEmpLeaveRequest']);

    Route::post('/update-supervisor-approval', [LeaveController::class, 'updateSupervisorApproval']);
});

// Routes accessible only to management
Route::middleware(['role:management'])->group(function () {
    Route::get('/view-leaves-mgt',[LeaveController::class,'viewEmpLeaveMgt']);

    Route::get('/view-mgt-leave/{user_id}/{leave_id}', [LeaveController::class, 'viewMgtLeaveRequest']);

    Route::post('/update-management-approval', [LeaveController::class, 'updateManagementApproval']);
});














