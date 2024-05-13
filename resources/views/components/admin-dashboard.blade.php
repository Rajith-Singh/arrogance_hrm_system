<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Welcome to the Human Resources Management System
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
        Welcome to the admin dashboard of our Human Resources Management System. Here, you have access to a wide range 
        of tools and functionalities to manage the HRM system effectively. As an administrator, you have the authority 
        to configure settings, manage user roles, oversee leave management, and much more. Your contributions are instrumental 
        in ensuring smooth operations and fostering a positive work environment within our organization. Should you require 
        any assistance or have questions about navigating the admin dashboard, please don't hesitate to reach out to our support team. 
        We're here to help you make the most out of our HRM system. Thank you for your dedication and commitment to enhancing HR processes 
        and supporting our organization's growth.
    </p>
</div>

<div class="bg-gray-100 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8">
    <!-- Leave Reminder Component -->
    <div class="bg-purple-200 shadow-md rounded-lg p-6">
        <h2 class="text-xl lg:text-2xl font-semibold text-purple-800 mb-4">Leave Reminder</h2>
      
        <p class="text-gray-700">Stay organized with upcoming leave dates.</p>
       
    </div>

    <!-- Leave Request Status Component -->
    <div class="bg-green-200 shadow-md rounded-lg p-6">
        <h2 class="text-xl lg:text-2xl font-semibold text-green-800 mb-4">Leave Request Status</h2>

        <div>
            <h3 class="text-lg font-medium text-green-700">Supervisor Approval</h3>
            <p class="text-sm text-green-700">Approved</p>
        </div>
        <div class="mt-4">
            <h3 class="text-lg font-medium text-green-700">Management Approval</h3>
            <p class="text-sm text-green-700">Pending</p>
        </div>
       
    </div>

    <!-- Remaining Leaves Component -->
    <div class="bg-blue-200 shadow-md rounded-lg p-6">
        <h2 class="text-xl lg:text-2xl font-semibold text-blue-800 mb-4">Remaining Leaves</h2>

       
        <p class="text-gray-700"> </p>
       
       
    </div>

    
</div>

@if(isset($leaveData))
    <table class="table table-responsive-sm table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Leave Type</th>
                <th>Total Allocated</th>
                <th>Leaves Taken</th>
                <th>Remaining Leaves</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leaveData as $leave)
                <tr>
                    <td>{{ $leave['leave_type'] }}</td>
                    <td>{{ $leave['available_leaves'] }}</td>
                    <td>{{ $leave['leaves_taken'] ?? '0' }}</td>
                    <td>{{ $leave['available_leaves'] - ($leave['leaves_taken'] ?? '0') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No leave data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@else
    <p>Leave data not received in the component.</p>
@endif
