<?php 
session_start(); 
include 'db.php'; 

// ... Operasional lainnya ...
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">
    <h2>Dashboard</h2>

    <!-- Button to manage barang -->
    <a href="manajemen_barang.php" class="btn btn-primary">Manajemen Barang</a>

    <!-- Button Logout -->
    <?php if(isset($_SESSION['loggedin'])){ ?>
      <a href="logout.php" onclick="logout()" class="btn btn-secondary ml-auto">Logout</a>
     <?php } ?>

</div>


<!-- Script untuk proses logout -->

<script>
function logout() {  
  window.location.href = 'logout.php';
}  

// Bootstrap JS and dependencies 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> 
<script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> 
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body></html>

<?php $conn->close();?> 


