<?php
// Bắt đầu phiên làm việc
session_start();

// Kiểm tra xem có phiên làm việc của người dùng đã được xác định hay không
if (!isset($_SESSION['admin_id'])) {
    // Nếu không, chuyển hướng người dùng đến trang đăng nhập
    header('Location: admin_login.php');
    exit; // Dừng script
}

// Kiểm tra xem có tham số orderId được truyền qua URL hay không
if (!isset($_GET['order_id'])) {
    // Nếu không, chuyển hướng người dùng về trang quản lý đơn hàng
    header('Location: admin_orders.php');
    exit; // Dừng script
}

// Kết nối tới cơ sở dữ liệu
include 'config.php';

// Lấy orderId từ URL
$order_id = $_GET['order_id'];

// Truy vấn cơ sở dữ liệu để lấy thông tin của đơn hàng
$select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
$select_order->execute([$order_id]);
$order = $select_order->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem đơn hàng có tồn tại không
if (!$order) {
    // Nếu không, chuyển hướng người dùng về trang quản lý đơn hàng
    header('Location: admin_orders.php');
    exit; // Dừng script
}

// In hóa đơn (ở đây chỉ là ví dụ, bạn cần thay đổi để phù hợp với cách hoạt động của bạn)
echo "<h2>Order Details</h2>";
echo "<p>Order ID: " . $order['id'] . "</p>";
echo "<p>Placed On: " . $order['placed_on'] . "</p>";
echo "<p>Name: " . $order['name'] . "</p>";
echo "<p>Name: " . $order['total_products'] . "</p>";
echo "<p>Name: " . $order['total_price'] . "</p>";

// Các thông tin khác về đơn hàng ...

// Đóng kết nối tới cơ sở dữ liệu
$conn = null;
?>
