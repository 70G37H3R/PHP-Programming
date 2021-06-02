<?php

//profile.php



include('class/Appointment.php');

$object = new Appointment;

$object->query = "
SELECT * FROM patient_table 
WHERE patient_id = '".$_SESSION["patient_id"]."'
";

$result = $object->get_result();

include('header.php');

?>

<div class="container-fluid">
	<?php include('navbar.php'); ?>

	<div class="row justify-content-md-center">
		<div class="col col-md-6">
			<br />
			<?php
			if(isset($_GET['action']) && $_GET['action'] == 'edit')
			{
			?>
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							<b>Chỉnh Sửa Thông Tin Chi Tiết</b>
						</div>
						<div class="col-md-6 text-right">
							<a href="profile.php" class="btn btn-primary btn-sm">Hủy</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" id="edit_profile_form">
						<div class="form-group">
							<label>Tài Khoản (Email)</span></label>
							<input type="text" name="patient_email_address" id="patient_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" readonly />
						</div>
						<div class="form-group">
							<label>Mật Khẩu<span class="text-danger">*</span></label>
							<input type="password" name="patient_password" id="patient_password" class="form-control" required  data-parsley-trigger="keyup" />
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Họ<span class="text-danger">*</span></label>
									<input type="text" name="patient_first_name" id="patient_first_name" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Tên<span class="text-danger">*</span></label>
									<input type="text" name="patient_last_name" id="patient_last_name" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Ngày Tháng Năm Sinh<span class="text-danger">*</span></label>
									<input type="text" name="patient_date_of_birth" id="patient_date_of_birth" class="form-control" required  data-parsley-trigger="keyup" readonly />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Giới Tính<span class="text-danger">*</span></label>
									<select name="patient_gender" id="patient_gender" class="form-control">
										<option value="Nam">Nam </option>
										<option value="Nữ">Nữ</option>
										<option value="Khác">Khác</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>SĐT Liên Lạc<span class="text-danger">*</span></label>
									<input type="text" name="patient_phone_no" id="patient_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Nhóm Máu<span class="text-danger">*</span></label>
									<select name="patient_blood" id="patient_blood" class="form-control">
										<option value="A">A</option>
										<option value="B">B</option>
										<option value="O">O</option>
										<option value="O">AB</option>
									</select>
								</div>
							</div>

						</div>	
						<div class="row">
							<div class="col-md-6">
							
								
									<div class="form-group">
										<label>Chiều Cao<span class="text-danger">*</span></label>
										<input type="text" name="patient_height" id="patient_height" class="form-control" required  data-parsley-trigger="keyup" />
									</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
									<div class="form-group">
										<label>Cân Nặng<span class="text-danger">*</span></label>
										<input type="text" name="patient_weight" id="patient_weight" class="form-control" required  data-parsley-trigger="keyup" />
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Địa Chỉ Liên Lạc<span class="text-danger">*</span></label>
							<textarea name="patient_address" id="patient_address" class="form-control" required data-parsley-trigger="keyup"></textarea>
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="edit_profile" />
							<input type="submit" name="edit_profile_button" id="edit_profile_button" class="btn btn-success" value="Lưu" />
						</div>
					</form>
				</div>
			</div>

			<br />
			<br />
			

			<?php
			}
			else
			{

				if(isset($_SESSION['success_message']))
				{
					echo $_SESSION['success_message'];
					unset($_SESSION['success_message']);
				}
			?>

			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							<b>Thông Tin Chi Tiết</b> 
						</div>
						<div class="col-md-6 text-right">
							<a href="profile.php?action=edit" class="btn btn-success btn-sm">Chỉnh Sửa</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<?php
						foreach($result as $row)
						{
						?>
						<tr>
							<th class="text-left" width="40%">Họ & Tên Đầy Đủ</th>
							<td><?php echo $row["patient_first_name"] . ' ' . $row["patient_last_name"]; ?></td>
						</tr>
						<tr>
							<th class="text-left" width="40%">Tài Khoản (Email)</th>
							<td><?php echo $row["patient_email_address"]; ?></td>
						</tr>
						<tr>
							<th class="text-left" width="40%">Mật khẩu</th>
							<td><?php echo $row["patient_password"]; ?></td>
						</tr>
						<tr>
							<th class="text-left" width="40%">Địa Chỉ Liên Lạc</th>
							<td><?php echo $row["patient_address"]; ?></td>
						</tr>
						<tr>
							<th class="text-left" width="40%">Số Điện Thoại Liên Lạc</th>
							<td><?php echo $row["patient_phone_no"]; ?></td>
						</tr>
						<tr>
							<th class="text-left" width="40%">Ngày Tháng Năm Sinh</th>
							<td><?php echo date('d-m-Y', strtotime($row["patient_date_of_birth"])); ?></td>
							
						</tr>
						<tr>
							<th class="text-left" width="40%">Giới Tính</th>
							<td><?php echo $row["patient_gender"]; ?></td>
						</tr>
						
						<tr>
							<th class="text-left" width="40%">Chiều Cao</th>
							<td><?php echo $row["patient_height"]; ?></td>

						</tr>
						<tr>
							<th class="text-left" width="40%">Cân Nặng</th>
							<td><?php echo $row["patient_weight"]; ?></td>

						</tr>
						<tr>
							<th class="text-left" width="40%">Nhóm Máu</th>
							<td><?php echo $row["patient_blood"]; ?></td>

						</tr>
						<?php
						}
						?>	
					</table>					
				</div>
			</div>
			<br />
			<br />
			<?php
			}
			?>
		</div>
	</div>
</div>

<?php

include('footer.php');


?>

<script>

$(document).ready(function(){

	$('#patient_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

<?php
	foreach($result as $row)
	{

?>
$('#patient_email_address').val("<?php echo $row['patient_email_address']; ?>");
$('#patient_password').val("<?php echo $row['patient_password']; ?>");
$('#patient_first_name').val("<?php echo $row['patient_first_name']; ?>");
$('#patient_last_name').val("<?php echo $row['patient_last_name']; ?>");
$('#patient_date_of_birth').val("<?php echo $row['patient_date_of_birth']; ?>");
$('#patient_gender').val("<?php echo $row['patient_gender']; ?>");
$('#patient_phone_no').val("<?php echo $row['patient_phone_no']; ?>");
$('#patient_height').val("<?php echo $row['patient_height']; ?>");
$('#patient_weight').val("<?php echo $row['patient_weight']; ?>");
$('#patient_blood').val("<?php echo $row['patient_blood']; ?>");
$('#patient_address').val("<?php echo $row['patient_address']; ?>");

<?php

	}

?>

	$('#edit_profile_form').parsley();

	$('#edit_profile_form').on('submit', function(event){

		event.preventDefault();

		if($('#edit_profile_form').parsley().isValid())
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#edit_profile_button').attr('disabled', 'disabled');
					$('#edit_profile_button').val('wait...');
				},
				success:function(data)
				{
					window.location.href = "profile.php";
				}
			})
		}

	});

});

</script>