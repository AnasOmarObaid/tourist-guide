<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Unauthorized</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css for fade-in effect -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background: linear-gradient(to right, #01ffe1, #13a494);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }

        .drink {
            width: 200px;
            animation: shake 2s infinite alternate;
        }

        @keyframes shake {
            0% { transform: rotate(-10deg); }
            100% { transform: rotate(10deg); }
        }

        .spilled {
            width: 180px;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.5;
            animation: fadeIn 3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 0.5; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        {{-- <img src="{{ asset('images/drinks.svg') }}" alt="Spilled Drink"
             class="drink mb-4 animate__animated animate__bounceInDown"> --}}

        <h1 class="display-4 text-danger fw-bold">403 Unauthorized</h1>
        <p class="lead mb-4">Oops! You don't have permission to access this page.</p>

        <a href="{{ route('dashboard.auth.login') }}" class="btn btn-danger btn-lg">Back to Login</a>

        <img src="https://cdn-icons-png.flaticon.com/512/3456/3456478.png" alt="Spill"
             class="spilled animate__animated animate__fadeInUp">
    </div>

    <!-- Bootstrap Bundle JS (for animations, if needed later) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
