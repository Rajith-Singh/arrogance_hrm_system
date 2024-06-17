<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LeaveController; 
use Illuminate\Support\Facades\Mail;



class HomeController extends Controller
{
    protected $leaveController;

    public function __construct(LeaveController $leaveController)
    {
        $this->leaveController = $leaveController;
    }

    public function index()
    {
        $userData = ['usertype' => Auth::user()->usertype];

        if (Auth::user()->usertype === 'user') {
            // Redirect to the dashboard route
            return redirect()->route('dashboard');
        }
        else if (Auth::user()->usertype === 'hr') {
            $remainingLeaves = $this->leaveController->getRemainingLeaves(request());
            $userData['remainingLeaves'] = $remainingLeaves;
        }

        return view($this->getViewForUserType(), $userData);
    }

    public function dashboard()
    {
        $userData = ['usertype' => Auth::user()->usertype];

        // Fetch remaining leaves if user type is 'user'
        if (Auth::user()->usertype == 'user') {
            $remainingLeaves = $this->leaveController->getRemainingLeaves(request());
            $userData['remainingLeaves'] = $remainingLeaves;
        }

        return view('dashboard', $userData);
    }

    private function getViewForUserType()
    {
        switch (Auth::user()->usertype) {
            case 'admin':
                return 'admin.home';
            case 'supervisor':
                return 'supervisor.home';
            case 'management':
                return 'management.home';
            case 'hr':
                return ('hr.home');
            default:
                return 'dashboard'; // Fallback for 'user' and any other types
        }
    }

    // Method to fetch remaining leaves for regular users
    private function getRemainingLeaves()
    {
        return $this->leaveController->showRemainingLeaves();
    }
}