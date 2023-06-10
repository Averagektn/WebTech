<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $_SESSION['cart'][$product_id] = $quantity;

    setcookie('cart', serialize($_SESSION['cart']), time() + (86400), '/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    setcookie('cart', '', time() - 3600, '/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    unset($_SESSION['cart']);
    setcookie('cart', '', time() - 3600, '/');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
</head>
<body>
<h1>Shop</h1>
<h2>Items</h2>
<?php if (!empty($_SESSION['cart'])): ?>
    <ul>
        <?php foreach ($_SESSION['cart'] as $product_id => $quantity): ?>
            <li>Item #<?php echo $product_id; ?>: <?php echo $quantity; ?> шт.</li>
        <?php endforeach; ?>
    </ul>
    <form action="" method="post">
        <input type="submit" name="checkout" value="Order">
        <input type="submit" name="clear_cart" value="Clear">
    </form>
<?php else: ?>
    <p>Empty.</p>
<?php endif; ?>
<h2>Items</h2>
<ul>
    <li>Item #1
        <form action="" method="post">
            <input type="hidden" name="product_id" value="1">
            <label>Number: <input type="number" name="quantity" value="1"></label>
            <input type="submit" name="add_to_cart" value="Add">
        </form>
    </li>
    <li>Item #2
        <form action="" method="post">
            <input type="hidden" name="product_id" value="2">
            <label>Number: <input type="number" name="quantity" value="1"></label>
            <input type="submit" name="add_to_cart" value="Add">
        </form>
    </li>
    <li>Item #3
        <form action="" method="post">
            <input type="hidden" name="product_id" value="3">
            <label>Number: <input type="number" name="quantity" value="1"></label>
            <input type="submit" name="add_to_cart" value="Add">
        </form>
    </li>
</ul>
</body>
</html>