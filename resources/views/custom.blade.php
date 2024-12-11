<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Call Buttons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">API Call Buttons</h2>

        <!-- Success Message -->
        @if (session('success'))
            <div id="successMessage" class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex gap-3">
            <a href="{{ route('save-products') }}" class="btn btn-success">Save CSV files data in DB</a>
        </div>
        <div class="d-flex gap-3 mt-3">
            <a href="{{ route('fetch-products', ['apiName' => 'Hanron API 1']) }}" class="btn btn-primary">Fetch Hanron
                API 1</a>
            <a href="{{ route('fetch-products', ['apiName' => 'Hanron API 2']) }}" class="btn btn-primary">Fetch Hanron
                API 2</a>
            <a href="{{ route('fetch-products', ['apiName' => 'Hanron API 3']) }}" class="btn btn-primary">Fetch Hanron
                API 3</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Automatically hide success message after 2 seconds and remove it from the DOM
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.remove(); // Remove the element from the DOM
                }
            }, 2000); // 2 seconds
        });
    </script>
</body>

</html>
