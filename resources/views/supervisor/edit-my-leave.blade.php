<x-app-layout>
    <div class="flex">
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <!-- Directly include the edit-leave component here -->
                        @include('components.edit-leave', ['data' => $data, 'users' => $users])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


