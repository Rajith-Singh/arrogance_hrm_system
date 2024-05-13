<!-- resources/views/components/edit-user.blade.php -->

<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Update User
    </h1>
</div>

<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="/updateUser">
                        @csrf

                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="mt-4">
                            <x-label for="name" value="Name" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" readonly/>
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="Email" />
                            <x-input id="email" class="block mt-1 w-full" type="text" name="email" value="{{ $user->email }}" readonly />
                        </div>

                        <div class="mt-4">
                            <x-label for="usertype" value="User Role" />
                            <select id="usertype" name="usertype" class="block mt-1 w-full">
                                <option value="user" disabled selected>Select User Role</option>
                                <option value="admin">Admin</option>
                                <option value="supervisor">Supervisor</option>
                                <option value="management">Management</option>
                                <option value="hr">HR</option>
                                <option value="user">Normal User</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="category" value="Category" />
                            <select id="category" name="category" class="block mt-1 w-full">
                                <option value="not set" disabled selected>Select Category</option>
                                <option value="permanent">Permanent</option>
                                <option value="probation">Probation</option>
                                <option value="contract">Contract</option>
                                <option value="internship">Internship</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update User') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
