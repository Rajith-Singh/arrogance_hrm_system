<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto" alt="Company Logo">
    <h1 class="mt-8 text-2xl font-medium text-red-600">
        Generate Reports
    </h1>
</div>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            <!-- Attendance Report Form -->
            <h2 class="text-xl font-medium text-gray-900">Attendance Report</h2>
            <form action="{{ url('/attendance-report') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-center justify-between">
                    <div class="flex-1 mr-4">
                        <label for="employee_id_attendance" class="block text-sm font-medium text-gray-700">Employee ID</label>
                        <input type="text" id="employee_id_attendance" name="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="start_date_attendance" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date_attendance" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="end_date_attendance" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date_attendance" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <label for="generate_attendance" class="block text-sm font-medium text-gray-700 invisible">Generate</label>
                        <button type="submit" class="mt-1 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Generate
                        </button>
                    </div>
                </div>
            </form>

            <!-- Attendance Summary Report Form -->
            <h2 class="text-xl font-medium text-gray-900">Attendance Summary Report</h2>
            <form action="{{ url('/attendance-summary-report') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-center justify-between">
                    <div class="flex-1 mr-4">
                        <label for="start_date_summary" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date_summary" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="end_date_summary" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date_summary" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <label for="generate_summary" class="block text-sm font-medium text-gray-700 invisible">Generate</label>
                        <button type="submit" class="mt-1 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Generate
                        </button>
                    </div>
                </div>
            </form>

            <!-- Leave Report Form -->
            <h2 class="text-xl font-medium text-gray-900">Leave Report</h2>
            <form action="{{ url('/leave-report') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-center justify-between">
                    <div class="flex-1 mr-4">
                        <label for="employee_id_leave" class="block text-sm font-medium text-gray-700">Employee ID</label>
                        <input type="text" id="employee_id_leave" name="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="start_date_leave" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date_leave" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="end_date_leave" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date_leave" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <label for="generate_leave" class="block text-sm font-medium text-gray-700 invisible">Generate</label>
                        <button type="submit" class="mt-1 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Generate
                        </button>
                    </div>
                </div>
            </form>

            <!-- Leave Summary Report Form -->
            <h2 class="text-xl font-medium text-gray-900">Leave Summary Report</h2>
            <form action="{{ url('/leave-summary-report') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-center justify-between">
                    <div class="flex-1 mr-4">
                        <label for="start_date_leave_summary" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date_leave_summary" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1 mr-4">
                        <label for="end_date_leave_summary" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date_leave_summary" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="flex-1">
                        <label for="generate_leave_summary" class="block text-sm font-medium text-gray-700 invisible">Generate</label>
                        <button type="submit" class="mt-1 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Generate
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
