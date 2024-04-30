<!-- Popup Notification Component -->
<div id="notificationPopup" class="popup">
    <span class="close-btn" onclick="closePopup()">&times;</span>
    <p id="popupText"></p>
</div>

<style>
    .popup {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 300px;
        padding: 20px;
        background-color: #007bff; /* Default blue color */
        color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: none;
        z-index: 1000;
        animation: slideInDown 0.5s ease-out;
    }
    .popup.show {
        display: block;
    }
    .close-btn {
        float: right;
        cursor: pointer;
        color: #ffffff;
        font-weight: bold;
    }
    .popup.supervisor {
        background-color: #28a745; /* Green color */
    }
    .popup.management {
        background-color: #007bff; /* Blue color */
    }
</style>

<script>
    window.showPopup = function(message) {
        var popup = document.getElementById('notificationPopup');
        document.getElementById('popupText').textContent = message;

        // Determine popup color based on the message
        popup.className = 'popup'; // Reset classes
        if (message.includes('approved by supervisor')) {
            popup.classList.add('supervisor');
        } else if (message.includes('approved by management')) {
            popup.classList.add('management');
        }
        popup.classList.add('show');
    };

    window.closePopup = function() {
        var popup = document.getElementById('notificationPopup');
        popup.classList.remove('show');
    };
</script>

