
<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
    .radio-container {
        position: relative;
        margin-right: 1rem;
    }

    .radio-container input {
        display: none;
    }

    .radio-checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 24px;
        width: 24px;
        background-color: #ccc;
        border-radius: 50%;
    }

    .radio-container:hover .radio-checkmark {
        background-color: #ddd;
    }

    /* Customized colors for different statuses */
    .radio-container.pending input:checked + .radio-checkmark {
        background-color: #FFD700;
    }

    .radio-container.approved input:checked + .radio-checkmark {
        background-color: #008000;
    }

    .radio-container.rejected input:checked + .radio-checkmark {
        background-color: #FF0000;
    }

    /* Custom symbols for different statuses */
    .radio-container.pending input:checked + .radio-checkmark::before {
        content: '?';
        font-size: 1rem;
        color: black;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .radio-container.approved input:checked + .radio-checkmark::before {
        content: '\2713'; /* Unicode checkmark symbol */
        font-size: 1rem;
        color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .radio-container.rejected input:checked + .radio-checkmark::before {
        content: '\2718'; /* Unicode cross mark symbol */
        font-size: 1rem;
        color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .radio-label {
        margin-left: 2rem;
    }
</style>

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        View Leave Request
    </h1>
</div>

<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="/update-management-approval">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ $data->user_id }}" readonly>

                        <input type="hidden" name="leave_id" value="{{ $data->id }}" readonly>

                        <div class="w-full">
                            <x-label for="emp_name" value="Employer's Name" />
                            <x-input id="emp_name" class="block mt-1 w-full" type="text" name="emp_name" value="{{ $data->name }}" readonly />
                        </div>

                        <div class="mt-4">
                            <x-label for="leave_type" value="Leave Type" />
                            <x-input id="leave_type" class="block mt-1 w-full" type="text" name="leave_type" value="{{ $data->leave_type }}" readonly />
                        </div>

                        <div class="mt-4">
                            <x-label for="start_date" value="Start Date" />
                            <!-- Convert date to Carbon instance and format it -->
                            <x-input id="start_date" class="block mt-1 w-full" type="text" name="start_date" value="{{ $data->start_date ? \Carbon\Carbon::parse($data->start_date)->format('d/m/Y') : '' }}"  readonly />
                        </div>

                        <div class="mt-4">
                            <x-label for="end_date" value="End Date" />
                            <x-input id="end_date" class="block mt-1 w-full" type="text" name="end_date" value="{{ $data->end_date ? \Carbon\Carbon::parse($data->end_date)->format('d/m/Y') : '' }}" readonly />
                        </div>

                        <div class="mt-4">
                            <x-label for="reason" value="Reason" />
                            <textarea id="reason" name="reason" rows="4" cols="50" class="form-textarea mt-1 block w-full" readonly>{{ $data->reason }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-label for="additional_notes" value="Additional Notes" />
                            <textarea id="additional_notes" name="additional_notes" rows="4" cols="50" class="form-textarea mt-1 block w-full" readonly>{{ $data->additional_notes }}</textarea>
                        </div>

                        
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        
                            <h2 class="mt-8 text-2xl font-medium text-gray-900">
                                Management Approval
                            </h2> 
                            <hr>
                           
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
    
                            <div class="flex items-center justify-between">
                                <!-- Pending -->
                                <label class="radio-container pending">
                                    <input type="radio" name="approval_status" value="Pending" checked>
                                    <div class="radio-checkmark"></div>
                                    <span class="radio-label">Pending</span>
                                </label>
                                
                                <!-- Approved -->
                                <label class="radio-container approved">
                                    <input type="radio" name="approval_status" value="Approved">
                                    <div class="radio-checkmark"></div>
                                    <span class="radio-label">Approved</span>
                                </label>
                                
                                <!-- Rejected -->
                                <label class="radio-container rejected">
                                    <input type="radio" name="approval_status" value="Rejected">
                                    <div class="radio-checkmark"></div>
                                    <span class="radio-label">Rejected</span>
                                </label>
                            </div>

                            <div class="mt-4">
                                <x-label for="note" value="Note" />
                                <textarea id="note" name="management_note" rows="4" cols="50" class="form-textarea mt-1 block w-full"></textarea>
                            </div>

                            <div class="mt-4">
                                <x-label for="management" value="Management" />
                                <x-input id="management" class="block mt-1 w-full" type="text" name="management" value="{{ Auth::user()->name }}" readonly />
                            </div>
                            
                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    {{ __('Submit') }}
                                </x-button>
                            </div>
                    </form>
                        </div>




                </div>
            </div>
        </div>
    </div>
</div>
