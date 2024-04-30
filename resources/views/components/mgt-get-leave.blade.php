<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Manage Leaves
    </h1>
</div>

    <div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <x-validation-errors class="mb-4" />

                        @if(session('message'))
                            <div class="alert alert-success">{{session('message')}} </div>
                        @endif

                        @if(session('del-message'))
                            <div class="alert alert-primary">{{session('del-message')}} </div>
                        @endif

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Employer Name</th>
                                    <th>Leave Type</th>
                                    <th>Supervisor Approval</th>
                                    <th>Management Approval</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leave as $data)
                                <tr>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->leave_type}}</td>
                                    <td>{{$data->supervisor_approval}}</td>
                                    <td>{{$data->management_approval}}</td>
                                    <td>
                                    <a href="/view-mgt-leave/{{$data->user_id}}/{{$data->id}}" class="btn btn-success btn-sm">View</a>
                                    

                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>




                    </div>
                </div>
            </div>
        </div>
    </div>
