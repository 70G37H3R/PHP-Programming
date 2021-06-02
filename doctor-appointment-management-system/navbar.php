	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  		<!-- Brand -->
  		<a class="navbar-brand" href="#"><?php echo $_SESSION['patient_name']; ?></a>

  		<!-- Links -->
	  	<ul class="navbar-nav">
	    	<li class="nav-item">
	      		<a class="nav-link" href="profile.php">Thông Tin Cá Nhân</a>
	    	</li>
	    	<li class="nav-item">
	      		<a class="nav-link" href="dashboard.php">Đặt Lịch Hẹn</a>
	    	</li>
	    	<li class="nav-item">
	      		<a class="nav-link" href="appointment.php">Xem Lịch Hẹn</a>
	    	</li>
			<li class="nav-item">
	      		<a class="nav-link" href="prescription.php">Xem Đơn Thuốc</a>
	    	</li>
	    	<li class="nav-item">
	      		<a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">Đăng Xuất</a>
	    	</li>
	  	</ul>
	</nav>