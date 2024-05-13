<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Register Leave
    </h1>
</div>

    <div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="/addLeave">
                            @csrf

                            @if(session('msg'))
                                <div class="alert alert-success">{{session('msg')}} </div>
                            @endif


                            <div class="mt-4">
                                <x-label for="leave_type" value="{{ __('Leave Type') }}" />
                                <input type="text" id="leave_type" name="leave_type" class="block mt-1 w-full" placeholder="Enter Leave Type">
                            </div>

                            <div class="mt-4">
                                <x-label for="category" value="{{ __('Category') }}" />

                                <select id="category" name="category" class="block mt-1 w-full">
                                    <option value="not set" disabled selected>Select Category</option>
                                    <option value="permanent">Permanent</option>
                                    <option value="probation">Probation</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                </select>

                            </div>

                            <div class="mt-4">
                                <x-label for="count" value="{{ __('No of Leave') }}" />
                                <input type="text" id="count" name="count" class="block mt-1 w-full" placeholder="Enter no of leave">
                            </div>

                            <div class="mt-4">
                                <x-label for="count_per_month" value="{{ __('No of Leave per Month') }}" />
                                <input type="text" id="count_per_month" name="count_per_month" class="block mt-1 w-full" placeholder="Enter no of leave per month">
                            </div>


                            <div class="flex items-center justify-end mt-4">
                                <x-button id="submitRequestButton" class="ml-4">
                                    {{ __('Add Leave') }}
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



