<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Hệ Thống Quản Lý Phòng Khám Tư</title>

	    <!-- Custom styles for this page -->
	    <link href="vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
		
	    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	    <link rel="stylesheet" type="text/css" href="vendor/parsley/parsley.css"/>

	    <link rel="stylesheet" type="text/css" href="vendor/datepicker/bootstrap-datepicker.css"/>

	    <!-- Custom styles for this page -->
    	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	    <style>
	    	.border-top { border-top: 1px solid #e5e5e5; }
			.border-bottom { border-bottom: 1px solid #e5e5e5; }
			.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
			body {
				background-image: url('img/bg-1.jpg');
			}
	    </style>
	</head>
	<body>
		
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow ">
			<div>
			
			<a href="index.php"><img src="img/logo.jpg" alt="" style="height: 52px;"> </a>
			
		    </div>
				 
		    <?php
		    if(!isset($_SESSION['patient_id']))
		    {
		    ?>
			<div class="pricing-header mx-auto align-items-center ">
	      		<h1 class="display-5">Hệ Thống Quản Lý Phòng Khám Tư</h1>
	    	</div>
		    <!-- <div class="col text-right"><a href="login.php">Login</a></div> -->
			<div class="dropdown" > 
				<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Đăng nhập
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="login.php">Bệnh nhân</a>
					<a class="dropdown-item" href="admin/index2.php">Bác sĩ</a>
				</div>
			</div>
		   	<?php
		   	}
		   	?>
		    
	    </div>
		
		
	    <!-- <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center ">
	      	<h1 class="display-4">Online Doctor Appointment Management System</h1>
	    </div> -->
	    <br />
	    <br />
	    <div class="container-fluid">