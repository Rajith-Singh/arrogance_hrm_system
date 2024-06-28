<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-2xl font-semibold text-gray-800">
                            {{ __('Your Notifications') }}
                        </div>
                        <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mark all as read
                            </button>
                        </form>
                    </div>
                    <div class="mt-6">
                        <ul class="space-y-4">
                            @foreach ($notifications as $notification)
                                <li class="p-4 border rounded-lg @if(!$notification->read) bg-blue-50 border-blue-200 @else bg-white border-gray-200 @endif">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-700 @if(!$notification->read) font-bold @endif">
                                            {{ $notification->message }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
