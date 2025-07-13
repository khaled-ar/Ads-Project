<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استلام الجائزة</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .prize-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .prize-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .prize-icon {
            font-size: 4rem;
            color: #FDC101;
            margin-bottom: 20px;
        }
        .prize-title {
            color: #389FE2;
            font-weight: 700;
            font-size: 1.8rem;
        }
        .prize-form .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .submit-btn {
            background: linear-gradient(135deg, #FFFF00, #389FE2);
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="prize-container">
        <div class="prize-header">
            <i class="fas fa-gift prize-icon"></i>
            <h1 class="prize-title">مبروك! لقد ربحت معنا مبلغ {{ $story->prize_value }}</h1>
            @if (empty(session('success')) && empty(session('errors')))
            <p class="text-muted">يرجى ملء البيانات التالية لاستلام الجائزة</p>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success text-center py-3">
                {{ session('success') }}
            </div>
        @elseif (session('errors'))
            <div class="alert alert-error text-center py-3">
                {{ session('errors') }}
            </div>
        @else
            <form method="POST" action="{{ route('stories.prize-form-submit', $story) }}" class="prize-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="full_name" class="form-control" placeholder="الاسم الكامل" required>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="رقم الهاتف" required>
                </div>
                <button type="submit" class="btn submit-btn">
                    <i class="fas fa-check-circle"></i> تأكيد البيانات
                </button>
            </form>
        @endif

        <div class="text-center mt-4">
            <br>
            <a href="{{ url('/stories/all') }}" class="text-primary">
                <i class="fas fa-arrow-right"></i> العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </div>
</body>
</html>
