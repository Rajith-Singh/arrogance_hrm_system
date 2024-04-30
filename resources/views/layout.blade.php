<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <!-- Include any CSS or scripts here -->
</head>
<body>
    @include('header') <!-- Include header -->

    <div class="content">
        @yield('content') <!-- Content section -->
    </div>

    @include('footer') <!-- Include footer -->

    <!-- Include any additional scripts here -->
</body>
</html>
