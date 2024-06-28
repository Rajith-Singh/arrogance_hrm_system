<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Attendance Entry (Manual)
    </h1>
</div>

    <div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <x-validation-errors class="mb-4" />

                        <form method="POST" action="/saveManualAttendance">
                            @csrf

                            @if(session('msg'))
                                <div class="alert alert-success">{{session('msg')}} </div>
                            @endif

                            <div class="w-full">
                                <x-label for="emp_id" value="{{ __('Employee No') }}" />
                                <input type="text" id="emp_id" name="emp_id" class="block mt-1 w-full" placeholder="Employee No">
                            </div>


                            <div class="mt-4">
                                <x-label for="Date" value="{{ __('Date') }}" />
                                <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" />
                            </div>


                            <div class="mt-4">
                                <x-label for="check_in" value="{{ __('Check In') }}" />
                                <input type="time" id="check_in" name="check_in" class="block mt-1 w-full" placeholder="Employee No">
                            </div>


                            <div class="mt-4">
                                <x-label for="check_out" value="{{ __('Check Out') }}" />
                                <input type="time" id="check_out" name="check_out" class="block mt-1 w-full" placeholder="Employee No">
                            </div>


                            <div class="mt-4">
                                <x-input class="block mt-1 w-full" type="verify_code" name="verify_code" value="M" readonly hidden/>
                            </div>



                            <div class="flex items-center justify-end mt-4">
                                <x-button id="submitRequestButton" class="ml-4">
                                    {{ __('Submit Attendance') }}
                                </x-button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





