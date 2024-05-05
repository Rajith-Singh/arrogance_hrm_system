<!-- resources/views/mgt-leave.blade.php -->

<x-app-layout>
    <div class="flex">
        <x-management-sidebar />

        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        {!! $viewMgtUsers !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
