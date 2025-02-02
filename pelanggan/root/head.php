<?php session_start();

// Memeriksa apakah session ID pelanggan ada dan telah berhasil login
if (isset($_SESSION['id_pelanggan']) && isset($_SESSION['nama_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $nama_pelanggan = $_SESSION['nama_pelanggan'];
} else {
    // Jika tidak ada session, arahkan ke halaman login
    header("Location: ../index.php");
    exit();
}
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hartono collection</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/LOGO.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.0/echarts.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
  <style>
    .button-buy {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 10px;
    }

    .button-container {
        display: flex;
    }

    .favorite-btn,
    .cart-btn {
        background: none;
        border: none;
        padding: 0;
        font-size: 24px;
        cursor: pointer;
        margin: 0 5px;
    }

    .favorite-btn {
        color: #f8d61e;
    }

    .cart-btn {
        color: #5f8cd9;
    }

    .favorite-btn:disabled {
        color: #ccc;
        cursor: not-allowed;
    }
</style>



</head>