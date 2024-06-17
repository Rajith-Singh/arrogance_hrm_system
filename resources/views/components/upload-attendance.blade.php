<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }
    .drop-area {
        border: 2px dashed #007BFF;
        border-radius: 6px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.2s ease;
        margin-bottom: 20px;
    }
    .drop-area:hover {
        background-color: #e9f5ff;
    }
    .drop-area p {
        margin: 0;
        font-size: 16px;
        color: #333;
    }
    .file-input {
        display: none;
    }
    .file-preview {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    .file-preview img {
        max-width: 50px;
        margin-right: 10px;
    }
    .progress-bar {
        width: 100%;
        background-color: #f3f3f3;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 10px;
        display: none;
    }
    .progress-bar div {
        height: 20px;
        background-color: #007BFF;
        width: 0;
    }
    .security-info {
        margin-top: 20px;
    }
</style>


<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Upload Attendance CSV
    </h1>
</div>

    <div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                    @if ($errors->any())
                        <div style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('message'))
                        <div style="color: green;">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form action="/upload-attendance" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="mt-4">
                                <x-label for="date" value="{{ __('Date') }}" />
                                <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" />
                        </div>



                        <div class="drop-area mt-4" id="dropArea">
                            <p>Drag & Drop your CSV file here or Click to Upload</p>
                            <input type="file" name="attendance_file" id="attendance_file" class="file-input">
                        </div>
                        
                        <div class="file-preview" id="filePreview"></div>
                        <div class="progress-bar" id="progressBar">
                            <div></div>
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <x-button id="submitRequestButton" class="ml-4">
                                {{ __('Upload CSV') }}
                            </x-button>
                        </div>
                    </form>

                        <div class="mt-4">
                            <h5>Security Information</h5>
                            <p>User: {{ Auth::user()->name }}</p>
                            <p>IP Address: {{ request()->ip() }}</p>
                            <p>Date: <span id="date">{{ now()->toDateString() }}</span></p>
                            <p>Time: <span id="time">{{ now()->toTimeString() }}</span></p>
                            <p>Location: <span id="location">Fetching location...</span></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to get the current date and time in Sri Lankan time
    function getSriLankanDateTime() {
        const now = new Date();
        const options = { timeZone: 'Asia/Colombo', year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
        const formatter = new Intl.DateTimeFormat([], options);
        return formatter.format(now);
    }

    // Update date and time fields
    const sriLankanDateTime = getSriLankanDateTime();
    const [date, time] = sriLankanDateTime.split(', ');

    document.getElementById('date').innerText = date;
    document.getElementById('time').innerText = time;

    // Geolocation part
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    const address = data.address;
                    const locationParts = [
                        address.road || '',
                        address.neighbourhood || '',
                        address.suburb || '',
                        address.city || address.town || address.village || '',
                        address.state || '',
                        address.country || ''
                    ];

                    // Filter out empty parts and join with commas
                    const location = locationParts.filter(part => part).join(', ');

                    document.getElementById('location').innerText = location;
                })
                .catch(error => {
                    document.getElementById('location').innerText = 'Location not available';
                });
        }, function() {
            document.getElementById('location').innerText = 'Location not available';
        });
    } else {
        document.getElementById('location').innerText = 'Geolocation is not supported by this browser.';
    }

    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('attendance_file');
    const filePreview = document.getElementById('filePreview');
    const progressBar = document.getElementById('progressBar');
    const progressBarFill = progressBar.querySelector('div');

    dropArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropArea.style.backgroundColor = '#e9f5ff';
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.style.backgroundColor = '';
    });

    dropArea.addEventListener('drop', (event) => {
        event.preventDefault();
        dropArea.style.backgroundColor = '';
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            previewFile(files[0]);
        }
    });

    dropArea.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        if (files.length > 0) {
            previewFile(files[0]);
        }
    });

    function previewFile(file) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = () => {
            filePreview.innerHTML = `<img src="{{ asset('images/csv.png') }}" alt="File Preview"> <span>${file.name}</span>`;
        }
    }

    document.getElementById('uploadForm').addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(event.target);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/upload-attendance', true);

        xhr.upload.addEventListener('progress', (event) => {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressBarFill.style.width = percentComplete + '%';
                progressBar.style.display = 'block';
            }
        });

        xhr.addEventListener('load', () => {
            if (xhr.status === 200) {
                alert('File uploaded successfully!');
                progressBarFill.style.width = '0';
                progressBar.style.display = 'none';
            } else {
                alert('File upload failed. Please try again.');
            }
        });

        xhr.send(formData);
    });
});
</script>



