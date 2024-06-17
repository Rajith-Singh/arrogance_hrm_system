<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\Attendance;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
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
    
    private function handleLateComings($attendance)
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
    
            // Check for late comings exceeding 3
            if ($lateCount > 3) {
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


    
}    
