<!DOCTYPE html>
<html>
<head>
    <title>OLX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        p {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: center;
            margin-top: 30px;
        }

        li {
            display: inline-block;
            margin: 10px;
        }

        a {
            text-decoration: none;
            color: #3498db;
            background-color: #fff;
            padding: 10px 20px;
            border: 2px solid #3498db;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>OLX</h1>
    <p>Select a category:</p>
    <ul>
        <li><a href="products.php?category=car">Car</a></li>
        <li><a href="products.php?category=bike">Bike</a></li>
        <li><a href="products.php?category=mobile">Mobile</a></li>
        <!-- Add more category links as needed -->
    </ul>
</body>
</html>
