<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Request Leave
    </h1>
</div>

    <div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="/saveSupLeave">
                            @csrf

                            @if(session('msg'))
                                <div class="alert alert-success">{{session('msg')}} </div>
                            @endif

                            <div class="w-full">
                                <x-label for="leave_type" value="{{ __('Leave Type') }}" />
                                <select id="leave_type_select" name="leave_type" class="block mt-1 w-full">
                                    <option value="" disabled selected>Select Leave Type</option>
                                    <!-- Common leave options available to all users -->
                                    <option value="Casual Leave">Casual Leave</option>
                                    <option value="Annual Leave">Annual Leave</option>
                                    <option value="Medical Leave">Medical Leave</option>
                                    <option value="Maternity/Paternity Leave">Maternity/Paternity Leave</option>
                                    <option value="Work On Leave">Work On Leave</option>
                                    <option value="No Pay Leave">No Pay Leave</option>
                                    <option value="Other">Other</option>
                                </select>

                            </div>

                            <div class="mt-4" id="otherLeaveType" style="display: none;">
                                <x-label for="other_leave_type" value="{{ __('Other Leave Type') }}" />
                                <input type="text" id="other_leave_type" name="other_leave_type" class="block mt-1 w-full" placeholder="Enter Other Leave Type">
                            </div>


                            <div class="mt-4">
                                <x-label for="start_date" value="{{ __('Start Date') }}" />
                                <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" />
                            </div>

                            <div class="mt-4">
                                <x-label for="end_date" value="{{ __('End Date') }}" />
                                <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                            </div>

                            <div class="mt-4">
                                <x-label for="reason" value="{{ __('Reason') }}" />
                                <textarea id="reason" name="reason" rows="4" cols="50" class="form-textarea mt-1 block w-full">{{ old('reason') }}</textarea>
                            </div>

                            <div class="mt-4">
                                <x-label for="additional_notes" value="{{ __('Additional Notes') }}" />
                                <textarea id="additional_notes" name="additional_notes" rows="4" cols="50" class="form-textarea mt-1 block w-full">{{ old('additional_notes') }}</textarea>
                            </div>

                            <div class="mt-4">
                                <x-label for="covering_person" value="{{ __('Covering Person') }}" />
                                <select id="covering_person" name="covering_person" class="block mt-1 w-full">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach($users as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="flex items-center justify-end mt-4">
                                <x-button id="submitRequestButton" class="ml-4">
                                    {{ __('Submit Request') }}
                                </x-button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Add event listener to submit button
        document.getElementById('leave_type_select').addEventListener('change', function() {
            var selectedValue = this.value;
            if (selectedValue === 'Other') {
                document.getElementById('otherLeaveType').style.display = 'block';
            } else {
                document.getElementById('otherLeaveType').style.display = 'none';
            }
        });
    </script>



