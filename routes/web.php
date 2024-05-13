<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});



route::get('/home', [HomeController::class, 'index']);

// User (Employer) Routes

// Route::get('/request-leave', function () {
//     return view('emp-leave');
// });

Route::post('/saveLeave',[LeaveController::class,'storeLeave']);

Route::get('/manage-leave',[LeaveController::class,'viewLeaves']);

Route::get('/editLeave/{id}', [LeaveController::class, 'editLeave']);

Route::post('/updateLeave', [LeaveController::class, 'updateLeave']);

Route::delete('/deleteLeave/{id}', [LeaveController::class, 'deleteLeave']);

Route::get('/view-my-leaves',[LeaveController::class,'viewMyLeaves']);

Route::get('/get-remaining-leaves',[LeaveController::class,'getRemainingLeaves']);

Route::get('/request-leave', [LeaveController::class, 'getuser']);


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

    Route::get('/request-supervisor-leave', [LeaveController::class, 'getSupuser']);

    Route::post('/saveSupLeave',[LeaveController::class,'storeSupLeave']);

    Route::get('/manage-supervisor-leave',[LeaveController::class,'viewSupLeaves']);

    Route::get('/editSupLeave/{id}', [LeaveController::class, 'editSupLeave']);


});

// Routes accessible only to management
Route::middleware(['role:management'])->group(function () {
    Route::get('/view-leaves-mgt',[LeaveController::class,'viewEmpLeaveMgt']);

    Route::get('/view-mgt-leave/{user_id}/{leave_id}', [LeaveController::class, 'viewMgtLeaveRequest']);

    Route::post('/update-management-approval', [LeaveController::class, 'updateManagementApproval']);

    Route::get('/request-management-leave', [LeaveController::class, 'getMgtUser']);

    Route::post('/saveMgtLeave',[LeaveController::class,'storeMgtLeave']);

    Route::get('/manage-management-leave',[LeaveController::class,'viewMgtLeaves']);

    Route::get('/editMgtLeave/{id}', [LeaveController::class, 'editMgtLeave']);


});



// Routes accessible only to hr
Route::middleware(['role:hr'])->group(function () {

    Route::get('/add-leave-type', function () {
        return view('hr.add-leave');
    });

    Route::post('/addLeave',[LeaveController::class,'addLeave']);

});












