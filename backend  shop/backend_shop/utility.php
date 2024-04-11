<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:admin_orders.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Restaurant Utility</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom admin style link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      .chart-container {
         border: 1px solid black;
         /* Thiết lập đường viền cho biểu đồ */
         border-radius: 20px;
         /* Làm tròn góc cho biểu đồ */
         overflow: hidden;
         /* Đảm bảo các phần tử bên trong không vượt ra ngoài phần border-radius */
         display: flex;
      }

      .chart {
         display: flex;
         gap: 20px;
         margin-bottom: 20px;
      }
   </style>

   <head>
      <!-- Các thẻ meta và tiêu đề khác -->
   </head>



   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load("current", {
         packages: ["corechart"]
      });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
         var data = google.visualization.arrayToDataTable([
            ["Element", "Density", {
               role: "style"
            }],
            ["Gas", 8.94, "light blue"],
            ["Waste", 10.49, "blue"],
            ["Customer Number", 19.30, "gold"],
            ["Drink Water", 21.45, "green"]
         ]);

         var view = new google.visualization.DataView(data);
         view.setColumns([0, 1,
            {
               calc: "stringify",
               sourceColumn: 1,
               type: "string",
               role: "annotation"
            },
            2
         ]);

         // Mảng chứa thông tin của các biểu đồ
         var charts = [{
               id: "barchart_values",
               title: "Table 1"
            },
            {
               id: "barchart_values1",
               title: "Table 2"
            },
            // Thêm các thông tin của các biểu đồ khác vào đây nếu cần
         ];

         // Vòng lặp để vẽ từng biểu đồ và đặt tên
         charts.forEach(function(chartInfo) {
            var options = {
               title: chartInfo.title,
               width: 300,
               height: 200,
               bar: {
                  groupWidth: "95%"
               },
               legend: {
                  position: "none"
               },
            };

            var chart = new google.visualization.BarChart(document.getElementById(chartInfo.id));
            chart.draw(view, options);
         });
      }
   </script>


</head>

<body>

   <?php include 'admin_header.php' ?>

   <section class="orders">

      <h1 class="heading">Utility System</h1>

      <div class="">
         <div class="chart">
            <div class="chart-container" id="barchart_values" style="width: 300px !important; height: 200px !important;"></div>
            <div class="chart-container" id="barchart_values1" style="width: 300px !important; height: 200px !important;"></div>
            <div class="chart-container" id="barchart_values2" style="width: 300px !important; height: 200px !important;"></div>
            <div class="chart-container" id="barchart_values3" style="width: 300px !important; height: 200px !important;"></div>

         </div>
         <div class="chart">
            <div class="chart-container" id="barchart_values4" style="width: 300px !important; height: 250px !important;"></div>
            <div class="chart-container" id="barchart_values5" style="width: 300px !important; height: 250px !important;"></div>
            <div class="chart-container" id="barchart_values6" style="width: 300px !important; height: 250px !important;"></div>
            <div class="chart-container" id="barchart_values7" style="width: 300px !important; height: 250px !important;"></div>


         </div>
      </div>
   </section>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>


<?php

$api_key = '163a4b52fa85160929d33e5e459b79ae'; // Thay YOUR_API_KEY bằng API key của bạn
$city = 'ho chi minh City'; // Thay London bằng tên thành phố bạn muốn lấy dữ liệu

$api_url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $api_key . '&units=metric';

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => 'GET',
]);

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true);

if ($data && isset($data['main']['temp'])) {
    $temperature = $data['main']['temp'];
    echo 'Nhiệt độ ở ' . $city . ' là ' . $temperature . '°C';
} else {
    echo 'Không thể lấy dữ liệu nhiệt độ!';
}
?>

</html>