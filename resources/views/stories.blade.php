<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعلانات خطوة</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/stories.css') }}">
</head>

<body>
    <div class="container-fluid stories-app">
        <h1 class="text-center my-4">شاهد واربح مع خطوة</h1>
        <br>
        <br>

        <!-- Stories Container -->
        <div class="stories-container">
            @foreach ($stories as $story)
                <div class="story-circle" data-story-id="{{ $story->id }}"
                    data-image-url="{{ $story->image_url }}"
                    data-prize-form-url="{{ route('stories.prize-form', $story->id) }}"
                    data-prize-value="{{ $story->prize_value }}">
                    <div class="story-border">
                        <div class="story-image-container">
                            <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="story-image">
                            <div class="gradient-overlay"></div>
                        </div>
                    </div>
                    <p class="story-username">{{ $story->title }}</p>
                    <div class="story-action-line"></div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/stories.js') }}"></script>
</body>

</html>
