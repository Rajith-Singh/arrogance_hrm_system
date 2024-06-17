<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Welcome to the Human Resources Management System
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
        Welcome to your personalized dashboard where you can manage your HR-related tasks effortlessly. 
        Here, you can submit leave requests, view your leave balances, track your attendance, and access 
        important HR resources. Feel free to explore the various features available to you and reach out to our 
        support team if you need any assistance. We're here to help you make the most out of our HRM system and 
        support you in your journey with us.
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

    <!-- Remaining Leaves Component -->
    <div class="bg-blue-200 shadow-md rounded-lg p-6">
        <h2 class="text-xl lg:text-2xl font-semibold text-blue-800 mb-4">Remaining Leaves</h2>
        @if ((auth()->user()->category == 'internship') || (auth()->user()->category == 'probation'))
            <table class="table table-responsive-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Leave Type</th>
                        <th>Leaves Taken</th>
                        <th>Remaining Leaves</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $remainingLeaves['Leave Type'] }}</td>
                        <td>{{ $remainingLeaves['Leaves Taken'] }}</td>
                        <td class="{{ $remainingLeaves['Remaining Leaves'] == 0 ? 'text-danger' : '' }}">
                            {{ $remainingLeaves['Remaining Leaves'] }}
                        </td>
                        <td class="{{ $remainingLeaves['Status'] == 'No Pay' ? 'text-danger' : '' }}">
                            {{ $remainingLeaves['Status'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @elseif (auth()->user()->category == 'permanent')
            <table class="table table-responsive-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Leave Type</th>
                        <th>Total Allocated</th>
                        <th>Allocated per month</th>
                        <th>Leaves Taken</th>
                        <th>Remaining Leaves</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remainingLeaves as $type => $data)
                        @php
                            $allocated = $data['Total Allocated'];
                            $taken = $data['Leaves Taken'];
                            $rowClass = $allocated <= $taken ? 'text-danger' : '';
                        @endphp
                        <tr class="{{ $rowClass }}">
                            <td>{{ $type }}</td>
                            <td>{{ $allocated }}</td>
                            <td>{{ $data['Allocated per month'] }}</td>
                            <td>{{ $taken }}</td>
                            <td>{{ $data['Remaining Leaves'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @elseif (auth()->user()->category == 'probation')
            <table class="table table-responsive-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Leave Type</th>
                        <th>Total Allocated</th>
                        <th>Allocated per month</th>
                        <th>Leaves Taken</th>
                        <th>Remaining Leaves</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remainingLeaves as $type => $data)
                        @php
                            $allocated = $data['Total Allocated'];
                            $taken = $data['Leaves Taken'];
                            $rowClass = $allocated <= $taken ? 'text-danger' : '';
                        @endphp
                        <tr class="{{ $rowClass }}">
                            <td>{{ $type }}</td>
                            <td>{{ $allocated }}</td>
                            <td>{{ $data['Allocated per month'] }}</td>
                            <td>{{ $taken }}</td>
                            <td>{{ $data['Remaining Leaves'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>