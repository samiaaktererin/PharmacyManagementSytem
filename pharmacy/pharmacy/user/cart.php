<?php
session_start();
include 'db.php';

if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "<div style='
            font-family:Arial, sans-serif;
            text-align:center;
            margin-top:100px;
            color:#333;'>
            <h2 style='font-size:28px;'>🛒 Your Cart is Empty</h2>
            <p style='font-size:18px;'>Looks like you haven’t added anything yet.</p>
            <p><a href='shop.php' style='
                color:#007bff;
                font-weight:bold;
                text-decoration:none;
                font-size:18px;'>🛍 Continue Shopping</a></p>
          </div>";
    exit();
}

$total = 0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    $uid = $_SESSION['user_id'];
    $payment = $_POST['payment_method'];
    $conn->query("INSERT INTO orders (user_id, total, payment_method, order_date) VALUES ($uid,0,'$payment',NOW())");
    $order_id = $conn->insert_id;

    foreach($_SESSION['cart'] as $id=>$qty){
        $res = $conn->query("SELECT * FROM medicines WHERE id=$id");
        $m = $res->fetch_assoc();
        $price = $m['selling_price'];
        $total += $price*$qty;

        $conn->query("INSERT INTO order_items (order_id, medicine_id, quantity, price) 
                      VALUES ($order_id,$id,$qty,$price)");

        $conn->query("UPDATE medicines SET quantity=quantity-$qty WHERE id=$id");
    }

    $conn->query("UPDATE orders SET total=$total WHERE id=$order_id");
    $_SESSION['cart'] = [];

    echo "<div style='
            font-family:Arial, sans-serif;
            text-align:center;
            margin-top:100px;
            color:#333;'>
            <h2 style='color:#28a745;'>✅ Order Placed Successfully!</h2>
            <p style='font-size:18px;'>Total Amount: <b style='color:#28a745;'>৳ ".number_format($total,2)."</b></p>
            <p style='font-size:18px;'>Payment Method: <b>$payment</b></p>
            <a href='shop.php' style='
                display:inline-block;
                margin-top:20px;
                padding:12px 25px;
                background:#007bff;
                color:white;
                border-radius:6px;
                text-decoration:none;
                font-weight:bold;
                font-size:16px;'>🛍 Continue Shopping</a>
          </div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background:#f4f6f9; 
            margin:0; 
            padding:0; 
        }
        .container { 
            width:85%; 
            max-width:1000px; 
            margin:40px auto; 
            background:white; 
            padding:30px; 
            border-radius:12px; 
            box-shadow:0 4px 12px rgba(0,0,0,0.1); 
        }
        h2 { 
            color:#007bff; 
            margin-bottom:20px; 
            text-align:center; 
            font-size:28px;
        }
        table { 
            width:100%; 
            border-collapse: collapse; 
            margin-bottom:20px; 
            font-size:16px;
        }
        th, td { 
            padding:14px; 
            text-align:center; 
            border-bottom:1px solid #eaeaea; 
        }
        th { 
            background:#007bff; 
            color:white; 
            font-weight:bold;
        }
        tr:hover td { background:#f9f9f9; }
        .total-row { 
            font-weight:bold; 
            background:#f1f1f1; 
            font-size:18px;
        }
        .payment { 
            margin:25px 0; 
            font-size:18px;
        }
        .payment label { 
            display:block; 
            margin:10px 0; 
            cursor:pointer;
        }
        .btn { 
            padding:14px 24px; 
            background:#28a745; 
            color:white; 
            border:none; 
            border-radius:8px; 
            cursor:pointer; 
            font-size:18px; 
            font-weight:bold; 
            transition:0.3s;
            display:block;
            width:100%;
            max-width:300px;
            margin:0 auto;
        }
        .btn:hover { background:#218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>🛒 Your Shopping Cart</h2>
    <form method="POST">
        <table>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php
            foreach($_SESSION['cart'] as $id=>$qty){
                $res = $conn->query("SELECT * FROM medicines WHERE id=$id");
                $m = $res->fetch_assoc();
                $price = $m['selling_price'];
                $line = $price*$qty;
                $total += $line;
                echo "<tr>
                        <td>{$m['name']}</td>
                        <td>$qty</td>
                        <td>৳ ".number_format($price,2)."</td>
                        <td>৳ ".number_format($line,2)."</td>
                      </tr>";
            }
            ?>
            <tr class="total-row">
                <td colspan="3">Grand Total</td>
                <td>৳ <?= number_format($total,2) ?></td>
            </tr>
        </table>

        <!-- Payment Method -->
        <div class="payment">
            <h3>Select Payment Method:</h3>
            <label><input type="radio" name="payment_method" value="Cash on Delivery" checked> 🚚 Cash on Delivery</label>
            <label><input type="radio" name="payment_method" value="bKash"> 📱 bKash</label>
            <label><input type="radio" name="payment_method" value="Nagad"> 💳 Nagad</label>
            <label><input type="radio" name="payment_method" value="Card Payment"> 💳 Card Payment</label>
        </div>

        <button type="submit" class="btn">✅ Confirm Order</button>
    </form>
</div>

</body>
</html>
