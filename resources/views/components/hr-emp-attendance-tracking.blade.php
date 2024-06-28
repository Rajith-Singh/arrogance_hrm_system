<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Edit Attendance
    </h1>
</div>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <x-validation-errors class="mb-4" />

                <!-- Date and Employee ID Filter Form -->
                <form id="filter-form" class="mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 mr-4">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                            <input type="text" id="employee_id" name="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex-1 mr-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex-1 mr-4">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex-1">
                            <label for="filter" class="block text-sm font-medium text-gray-700 invisible">Filter</label>
                            <button type="submit" class="mt-1 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Attendance Records -->
                <div id="attendance-records" class="mt-6">
                    <!-- Attendance records will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('filter-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const employeeId = document.getElementById('employee_id').value;
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        fetch(`/emp-attendance-tracking?employee_id=${employeeId}&start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                const recordsDiv = document.getElementById('attendance-records');
                recordsDiv.innerHTML = '';

                if (data.length > 0) {
                    const table = document.createElement('table');
                    table.className = 'min-w-full divide-y divide-gray-200';

                    const thead = document.createElement('thead');
                    thead.innerHTML = `
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verify Code</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    `;
                    table.appendChild(thead);

                    const tbody = document.createElement('tbody');
                    tbody.className = 'bg-white divide-y divide-gray-200';

                    data.forEach(record => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">${record.date}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="time" id="check_in_${record.id}" value="${record.real_check_in}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="time" id="check_out_${record.id}" value="${record.real_check_out}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">${record.verify_code}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="updateAttendance(${record.id})" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });

                    table.appendChild(tbody);
                    recordsDiv.appendChild(table);
                } else {
                    recordsDiv.innerHTML = '<p class="text-gray-500">No attendance records found for the selected date range.</p>';
                }
            })
            .catch(error => console.error('Error:', error));
    });

    function updateAttendance(recordId) {
        const checkInTime = document.getElementById(`check_in_${recordId}`).value;
        const checkOutTime = document.getElementById(`check_out_${recordId}`).value;

        fetch(`/update-checkout/${recordId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ check_in: checkInTime, check_out: checkOutTime })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Attendance times updated successfully.');
            } else {
                alert('Failed to update attendance times.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
