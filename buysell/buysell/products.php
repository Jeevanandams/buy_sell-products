<!DOCTYPE html>
<html>
<head>
    <title>OLX Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .product {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .product h3 {
            color: #3498db;
        }

        .product p {
            color: #333;
        }

        .product img {
            max-width: 300px;
            max-height: 300px;
            margin-top: 10px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2a7aaf;
        }

        #cart {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-top: 20px;
        }

        #cart h2 {
            color: #3498db;
        }

        #cart-items {
            list-style: none;
            padding: 0;
        }

        #cart-items li {
            color: #333;
            margin: 5px 0;
        }

        #checkout-form {
            display: none;
            margin-top: 20px;
        }

        #checkout-form h2 {
            color: #3498db;
        }

        label {
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #checkout-form button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #checkout-form button:hover {
            background-color: #2a7aaf;
        }
    </style>
</head>
<body>
    <h1>OLX Products</h1>
    <div class="container">
        <?php
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            echo "<h2>Products in the $category category:</h2>";

            // Database connection
            $conn = new mysqli("localhost", "root", "", "olx_db");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to retrieve products and owner details for the selected category
            $sql = "SELECT p.*, o.owner_name, o.owner_email, o.owner_phone FROM products p
                    INNER JOIN owners o ON p.owner_id = o.owner_id
                    WHERE p.category = '$category'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<h3>" . $row["title"] . "</h3>";
                    echo "<p>Description: " . $row["description"] . "</p>";
                    echo "<p>Price: $" . $row["price"] . "</p>";

                    // Display the product image
                    echo "<img src='" . $row["image"] . "' alt='" . $row["title"] . "' />";

                    // Add a "Contact Owner" button
                    echo "<div class='btn-container'>";
                    echo "<button onclick=\"displayContactDetails('{$row["owner_name"]}', '{$row["owner_email"]}', '{$row["owner_phone"]}')\" class='btn'>Contact Owner</button>";

                    // Add a "Buy" button to add the product to the cart
                    echo "<button onclick=\"addToCart('{$row["product_id"]}', '{$row["title"]}', '{$row["price"]}')\" class='btn'>Buy</button>";
                    echo "</div>";  // Close btn-container
                    echo "</div>";  // Close product
                }
            } else {
                echo "No products available in this category.";
            }

            $conn->close();
        } else {
            echo "<p>No category selected.</p>";
        }
        ?>
    </div>

    <!-- Shopping Cart Section -->
    <div id="cart">
        <h2>Shopping Cart</h2>
        <ul id="cart-items">
            <!-- Cart items will be displayed here -->
        </ul>
        <button onclick="checkout()">Checkout</button>
    </div>

    <!-- Checkout Form (hidden by default) -->
    <div id="checkout-form">
        <h2>Checkout</h2>
        <label for="name">Name: </label>
        <input type="text" id="name" required><br>
        <label for="email">Email: </label>
        <input type="email" id="email" required><br>
        <label for="phone">Phone: </label>
        <input type="tel" id="phone" required><br>
        <button onclick="confirmOrder()">Confirm Order</button>
    </div>

    <script>
        let cartItems = [];

        function addToCart(productID, productName, productPrice) {
            cartItems.push({ id: productID, name: productName, price: productPrice });
            updateCartDisplay();
        }

        function updateCartDisplay() {
            const cartList = document.getElementById("cart-items");
            cartList.innerHTML = "";

            let total = 0;

            for (const item of cartItems) {
                const listItem = document.createElement("li");
                listItem.textContent = `${item.name} - $${item.price}`;
                cartList.appendChild(listItem);
                total += parseFloat(item.price);
            }

            if (cartItems.length > 0) {
                document.getElementById("checkout-form").style.display = "block";
            }

            alert(`Product added to cart. Total: $${total.toFixed(2)}`);
        }

        function checkout() {
            document.getElementById("checkout-form").style.display = "block";
        }

        function confirmOrder() {
            // Implement order confirmation and processing here.
            // You can use JavaScript to collect user details from the form and send them to a backend for order processing.

            // Clear the cart after the order is confirmed.
            cartItems = [];
            updateCartDisplay();

            alert("Order confirmed. Thank you for your purchase!");
        }

        function displayContactDetails(ownerName, ownerEmail, ownerPhone) {
            alert("Contact Owner Details:\n\nName: " + ownerName + "\nEmail: " + ownerEmail + "\nPhone: " + ownerPhone);
        }
    </script>
</body>
</html>
