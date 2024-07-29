<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #666;
        }

        th {
            background-color: #555;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #666;
        }

        tbody tr:hover {
            background-color: #777;
        }

        .empty-cart {
            text-align: center;
            color: #ccc;
            margin-top: 20px;
        }

        .checkout-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .checkout-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>

        <?php
        session_start();

        include "./includes/conn.php"; 

        $user_id = $_SESSION['user_id'];
        $query = "SELECT *
        FROM cart
        INNER JOIN items ON cart.item_id = items.item_id";
        
        $query_run = mysqli_query($conn, $query);

        if (mysqli_num_rows($query_run) > 0) {
            echo '<form action="process_order_action.php" method="post">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Product</th>';
            echo '<th>Quantity</th>';
            echo '<th>Price</th>';
            echo '<th>Total</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = mysqli_fetch_assoc($query_run)) {
                // Assuming `item_name`, `item_price`, and `quantity` columns exist
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['qty']) . '</td>';
                echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                echo '<td>' . htmlspecialchars($row['price'] * $row['qty']) . '</td>';
                echo '</tr>';

                echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($_SESSION['user_id']) . '">';
                echo '<input type="hidden" name="item_id" value="' . htmlspecialchars($row['item_id']) . '">';
                echo '<input type="hidden" name="qty" value="' . htmlspecialchars($row['qty']) . '">';
            }

            echo '</tbody>';
            echo '</table>';
            echo '<button class="checkout-btn" type="submit">Proceed to Checkout</button>';
            echo '</form>';
        } else {
            echo '<p class="empty-cart">Your cart is empty.</p>';
        }
        ?>
    </div>
</body>
</html>
