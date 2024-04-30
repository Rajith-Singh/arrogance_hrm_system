<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Support\Facades\View; // Import the View facade
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Http;



class LeaveController extends Controller
{
    public function storeLeave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        $leave = new Leave;

        $leave->user_id=auth()->user()->id;
        $leave->leave_type=$request->leave_type;
        $leave->start_date=$request->start_date;
        $leave->end_date=$request->end_date;
        $leave->reason=$request->reason;
        $leave->additional_notes=$request->additional_notes;
        $leave->supervisor_approval="Pending";
        $leave->management_approval="Pending";


        $leave->save();

        return back()->with('msg', 'Your leave request has been successfully processed.');
    }

    public function manageLeave(){

    }

    public function viewLeaves(Request $request) {
        // $leaves = Leave::where('user_id', auth()->user()->id)->get();  Fetch leaves for the authenticated user

        $leaves = Leave::join('users', 'users.id', '=', 'leaves.user_id')
                            ->select(
                                'users.name',
                                'leaves.id',
                                'leaves.user_id',
                                'leaves.leave_type',
                                'leaves.start_date',
                                'leaves.end_date',
                                'leaves.reason',
                                'leaves.additional_notes',
                                'leaves.additional_notes'
                            )
                            ->where('leaves.user_id', auth()->user()->id)
                            ->where('leaves.supervisor_approval', "Pending")
                            ->get();


        $manageLeaveView = View::make('components.manage-leave', ['leave' => $leaves])->render(); // Render the manage-leave view
        return view('emp-manage-leave', ['manageLeaveView' => $manageLeaveView]);
    }

    public function editLeave($id){
        $data = DB::table('leaves')->where('id',$id)->first();
        $editLeaveView = view('components.edit-leave', compact('data'))->render(); // Render the edit-leave view
        return view('emp-edit-leave', ['editLeaveView' => $editLeaveView]);
    }

    public function updateLeave(Request $request){

        $request->validate([
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        DB::table('leaves')->where('id', $request->id)->update([
            'leave_type'=>$request->leave_type,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'reason'=>$request->reason,
            'additional_notes'=>$request->additional_notes,
        ]);
        return redirect()->to('/manage-leave')->with('message', 'Leave successfully updated!');
    }

    public function deleteLeave($id){
        DB::table('leaves')->where('id',$id)->delete();
        return back()->with('deleteLeave')->with('del-message', 'Leave successfully deleted.');
    }

    public function viewEmpLeave(Request $request) {

        $leaves = Leave::join('users', 'users.id', '=', 'leaves.user_id')
                    ->select('users.name',
                            'leaves.id',
                            'leaves.user_id',
                            'leaves.leave_type', 
                            'leaves.supervisor_approval', 
                            'leaves.management_approval', 
                            )
                    ->get();
        $manageLeavesView = View::make('components.sup-get-leave', ['leave' => $leaves])->render(); // Render the manage-leave view
        return view('supervisor.sup-manage-leave', ['manageLeavesView' => $manageLeavesView]);

    }

    public function viewEmpLeaveRequest($user_id,$leave_id){
        $data = Leave::join('users', 'users.id', '=', 'leaves.user_id')
                    ->select(
                        'users.name',
                        'leaves.id',
                        'leaves.user_id',
                        'leaves.leave_type',
                        'leaves.start_date',
                        'leaves.end_date',
                        'leaves.reason',
                        'leaves.additional_notes'
                    )
                    ->where('leaves.user_id', $user_id)
                    ->where('leaves.id', $leave_id)
                    ->first();
                
        $LeaveView = view('components.sup-leave-view', compact('data'))->render(); // Render the edit-leave view
        return view('supervisor.sup-emp-leave-view', ['LeaveView' => $LeaveView]);
    }
    
    public function updateSupervisorApproval(Request $request)
    {
        DB::table('leaves')->where('id', $request->leave_id)
                        ->where('user_id', $request->user_id)
                        ->update([
                            'supervisor_approval' => $request->approval_status,
                            'supervisor_note' => $request->supervisor_note,
                        ]);
    
        if ($request->approval_status === 'Approved') {
            $user = User::find($request->user_id);
            $supervisor_name = auth()->user()->name;
            $data = [
                'userId' => $user->id,
                'message' => "Your leave request has been approved by $supervisor_name."
            ];
    
            // Emit notification event for approval
            Http::post('http://localhost:3000/notify', $data);
        } else if ($request->approval_status === 'Rejected') {
            $user = User::find($request->user_id);
            $supervisor_name = auth()->user()->name;
            $data = [
                'userId' => $user->id,
                'message' => "Your leave request has been rejected by $supervisor_name."
            ];
    
            // Emit notification event for rejection
            Http::post('http://localhost:3000/notify', $data);
        }
    
        return redirect()->to('/view-leaves')->with('message', 'Leave status successfully updated!');
    }
    


    public function viewEmpLeaveMgt(Request $request) {

        $leaves = Leave::join('users', 'users.id', '=', 'leaves.user_id')
                    ->select('users.name',
                            'leaves.id',
                            'leaves.user_id',
                            'leaves.leave_type', 
                            'leaves.supervisor_approval', 
                            'leaves.management_approval', 
                            )
                    ->where('supervisor_approval', 'Approved')
                    ->get();
        $manageLeavesView = View::make('components.mgt-get-leave', ['leave' => $leaves])->render(); // Render the manage-leave view
        return view('supervisor.sup-manage-leave', ['manageLeavesView' => $manageLeavesView]);

    }

    public function viewMgtLeaveRequest($user_id,$leave_id){
        $data = Leave::join('users', 'users.id', '=', 'leaves.user_id')
                    ->select(
                        'users.name',
                        'leaves.id',
                        'leaves.user_id',
                        'leaves.leave_type',
                        'leaves.start_date',
                        'leaves.end_date',
                        'leaves.reason',
                        'leaves.additional_notes'
                    )
                    ->where('leaves.user_id', $user_id)
                    ->where('leaves.id', $leave_id)
                    ->first();
                
        $LeaveView = view('components.mgt-leave-view', compact('data'))->render(); // Render the edit-leave view
        return view('management.mgt-emp-leave-view', ['LeaveView' => $LeaveView]);
    }
    
    public function updateManagementApproval(Request $request)
    {
        DB::table('leaves')->where('id', $request->leave_id)
                        ->where('user_id', $request->user_id)
                        ->update([
                            'management_approval' => $request->approval_status,
                            'management_note' => $request->management_note,
                        ]);
    
        if ($request->approval_status === 'Approved') {
            $user = User::find($request->user_id);
            $manager_name = auth()->user()->name;
            $data = [
                'userId' => $user->id,
                'message' => "Your leave request has been approved by $manager_name."
            ];
    
            // Emit notification event for approval
            Http::post('http://localhost:3000/notify', $data);
        } else if ($request->approval_status === 'Rejected') {
            $user = User::find($request->user_id);
            $manager_name = auth()->user()->name;
            $data = [
                'userId' => $user->id,
                'message' => "Your leave request has been rejected by $manager_name."
            ];
    
            // Emit notification event for rejection
            Http::post('http://localhost:3000/notify', $data);
        }
    
        return redirect()->to('/view-leaves-mgt')->with('message', 'Leave status successfully updated!');
    }
    

    public function viewMyLeaves(Request $request) {

        $leaves = Leave::join('users', 'users.id', '=', 'leaves.user_id')
                            ->select(
                                'users.name',
                                'leaves.id',
                                'leaves.user_id',
                                'leaves.leave_type',
                                'leaves.start_date',
                                'leaves.end_date',
                                'leaves.reason',
                                'leaves.additional_notes',
                                'leaves.supervisor_approval',
                                'leaves.supervisor_note',
                                'leaves.management_approval',
                                'leaves.management_note',
                            )
                            ->where('leaves.user_id', auth()->user()->id)
                            ->get();


        $manageLeaveView = View::make('components.view-emp-leaves', ['leave' => $leaves])->render(); // Render the manage-leave view
        return view('my-leaves', ['manageLeaveView' => $manageLeaveView]);
    }

    public function viewUsers() {
        $users = User::all();
        $manageUsers = View::make('components.admin-manage-users', ['users' => $users])->render(); // Render the manage-leave view
        return view('admin.manage-users', ['manageUsers' => $manageUsers]);
    }

    public function editUser($id){
        $user = DB::table('users')->where('id',$id)->first();
        $editUsers = view('components.edit-user', compact('user'))->render(); // Render the edit-leave view
        return view('admin.admin-edit-user', ['editUsers' => $editUsers]);
    }

    public function updateUser(Request $request){

        $request->validate([
            'usertype' => 'required',
            'category' =>  'required',
        ]);

        DB::table('users')->where('id', $request->id)->update([
            'usertype'=>$request->usertype,
            'category'=>$request->category,
        ]);
        return redirect()->to('/view-users')->with('message', 'User role successfully updated!');
    }
    
    public function getRemainiffngLeaves(Request $request){

        $leaves = LeaveType::join('leaves', 'leaves.leave_type', '=', 'leave_types.leave_type')
                            ->join('users', 'users.category', '=', 'leave_types.category')
                            ->select(
                                'leaves.id',
                                'leaves.user_id',
                                'leaves.leave_type',
                                'leaves.start_date',
                                'leaves.end_date',
                                'leaves.reason',
                                'leaves.additional_notes',
                                'leaves.supervisor_approval',
                                'leaves.supervisor_note',
                                'leaves.management_approval',
                                'leaves.management_note',
                                'users.category',
                                'users.id',
                                'leave_types.leave_type',
                                'leave_types.category',
                            )
                            ->where('leaves.user_id', auth()->user()->id)
                            ->where('leaves.user_id', auth()->user()->category)
                            ->where('leaves.user_id', auth()->user()->category)
                            ->where('leaves.leave_type',"leave_types.leave_type")
                            ->where('leaves.management_approval',"Approved")
                            ->get();
    }


    public function getRemainingLeaves(Request $request) {
        $userId = auth()->user()->id;
        $userCategory = auth()->user()->category;
    
        // Ensure category matches exactly as in database (consider trimming and case sensitivity)
        $userCategory = trim(strtolower($userCategory));

        // dd("User Category: " . $userCategory);

    
        // Fetch total leaves allowed from leave_types for the user's category
        $totalLeaves = LeaveType::select('leave_type', 'count as total_count')
                                ->where('category', $userCategory)
                                ->get()
                                ->keyBy('leave_type');

        \Log::info("Total Leaves: ", $totalLeaves->toArray());                        
    
        // Define the current year's start and end dates
        $yearStart = date('Y-01-01');
        $yearEnd = date('Y-12-31');
    
        // Fetch leaves taken and approved by user for the current year
        $leavesTaken = Leave::select('leave_type', DB::raw('SUM(DATEDIFF(end_date, start_date) + 1) as days_taken'))
                            ->where('user_id', $userId)
                            ->whereBetween('start_date', [$yearStart, $yearEnd])
                            ->whereBetween('end_date', [$yearStart, $yearEnd])
                            ->where('management_approval', 'Approved')
                            ->where('supervisor_approval', 'Approved')
                            ->groupBy('leave_type')
                            ->get()
                            ->keyBy('leave_type');
    
        // Initialize remaining leaves with all types set to zero taken
        $remainingLeaves = [];
        foreach ($totalLeaves as $type => $leaveInfo) {
            $daysTaken = isset($leavesTaken[$type]) ? $leavesTaken[$type]->days_taken : 0;
            $remainingLeaves[$type] = [
                'total' => $leaveInfo->total_count,
                'taken' => $daysTaken,
                'remaining' => $leaveInfo->total_count - $daysTaken
            ];
        }
    
        return $remainingLeaves;  // Return as array
    }
    
    
    public function showRemainingLeaves() {
        $remainingLeaves = $this->getRemainingLeaves(request()); // Fetch data
        $remainingLeavesView = View::make('components.user-dashboard', ['remainingLeaves' => $remainingLeaves])->render();
        return view('dashboard', ['remainingLeavesView' => $remainingLeavesView]);
    }
    
    
    
    
}