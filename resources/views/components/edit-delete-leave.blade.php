<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Edit/Delete Leave
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
                            <input type="date" id="start_date" name="start_date"  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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

                <!-- Leave Records -->
                <div id="leave-records" class="mt-6">
                    <!-- Leave records will be populated here -->
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

    fetch(`/leaves/search`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ employee_id: employeeId, start_date: startDate, end_date: endDate })
    })
    .then(response => response.json())
    .then(data => {
        const recordsDiv = document.getElementById('leave-records');
        recordsDiv.innerHTML = '';

        if (data.leaves.length > 0) {
            const table = document.createElement('table');
            table.className = 'min-w-full divide-y divide-gray-200';

            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            `;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            tbody.className = 'bg-white divide-y divide-gray-200';

            data.leaves.forEach(leave => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">${leave.leave_type}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="text" id="start_date_${leave.id}" value="${leave.start_date}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="text" id="end_date_${leave.id}" value="${leave.end_date}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button onclick="deleteLeave(${leave.id})" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 ml-2">Delete</button>
                </td>
            `;
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            recordsDiv.appendChild(table);
        } else {
            recordsDiv.innerHTML = '<p class="text-gray-500">No leave records found for the selected date range.</p>';
        }
    })
    .catch(error => console.error('Error:', error));
});

function updateLeave(leaveId) {
    const startDate = document.getElementById(`start_date_${leaveId}`).value;
    const endDate = document.getElementById(`end_date_${leaveId}`).value;

    fetch(`/leaves/${leaveId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ start_date: startDate, end_date: endDate })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Leave updated successfully.');
        } else {
            alert('Failed to update leave .');
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteLeave(leaveId) {
    fetch(`/leaves/${leaveId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Leave deleted successfully.');
            document.getElementById('filter-form').submit();
        } else {
            alert('Failed to delete leave.');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
