<!DOCTYPE html>
<html>
<head>
    <title>Used Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://tse3.mm.bing.net/th?id=OIP.BK-th3JLoO0FgUT7gdGfogHaG2&pid=Api&P=0&h=180');
            background-size: 50% 50%;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center; /* Centered both horizontally and vertically */
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: rgba(52, 152, 219, 0.7);
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            background-color: rgba(52, 152, 219, 0.9);
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>
    <h1>Used Products</h1>
    <div class="container">
        <div class="btn-container">
            <form action="buy.php">
                <button class="btn" type="submit">Buy Products</button>
            </form>
            <form action="sell.php">
                <button class="btn" type="submit">Sell Products</button>
            </form>
        </div>
    </div>
</body>
</html>
