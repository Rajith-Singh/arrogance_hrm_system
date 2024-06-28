<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Models\Holiday;
use App\Models\LeaveType;
use App\Models\Attendance;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\DateService;
use PDF;

class AttendanceController extends Controller
{

    public function create()
    {
        return view('example');
    }

    public function store(Request $request)
    {
        $request->validate([
            'holiday_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        Holiday::create([
            'holiday_date' => $request->holiday_date,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Holiday added successfully.');
    }



    // public function uploadAttendance(Request $request)
    // {
    //     $request->validate([
    //         'attendance_file' => 'required|file|mimes:csv,txt',
    //     ]);

    //     $path = $request->file('attendance_file')->getRealPath();
    //     $data = array_map('str_getcsv', file($path));
    //     $header = array_shift($data);

    //     $attendanceRecords = [];

    //     // Process each row
    //     foreach ($data as $row) {
    //         $rowData = array_combine($header, $row);

    //         $employeeId = $rowData['No.'];
    //         $dateTime = Carbon::parse($rowData['Date/Time']);
    //         $verifyCode = $rowData['VerifyCode'];

    //         $date = $dateTime->toDateString();

    //         if (!isset($attendanceRecords[$employeeId])) {
    //             $attendanceRecords[$employeeId] = [];
    //         }

    //         if (!isset($attendanceRecords[$employeeId][$date])) {
    //             $attendanceRecords[$employeeId][$date] = [
    //                 'check_in' => $dateTime,
    //                 'check_out' => $dateTime,
    //                 'verify_code' => $verifyCode
    //             ];
    //         } else {
    //             if ($dateTime->lt($attendanceRecords[$employeeId][$date]['check_in'])) {
    //                 $attendanceRecords[$employeeId][$date]['check_in'] = $dateTime;
    //             }

    //             if ($dateTime->gt($attendanceRecords[$employeeId][$date]['check_out'])) {
    //                 $attendanceRecords[$employeeId][$date]['check_out'] = $dateTime;
    //             }
    //         }
    //     }

    //     foreach ($attendanceRecords as $employeeId => $dates) {
    //         foreach ($dates as $date => $record) {
    //             $attendance = Attendance::firstOrNew([
    //                 'employee_id' => $employeeId,
    //                 'date' => $date
    //             ]);

    //             $attendance->check_in = $record['check_in']->toTimeString();
    //             $attendance->check_out = $record['check_out']->toTimeString();
    //             $attendance->verify_code = $record['verify_code'];
    //             $attendance->save();

    //             $this->handleLateComings($attendance);
    //         }
    //     }

    //     return redirect()->back()->with('message', 'Attendance data processed successfully.');
    // }

    // private function handleLateComings(Attendance $attendance)
    // {
    //     $officeStartTime = Carbon::createFromTime(8, 30);
    //     $lateStartTime = Carbon::createFromTime(8, 31);
    //     $lateEndTime = Carbon::createFromTime(8, 46);
    //     $halfDayTime = Carbon::createFromTime(12, 31);
    //     $officeEndTime = Carbon::createFromTime(17, 0);
    //     $extendedEndTime = Carbon::createFromTime(17, 15);

    //     $checkIn = Carbon::parse($attendance->check_in);
    //     $checkOut = Carbon::parse($attendance->check_out);

    //     if ($checkIn->between($lateStartTime, $lateEndTime)) {
    //         // Count late comings
    //         $lateCount = Attendance::where('employee_id', $attendance->employee_id)
    //             ->whereBetween('check_in', [$lateStartTime, $lateEndTime])
    //             ->whereMonth('date', $checkIn->month)
    //             ->count();

    //         if ($lateCount > 3) {
    //             // Mark as half-day or casual leave
    //             if ($checkIn->between($lateStartTime, $halfDayTime)) {
    //                 //$this->createLeave($attendance->employee_id, $attendance->date, 'half_day');
    //             } elseif ($checkIn->gt($halfDayTime)) {
    //                 //$this->createLeave($attendance->employee_id, $attendance->date, 'casual_leave');
    //             }
    //         }
    //     }

    //     // Check if extended time is required for late comers
    //     if ($checkIn->gt($officeStartTime) && $checkOut->lt($extendedEndTime)) {
    //         $attendance->check_out = $extendedEndTime->toTimeString();
    //         $attendance->save();
    //     }
    // }





    // public function uploadAttendance(Request $request)
    // {
    //     $request->validate([
    //         'attendance_file' => 'required|file|mimes:csv,txt',
    //     ]);

    //     $path = $request->file('attendance_file')->getRealPath();
    //     $data = array_map('str_getcsv', file($path));
    //     $header = array_shift($data);

    //     $attendanceRecords = [];

    //     // Process each row
    //     foreach ($data as $row) {
    //         $rowData = array_combine($header, $row);

    //         $employeeId = $rowData['No.'];
    //         $dateTime = Carbon::parse($rowData['Date/Time']);
    //         $verifyCode = $rowData['VerifyCode'];

    //         $date = $dateTime->toDateString();

    //         if (!isset($attendanceRecords[$employeeId])) {
    //             $attendanceRecords[$employeeId] = [];
    //         }

    //         if (!isset($attendanceRecords[$employeeId][$date])) {
    //             $attendanceRecords[$employeeId][$date] = [
    //                 'check_in' => $dateTime,
    //                 'check_out' => $dateTime,
    //                 'verify_code' => $verifyCode
    //             ];
    //         } else {
    //             if ($dateTime->lt($attendanceRecords[$employeeId][$date]['check_in'])) {
    //                 $attendanceRecords[$employeeId][$date]['check_in'] = $dateTime;
    //             }

    //             if ($dateTime->gt($attendanceRecords[$employeeId][$date]['check_out'])) {
    //                 $attendanceRecords[$employeeId][$date]['check_out'] = $dateTime;
    //             }
    //         }
    //     }

    //     foreach ($attendanceRecords as $employeeId => $dates) {
    //         foreach ($dates as $date => $record) {
    //             $attendance = Attendance::firstOrNew([
    //                 'employee_id' => $employeeId,
    //                 'date' => $date
    //             ]);

    //             $attendance->check_in = $record['check_in']->toTimeString();
    //             $attendance->check_out = $record['check_out']->toTimeString();
    //             $attendance->real_check_in = $record['check_in']->toTimeString();
    //             $attendance->real_check_out = $record['check_out']->toTimeString();
    //             $attendance->verify_code = $record['verify_code'];
    //             $attendance->save();

    //             $this->handleLateComings($attendance);
    //         }
    //     }

    //     return redirect()->back()->with('message', 'Attendance data processed successfully.');
    // }

    // private function handleLateComings($attendance)
    // {
    //     $officeStartTime = Carbon::createFromTime(8, 30);
    //     $lateStartTime = Carbon::createFromTime(8, 31);
    //     $lateEndTime = Carbon::createFromTime(8, 46);
    //     $halfDayTime = Carbon::createFromTime(12, 31);
    //     $extendedEndTime = Carbon::createFromTime(17, 15);

    //     $checkIn = Carbon::parse($attendance->check_in);
    //     $realCheckOut = Carbon::parse($attendance->real_check_out);

    //     if ($checkIn->between($lateStartTime, $lateEndTime)) {
    //         // Count late comings for the current month and year
    //         $lateCount = Attendance::where('employee_id', $attendance->employee_id)
    //             ->whereBetween('check_in', [$lateStartTime, $lateEndTime])
    //             ->whereMonth('date', $checkIn->month)
    //             ->whereYear('date', $checkIn->year)
    //             ->count();

    //         // Check for late comings exceeding 3
    //         if ($lateCount > 3) {
    //             if ($checkIn->lte($halfDayTime) && $checkIn->gte($lateStartTime)) {
    //                 // Mark as half-day leave
    //                 $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
    //             }
    //         }

    //         // Check if extended time is required for late comers
    //         if ($checkIn->gt($officeStartTime) && $realCheckOut->lt($extendedEndTime)) {
    //             $attendance->check_out = $extendedEndTime->toTimeString();
    //             $attendance->save();
    //         }
    //     }
    // }

    // private function createLeave($employeeId, $date, $type)
    // {
    //     $user = User::where('employee_id', $employeeId)->first();

    //     $leave = new Leave();
    //     $leave->user_id = $user->id;
    //     $leave->start_date = $date;
    //     $leave->end_date = $date;
    //     $leave->reason = "Late Coming";
    //     $leave->type = $type;
    //     $leave->covering_person = 'latecoming';
    //     $leave->supervisor_approval = 'Approved';
    //     $leave->management_approval = 'Approved';

    //     $leave->save();
    //     Log::info("Created leave record for employee: $employeeId on date: $date as $type leave");
    // }








    public function uploadAttendance(Request $request)
    {
        $request->validate([
            'attendance_file' => 'required|file|mimes:csv,txt',
        ]);
    
        $path = $request->file('attendance_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);
    
        $attendanceRecords = [];
    
        // Process each row
        foreach ($data as $row) {
            $rowData = array_combine($header, $row);
    
            $employeeId = $rowData['No.'];
            $dateTime = Carbon::parse($rowData['Date/Time']);
            $verifyCode = $rowData['VerifyCode'];
    
            $date = $dateTime->toDateString();
    
            if (!isset($attendanceRecords[$employeeId])) {
                $attendanceRecords[$employeeId] = [];
            }
    
            if (!isset($attendanceRecords[$employeeId][$date])) {
                $attendanceRecords[$employeeId][$date] = [
                    'check_in' => $dateTime,
                    'check_out' => $dateTime,
                    'verify_code' => $verifyCode
                ];
            } else {
                if ($dateTime->lt($attendanceRecords[$employeeId][$date]['check_in'])) {
                    $attendanceRecords[$employeeId][$date]['check_in'] = $dateTime;
                }
    
                if ($dateTime->gt($attendanceRecords[$employeeId][$date]['check_out'])) {
                    $attendanceRecords[$employeeId][$date]['check_out'] = $dateTime;
                }
            }
        }
    
        foreach ($attendanceRecords as $employeeId => $dates) {
            foreach ($dates as $date => $record) {
                $attendance = Attendance::firstOrNew([
                    'employee_id' => $employeeId,
                    'date' => $date
                ]);
    
                $attendance->check_in = $record['check_in']->toTimeString();
                $attendance->check_out = $record['check_out']->toTimeString();
                $attendance->real_check_in = $record['check_in']->toTimeString();
                $attendance->real_check_out = $record['check_out']->toTimeString();
                $attendance->verify_code = $record['verify_code'];
                $attendance->save();
    
                $this->handleLateComings($attendance);
            }
        }
    
        return redirect()->back()->with('message', 'Attendance data processed successfully.');
    }
    


    ////////////////////////////////////////////////////////////////////////////////////////////



    private function handleLateComingsOLD($attendance)
    {
        $officeStartTime = Carbon::createFromTime(8, 30);
        $lateStartTime = Carbon::createFromTime(8, 31);
        $lateEndTime = Carbon::createFromTime(8, 46);
        $halfDayTime = Carbon::createFromTime(12, 31);
        $extendedEndTime = Carbon::createFromTime(17, 15);
    
        $date = Carbon::parse($attendance->date);
        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = Carbon::parse($attendance->check_out);
    
        $currentMonth = $date->month;
        $currentYear = $date->year;
    
        if ($checkIn->between($lateStartTime, $lateEndTime)) {
            // Count late comings for the current month and year
            $lateCount = Attendance::where('employee_id', $attendance->employee_id)
                ->whereTime('check_in', '>=', $lateStartTime->toTimeString())
                ->whereTime('check_in', '<=', $lateEndTime->toTimeString())
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->count();
    
            $NOOFLATECOMINGS = 2;
            // Check for late comings exceeding 3
            if ($lateCount > $NOOFLATECOMINGS) {
                $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
            } else {
                // Check if the employee didn't cover the time by staying until the extended end time
                if ($checkOut->lt($extendedEndTime)) {
                    $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
                }
            } 
        }

        //Check if the employee comes between 8.46 AM to 12.31 PM
        if ($checkIn->gt($halfDayTime)) {
            $this->createLeave($attendance->employee_id, $attendance->date, 'Casual Leave');
        }
    
        // Check if the employee comes after 12:31 PM and before half day time
        if ($checkIn->gt($lateEndTime) && $checkIn->lt($halfDayTime)) {
            $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////





    private function handleLateComings($attendance)
    {
        $officeStartTime = Carbon::createFromTime(8, 30);
        $lateStartTime = Carbon::createFromTime(8, 31);
        $lateEndTime = Carbon::createFromTime(8, 46);
        $halfDayTime = Carbon::createFromTime(12, 31);
        
        $date = Carbon::parse($attendance->date);
        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = Carbon::parse($attendance->check_out);
        
        $currentMonth = $date->month;
        $currentYear = $date->year;

        if ($checkIn->between($lateStartTime, $lateEndTime)) {
            // Count late comings for the current month and year
            $lateCount = Attendance::where('employee_id', $attendance->employee_id)
                ->whereTime('check_in', '>=', $lateStartTime->toTimeString())
                ->whereTime('check_in', '<=', $lateEndTime->toTimeString())
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->count();

            $NOOFLATECOMINGS = 2;
            // Check for late comings exceeding the allowed limit
            if ($lateCount >= $NOOFLATECOMINGS) {
                $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
            } else {
                // Calculate the actual late minutes
                $lateMinutes = $checkIn->diffInMinutes($officeStartTime);
                $requiredCheckOutTime = Carbon::createFromTime(17, 0)->addMinutes($lateMinutes);
                
                // Check if the employee didn't cover the actual late minutes
                if ($checkOut->lt($requiredCheckOutTime)) {
                    $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
                }
            } 
        }

        // Check if the employee comes between 8:46 AM to 12:31 PM
        if ($checkIn->between($lateEndTime, $halfDayTime)) {
            $this->createLeave($attendance->employee_id, $attendance->date, 'Half Day');
        }

        // Check if the employee comes after 12:31 PM
        if ($checkIn->gt($halfDayTime)) {
            $this->createLeave($attendance->employee_id, $attendance->date, 'Casual Leave');
        }
    }





    
    // private function createLeave($employeeId, $date, $type)
    // {
    //     // Fetch user using employee_id from Attendance table
    //     $user = Attendance::join('users', 'users.emp_no', '=', 'attendances.employee_id')
    //                         ->where('attendances.employee_id', $employeeId)
    //                         ->select('users.id as user_id')
    //                         ->first();
    
    //     if ($user) {
    //         // Create a new Leave instance
    //         $leave = new Leave();
            
    //         // Assign fetched user_id to the leave record
    //         $leave->user_id = $user->user_id;
    //         $leave->leave_type = $type;
    //         $leave->start_date = $date;
    //         $leave->end_date = $date;
    //         $leave->reason = "Late Coming";
    //         $leave->covering_person = 'latecoming';
    //         $leave->supervisor_approval = 'Approved';
    //         $leave->management_approval = 'Approved';
    
    //         // Save the leave record
    //         $leave->save();
    
    //         // Log the creation of the leave record
    //         Log::info("Created leave record for employee: {$user->user_id} on date: $date as $type leave");
    //     } else {
    //         Log::error("User not found for employee_id: $employeeId");
    //     }
    // }



    private function createLeave($employeeId, $date, $type)
    {
        // Fetch user using employee_id from Attendance table
        $user = Attendance::join('users', 'users.emp_no', '=', 'attendances.employee_id')
                            ->where('attendances.employee_id', $employeeId)
                            ->select('users.id as user_id')
                            ->first();
    
        if ($user) {
            // Create a new Leave instance
            $leave = new Leave();
            
            // Assign fetched user_id to the leave record
            $leave->user_id = $user->user_id;
            $leave->leave_type = $type;
            $leave->start_date = $date;
            $leave->end_date = $date;
            $leave->reason = "Late Coming";
            $leave->covering_person = 'latecoming';
            $leave->supervisor_approval = 'Approved';
            $leave->management_approval = 'Approved';
    
            // Save the leave record
            $leave->save();
    
            // Log the creation of the leave record
            Log::info("Created leave record for employee: {$user->user_id} on date: $date as $type leave");
        } else {
            Log::error("User not found for employee_id: $user->user_id");
        }
    }
    
    


    public function checkCount($employeeId)
    {
        $lateStartTime = Carbon::createFromTime(8, 31);
        $lateEndTime = Carbon::createFromTime(8, 46);
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        $lateCount = Attendance::where('employee_id', $employeeId)
            ->whereTime('check_in', '>=', $lateStartTime->toTimeString())
            ->whereTime('check_in', '<=', $lateEndTime->toTimeString())
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();
    
        dd($lateCount);
    }

    public function checkAttendance(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Attendance::where('employee_id', auth()->user()->emp_no);

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        $attendanceRecords = $query->get();

        return response()->json($attendanceRecords);
    }

    public function updateCheckOut(Request $request, $id)
    {
        $attendance = Attendance::find($id);
        $attendance->real_check_in = $request->input('check_in');
        $attendance->real_check_out = $request->input('check_out');
        $attendance->save();

        return response()->json(['success' => true]);
    }

    public function checkEmpAttendance(Request $request)
    {
        $employeeId = $request->query('employee_id');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Attendance::where('employee_id', $employeeId);

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        $attendanceRecords = $query->get();

        return response()->json($attendanceRecords);
    }


///////////////////////////////////


    public function attendanceReport(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric|exists:users,emp_no', // Ensure emp_id exists in users table',
        ]);

        $employeeId = $request->input('employee_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Attendance::where('employee_id', $employeeId);

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        $attendanceRecords = $query->get();
        $employee = Attendance::join('users', 'users.emp_no', '=', 'attendances.employee_id')
                                ->where('attendances.employee_id', $employeeId)
                                ->select('users.name', 'users.emp_no')
                                ->first();

        $employeeName = str_replace(' ', '_', $employee->name);
        $fileName = "{$employee->emp_no}_{$employeeName}_attendance_report.pdf";

        $pdf = PDF::loadView('reports.attendance-report', [
            'records' => $attendanceRecords,
            'employee' => $employee
        ]);

        return $pdf->download($fileName);
    }

    public function leaveReport(Request $request)
    {

        $request->validate([
            'employee_id' => 'required|numeric|exists:users,emp_no', // Ensure emp_id exists in users table',
        ]);

        $employeeId = $request->input('employee_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Leave::where('user_id', $employeeId);

        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('end_date', '<=', $endDate);
        }

        $leaveRecords = $query->get();

        $employee = Attendance::join('users', 'users.emp_no', '=', 'attendances.employee_id')
                                ->where('attendances.employee_id', $employeeId)
                                ->select('users.name', 'users.emp_no')
                                ->first();

        // dd($employee);

        $employeeName = str_replace(' ', '_', $employee->name);
        $fileName = "{$employee->emp_no}_{$employeeName}_leave_report.pdf";


        $pdf = PDF::loadView('reports.leave-report', [
            'records' => $leaveRecords,
            'employee' => $employee
        ]);

        return $pdf->download($fileName);
    }

    public function attendanceSummaryReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Attendance::query();

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        $attendanceSummary = $query->get();
        $logo = asset('images/logo.png');

        $pdf = PDF::loadView('reports.attendance-report', [
            'records' => $attendanceSummary,
            'logo' => $logo
        ]);

        $fileName = "attendance_summary_report.pdf";

        return $pdf->download($fileName);
    }


    public function leaveSummaryReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Leave::query();

        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('end_date', '<=', $endDate);
        }

        $leaveSummary = $query->get();
        $logo = asset('images/logo.png');

        $pdf = PDF::loadView('reports.leave-report', [
            'records' => $leaveSummary,
            'logo' => $logo
        ]);

        $fileName = "leave_summary_report.pdf";

        return $pdf->download($fileName);
    }


    public function storeManualAttendance(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|numeric|exists:users,emp_no', // Ensure emp_id exists in users table',
            'date' => 'required', // Add validation for other_leave_type
            'check_in' => 'required',
            'check_out' => 'required',
            'verify_code' => 'required',
        ]);
    
        $attendance = new Attendance;
    
        $attendance->employee_id = $request->emp_id;
        $attendance->date = $request->date;
        $attendance->check_in = $request->check_in;
        $attendance->check_out = $request->check_out;
        $attendance->real_check_in = $request->check_in;
        $attendance->real_check_out = $request->check_out;
        $attendance->verify_code = $request->verify_code;
        $attendance->updated_by = auth()->user()->id;
    

        $attendance->save();
    
        return back()->with('msg', 'Manual attendance has been successfully added.');
    }


    
}    
