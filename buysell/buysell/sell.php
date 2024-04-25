<!DOCTYPE html>
<html>
<head>
    <title>Sell Products</title>
    <style>
        /* Center the form */
        .centered-form {
            text-align: center;
            margin: 0 auto;
            width: 50%;
            background: #f5f5f5;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin: 0;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #2a7aaf;
        }

        .product-list {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            flex-basis: calc(33.33% - 20px);
        }

        .product h2 {
            color: #3498db;
            font-size: 1.2em;
        }

        .product p {
            color: #333;
        }

        .product img {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
        }

        .product a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .product a:hover {
            text-decoration: underline;
        }

        #delete-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Sell Products</h1>
    <div class="centered-form">
        <h2>Add a New Product</h2>
        <form method="post" action="sell.php" enctype="multipart/form-data" onsubmit="return showAlerts()">
            <label for="title">Title:</label>
            <input type="text" name="title" required><br>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea><br>
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required><br>
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/*" required><br>
            <input type="submit" value="Submit">
        </form>
    </div>

    <div class="product-list">
        <?php
        // Database connection
        $conn = new mysqli("localhost", "root", "", "sell_products");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Process form submissions
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $category = 'sell'; // Assuming all products added here are for selling

            // Handle image upload
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "<script>alert('The image file has been uploaded.');</script>";
            } else {
                echo "<script>alert('Error uploading image file.');</script>";
            }

            // Insert the new product into the database
            $sql = "INSERT INTO products (title, description, price, category, image) VALUES ('$title', '$description', $price, '$category', '$targetFile')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Product added successfully.');</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
            }
        }

        // Delete products
        if (isset($_GET['delete'])) {
            $productId = $_GET['delete'];
            $sql = "DELETE FROM products WHERE id = $productId";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Product deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error deleting product: " . $conn->error . "');</script>";
            }
        }

        // Display existing products
        $sql = "SELECT * FROM products WHERE category='sell'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>Description: " . $row["description"] . "</p>";
                echo "<p>Price: $" . $row["price"] . "</p>";
                echo "<img src='" . $row["image"] . "' alt='Product Image'>";
                echo "<a href='sell.php?delete=" . $row["id"] . "'>Delete</a>";
                echo "</div>";
            }
        } else {
            echo "No products available for selling.";
        }

        $conn->close();
        ?>
    </div>
    <script>
        function showAlerts() {
            // Confirm before form submission
            if (confirm('Are you sure you want to submit this form?')) {
                return true;
            }
            return false;
        }
    </script>
</body>
</html>
