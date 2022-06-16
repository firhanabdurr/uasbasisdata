<?php
$servername = "mariadb10";
$username = "root";
$password = "1234";
$dbname = "w3schools";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//query table 
$sql = "select * from customers";
$result_table = $conn->query($sql);

// query tabel soal no1
$sql = "SELECT orderDate, COUNT(orderID) AS Total_Order FROM orders
WHERE orderDate
BETWEEN '1996-07-04' AND  '1997-01-01'
GROUP BY CAST(YEAR(orderDate) AS VARCHAR(4)) + '-' + right('00' + CAST(MONTH(orderDate) AS VARCHAR(2)), 2);";
$result_table1 = $conn->query($sql);

// query tabel soal no2
$sql = "SELECT CONCAT(MONTH(orderDate), '/', WEEK(orderDate)) as Tanggal, COUNT(orderID) as totalOrderMinggu
FROM orders
WHERE orderDate
BETWEEN '1996-07-01' AND '1996-07-30'
GROUP BY CONCAT(MONTH(orderDate), '/', WEEK(orderDate));";
$result_table2 = $conn->query($sql);

// query tabel soal no3
$sql = "SELECT orderDate, products.ProductID, products.ProductName, quantity FROM orders
LEFT JOIN order_details
ON orders.OrderID = order_details.OrderID
LEFT JOIN products
ON order_details.ProductID = products.ProductID
WHERE orderDate = '1996-07-04'
GROUP BY products.ProductID
ORDER BY quantity DESC
LIMIT 10;";
$result_table3 = $conn->query($sql);

// query tabel soal no4
$sql = "SELECT orderDate, products.ProductID, products.ProductName, sum(quantity) FROM orders
LEFT JOIN order_details
ON orders.OrderID = order_details.OrderID
LEFT JOIN products
ON order_details.ProductID = products.ProductID
WHERE orderDate BETWEEN '1996-07-01' AND '1996-07-30'
GROUP BY products.ProductID
ORDER BY sum(quantity) DESC
LIMIT 10;";
$result_table4 = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - 1207050040</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Firhan Abdurrahman</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    firhan
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>

                <!-- main content -->
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol>

                    <!-- tabel customer -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Customers
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Postal Code</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($result_table->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result_table->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["CustomerID"]; ?></td>
                                                <td><?php echo $row["CustomerName"]; ?></td>
                                                <td><?php echo $row["ContactName"]; ?></td>
                                                <td><?php echo $row["Address"]; ?></td>
                                                <td><?php echo $row["City"]; ?></td>
                                                <td><?php echo $row["PostalCode"]; ?></td>
                                                <td><?php echo $row["Country"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- tabel soal 1 -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            1.Laporan Order/Penjualan Per Bulan dalam Tahun
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>orderDate</th>
                                        <th>Total_Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($result_table1->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result_table1->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["orderDate"]; ?></td>
                                                <td><?php echo $row["Total_Order"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- tabel soal 2 -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            2.Laporan Order/Penjualan Per Minggu Dalam Bulan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>totalOrderMinggu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($result_table2->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result_table2->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["Tanggal"]; ?></td>
                                                <td><?php echo $row["totalOrderMinggu"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- tabel soal 3 -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            3.Laporan penjualan 3 produk terlaris Per Hari/Pertanggal
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>orderDate</th>
                                        <th>ProductID</th>
                                        <th>ProductName</th>
                                        <th>quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($result_table3->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result_table3->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["orderDate"]; ?></td>
                                                <td><?php echo $row["ProductID"]; ?></td>
                                                <td><?php echo $row["ProductName"]; ?></td>
                                                <td><?php echo $row["quantity"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- tabel soal 4 -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            4.Laporan penjualan 10 produk terlaris Per Bulan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>orderDate</th>
                                        <th>ProductID</th>
                                        <th>ProductName</th>
                                        <th>quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($result_table4->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result_table4->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["orderDate"]; ?></td>
                                                <td><?php echo $row["ProductID"]; ?></td>
                                                <td><?php echo $row["ProductName"]; ?></td>
                                                <td><?php echo $row["sum(quantity)"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; UAS BasisData 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>