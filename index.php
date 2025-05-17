<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetra - Redirecting</title>
    <meta http-equiv="refresh" content="0; URL=src/pages/home.php">
    <link rel="stylesheet" href="public/assets/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        a {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Redirecting to Tetra...</h1>
    <p>If you are not redirected automatically, <a href="src/pages/home.php">click here</a>.</p>
   
    <script>
        // Redirect with JavaScript as fallback
        window.location.href = "src/pages/home.php";
    </script>
</body>
</html>