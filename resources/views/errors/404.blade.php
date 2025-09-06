<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #01ffe1, #13a494);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }

        .shake-cup {
            width: 160px;
            animation: shake 1.5s infinite alternate;
        }

        .splash {
            width: 180px;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.4;
            animation: fadeInUp 2.5s ease-in-out;
        }

        @keyframes shake {
            0% { transform: rotate(-8deg); }
            100% { transform: rotate(8deg); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 0.4; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">

        <h1 class="display-4 text-light fw-bold">404 - Page Not Found</h1>
        <p class="lead text-white mb-4">Looks like your drink spilled on the wrong table...</p>

        <a href="{{ route('dashboard.welcome') }}" class="btn btn-primary btn-lg">Back to login</a>

        <img src="https://cdn-icons-png.flaticon.com/512/3456/3456478.png" alt="Spilled Drink" class="splash animate__animated animate__fadeInUp">
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
