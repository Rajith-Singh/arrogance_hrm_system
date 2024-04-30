<x-app-layout>
    <meta name="user-id" content="{{ auth()->user()->id }}">

        <!-- Linking CSS style -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/popup.css') }}">
        
        <div class="flex">

        <x-user-sidebar />
       

        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        @if (isset($remainingLeaves) && !empty($remainingLeaves))
                            @include('components.user-dashboard', ['remainingLeaves' => $remainingLeaves])
                        @else
                            <p>No remaining leaves data available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="notificationPopup" class="popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <p id="popupText">Your leave request has been approved!</p>
    </div>

    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userId = document.querySelector('meta[name="user-id"]').content;
            const socket = io('http://localhost:3000', { query: { userId: userId } });

            socket.on('notification', function(data) {
                showPopup(data);
                playNotificationSound(); // Call function to play notification sound
            });

            function showPopup(message) {
                var popup = document.getElementById('notificationPopup');
                document.getElementById('popupText').textContent = message;
                // Check if the message indicates supervisor approval
                if (message.includes('approved by supervisor')) {
                    popup.classList.add('supervisor'); // Apply supervisor class for green color
                } else if (message.includes('approved by management')) {
                    popup.classList.add('management'); // Apply management class for blue color
                } else {
                    popup.classList.remove('supervisor', 'management'); // Remove classes for default color
                }
                popup.classList.add('show');
            }

            window.closePopup = function() {
                var popup = document.getElementById('notificationPopup');
                popup.classList.remove('show');
            }

            function playNotificationSound() {
                // Create an audio element for notification sound
                var audio = new Audio('/audio/notification-sound.mp3');
                audio.play();
            }
        });
    </script>
</x-app-layout>
