<!-- resources/views/components/edit-leave.blade.php -->

<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Update Leave Request
    </h1>
</div>

<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="/updateLeave">
                        @csrf

                        <input type="text" name="id" value="{{ $data->id }}">

                        <div class="w-full">
                            <x-label for="leave_type" value="Leave Type" />
                            <select id="leave_type" name="leave_type" class="block mt-1 w-full" required>
                                <option value="" disabled selected>Select Leave Type</option>
                                <option value="Annual Leave">Annual Leave</option>
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Maternity/Paternity Leave">Maternity/Paternity Leave</option>
                                <option value="Family/Medical Leave">Family/Medical Leave</option>
                                <option value="Bereavement Leave">Bereavement Leave</option>
                                <option value="Unpaid Leave">Unpaid Leave</option>
                                <option value="Study/Training Leave">Study/Training Leave</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="start_date" value="Start Date" />
                            <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" value="{{ $data->start_date }}" />
                        </div>

                        <div class="mt-4">
                            <x-label for="end_date" value="End Date" />
                            <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" value="{{ $data->end_date }}" />
                        </div>

                        <div class="mt-4">
                            <x-label for="reason" value="Reason" />
                            <textarea id="reason" name="reason" rows="4" cols="50" class="form-textarea mt-1 block w-full">{{ $data->reason }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-label for="additional_notes" value="Additional Notes" />
                            <textarea id="additional_notes" name="additional_notes" rows="4" cols="50" class="form-textarea mt-1 block w-full">{{ $data->additional_notes }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update Request') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
