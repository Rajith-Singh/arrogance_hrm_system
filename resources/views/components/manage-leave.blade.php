<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Manage Leave
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
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Additional Notes</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leave as $data)
                                <tr>
                                    <td>{{$data->leave_type}}</td>
                                    <td>{{$data->start_date}}</td>
                                    <td>{{$data->end_date}}</td>
                                    <td>{{$data->reason}}</td>
                                    <td>{{$data->additional_notes}}</td>
                                    <td>
                                    <a href="/editLeave/{{$data->id}}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="/deleteLeave/{{$data->id}}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                    </form>

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
