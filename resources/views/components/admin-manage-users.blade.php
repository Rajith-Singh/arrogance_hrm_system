<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Manage Users
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->usertype }}</td>
                                    <td>{{ $user->category }}</td>
                                    <td>
                                    <a href="/editUser/{{$user->id}}" class="btn btn-primary btn-sm">Edit</a>

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
