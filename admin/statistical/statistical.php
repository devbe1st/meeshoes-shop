
<main>
    <!-- /* -------------------------------- GET DATA -------------------------------- */ -->
    <?php 
    $db = require '../config/database.php';
    $statisticalController = new Statistical_Controller($db);
    ?>
    <!-- /* -------------------------------- GET DATA -------------------------------- */ -->
    <!-- Đơn hàng, người dùng, sản phẩm, doanh thu -->
    <div class="statistical">
        <div class="box-statis">
          <div class="ic-statis">
          <i class="fa-solid fa-money-bills" style="color: green;"></i>
          </div>
          <div class="statis-right">
            <div class="title-statis">
             Doanh thu
            </div>
            <div class="num-statis">
              <?php
              $total = $statisticalController->statiscalRevenue();
              echo ($total > 0) ? number_format($total) . ' VNĐ' : "0";
              ?>
            </div>
          </div>
        </div>
        <div class="box-statis">
          <div class="ic-statis">
            <i class="fa-solid fa-boxes-stacked"></i>
          </div>
          <div class="statis-right">
            <div class="title-statis">
              Đơn hàng
            </div>
            <div class="num-statis">
              <?= $statisticalController->statistical('orders') ?>
            </div>
          </div>
        </div>
        <div class="box-statis">
          <div class="ic-statis">
            <i class="fa-solid fa-comments" style="color: gray;"></i>
          </div>
          <div class="statis-right">
            <div class="title-statis">
              Đánh giá
            </div>
            <div class="num-statis">
              <?= $statisticalController->statistical('comments') ?>
            </div>
          </div>
        </div>
        <div class="box-statis">
          <div class="ic-statis">
            <i class="fa-solid fa-users"></i>
          </div>
          <div class="statis-right">
            <div class="title-statis">
              Người dùng
            </div>
            <div class="num-statis">
              <?= $statisticalController->statistical('users') ?>
            </div>
          </div>
        </div>
    </div>
</main>
<!-- /* --------------------------------- ORDER -------------------------------- */ -->
<canvas id="myChart"></canvas>
<div style="display: grid; grid-template-columns: repeat(2,1fr);">
  <div style="width: 500px; margin-top: 20px;"><canvas id="myPieChart"></canvas></div>
  <div style="width: 500px; margin-top: 20px;"><canvas id="myPieChart2"></canvas></div>
</div>
<canvas id="orders" width="400" height="400"></canvas>
<!-- /* ----------------------------- DOANH THU THẬT ----------------------------- */ -->
<script>
  const order = document.getElementById('orders');
  new Chart(order, {
    type: 'line',
    data: {
      labels: <?= json_encode($data['date']) ?>,
      datasets: [{
        label: 'Đơn hàng',
        fill: false,
        data: <?= json_encode($data['orderTotal']) ?>,
        borderWidth: 1,
        borderColor: 'rgba(75, 192, 192, 1)', // Màu sắc của đường
        pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Màu nền của điểm
        pointBorderColor: 'rgba(75, 192, 192, 1)', // Màu đường viền điểm
        pointRadius: 5, // Kích thước của điểm
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<!-- /* ----------------------------- DOANH THU THẬT ----------------------------- */ -->
<!-- /* ------------------------------- CHART LINE ------------------------------- */ -->
<script>
  // Dữ liệu giả định về doanh số bán hàng theo tháng
  const salesData = {
      labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
      datasets: [{
          label: 'Doanh số',
          data: [1000, 1200, 1500, 1700, 1600, 1800, 2000, 2100, 2300, 2500, 2700, 3000],
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
      }]
  };

  const config = {
      type: 'line',
      data: salesData,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: true,
                  text: 'Doanh số bán hàng theo tháng trong năm'
              },
              legend: {
                  display: true,
                  position: 'top'
              }
          },
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      },
  };

  var myChart = new Chart(
      document.getElementById('myChart'),
      config
  );
</script>
<!-- /* ------------------------------- CHART LINE ------------------------------- */ -->
<!-- /* -------------------------------- CHART PIE ------------------------------- */ -->
<script>
        // Dữ liệu giả định về phần trăm doanh số theo loại sản phẩm
        const salesDataPie = {
            labels: ['Giày cao gót MWC NUCG- G024', 'Giày thể thao nữ MWC NUTT- A149', 'Giày Thể Thao Nam MWC NATT- 5499', 'Giày sandal nam MWC NASD- 7080'],
            datasets: [{
                label: 'Phân phối sản phẩm',
                data: [40, 30, 20, 10],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ],
                hoverOffset: 4
            }]
        };

        const configPie = {
            type: 'pie',
            data: salesDataPie,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Phân phối doanh số theo loại sản phẩm'
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            },
        };

        var myPieChart = new Chart(
            document.getElementById('myPieChart'),
            configPie
        );
</script>
<!-- /* -------------------------------- CHART PIE ------------------------------- */ -->
<!-- /* -------------------------------- CHART PIE ------------------------------- */ -->
<script>
  // Dữ liệu giả định về phần trăm doanh số theo loại sản phẩm
  const salesDataPie2 = {
      labels: ['Giày thể thao nam', 'Giày thể thao nữ', 'Giày cao gót', 'OxFord & Boot Nữ', 'Giày tây & SlipOn'],
      datasets: [{
          label: 'Phân phối sản phẩm',
          data: [15, 20, 20, 35, 10],
          backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'green'
          ],
          hoverOffset: 4
      }]
  };

  const configPie2 = {
      type: 'pie',
      data: salesDataPie2,
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: true,
                  text: 'Phân phối doanh số theo danh mục sản phẩm'
              },
              legend: {
                  display: true,
                  position: 'top'
              }
          }
      },
  };

  var myPieChart2 = new Chart(
      document.getElementById('myPieChart2'),
      configPie2
  );
</script>
<!-- /* -------------------------------- CHART PIE ------------------------------- */ -->
<!-- /* --------------------------------- ORDER -------------------------------- */ -->
<br>
<!-- /* --------------------------------- REVENUE -------------------------------- */ -->
<canvas id="revenue"></canvas>
<script>
  const revenue = document.getElementById('revenue');
  new Chart(revenue, {
    type: 'line',
    data: {
      labels: <?= json_encode($data['date']) ?>,
      datasets: [{
        label: 'Doanh thu',
        fill: false,
        data: <?= json_encode($data['total']) ?>,
        borderWidth: 1,
        borderColor: 'green', // Màu sắc của đường
        pointBackgroundColor: 'green', // Màu nền của điểm
        pointBorderColor: 'green', // Màu đường viền điểm
        pointRadius: 5, // Kích thước của điểm
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<!-- /* --------------------------------- REVENUE -------------------------------- */ -->