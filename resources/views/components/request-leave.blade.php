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

                        <form method="POST" action="/saveLeave">
                            @csrf

                            @if(session('msg'))
                                <div class="alert alert-success">{{session('msg')}} </div>
                            @endif

                            <div class="w-full">
                                <x-label for="leave_type" value="{{ __('Leave Type') }}" />
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

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    {{ __('Submit Request') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
