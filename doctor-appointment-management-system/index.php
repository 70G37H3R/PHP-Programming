<?php

//index.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_SESSION['patient_id']))
{
	header('location:dashboard.php');
}

$object->query = "
SELECT * FROM doctor_schedule_table 
INNER JOIN doctor_table 
ON doctor_table.doctor_id = doctor_schedule_table.doctor_id
WHERE doctor_schedule_table.doctor_schedule_date - interval 1 day >= '".date('Y-m-d')."'
AND doctor_schedule_table.doctor_schedule_date - interval 7 day <= '".date('Y-m-d')."'
AND doctor_schedule_table.doctor_schedule_status = 'Active' 
AND doctor_table.doctor_status = 'Active' 
ORDER BY doctor_schedule_table.doctor_schedule_date ASC
";

$result = $object->get_result();

include('header.php');

?>
		      	<div class="card">
		      		<form method="post" action="result.php">
			      		<div class="card-header"><h3><b>Lịch Làm Việc Của Bác Sĩ</b></h3></div>
			      		<div class="card-body">
		      				<div class="table-responsive">
		      					<table class="table table-striped table-bordered">
		      						<tr>
		      							<th>Tên Bác Sĩ</th>
		      							<th>Học vị</th>
		      							<th>Chuyên ngành</th>
		      							<th>Ngày Hẹn</th>
		      							<th>Thứ Hẹn</th>
		      							<th>Thời Gian Khả Dụng</th>
		      							<th>Tùy Chọn</th>
		      						</tr>
		      						<?php

		      						foreach($result as $row)
		      						{	
										$dayrs= 'Chủ Nhật';
										if ($row["doctor_schedule_day"] == 'Monday')
											$dayrs= 'Thứ Hai';
										else if ($row["doctor_schedule_day"] == 'Tuesday')
											$dayrs= 'Thứ Ba';
										else if ($row["doctor_schedule_day"] == 'Wednesday')
											$dayrs= 'Thứ Tư';
										else if ($row["doctor_schedule_day"] == 'Thursday')
											$dayrs= 'Thứ Năm';
										else if ($row["doctor_schedule_day"] == 'Friday')
											$dayrs= 'Thứ Sáu';
										else if ($row["doctor_schedule_day"] == 'Saturday')
											$dayrs= 'Thứ Bảy';
		      							echo '
		      							<tr>
		      								<td>'.$row["doctor_name"].'</td>
		      								<td>'.$row["doctor_degree"].'</td>
		      								<td>'.$row["doctor_expert_in"].'</td>
		      								<td>'.date('d-m-Y', strtotime($row["doctor_schedule_date"])).'</td>
		      								<td>'.$dayrs.'</td>
		      								<td>'.$row["doctor_schedule_start_time"].' - '.$row["doctor_schedule_end_time"].'</td>
		      								<td><button type="button" name="get_appointment" class="btn btn-primary btn-sm get_appointment" data-id="'.$row["doctor_schedule_id"].'">Đặt lịch hẹn</button></td>
		      							</tr>
		      							';
		      						}
		      						?>
		      					</table>
		      				</div>
		      			</div>
		      		</form>
		      	</div>
		    

<?php

include('footer.php');

?>

<script>

$(document).ready(function(){
	$(document).on('click', '.get_appointment', function(){
		var action = 'check_login';
		var doctor_schedule_id = $(this).data('id');
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:action, doctor_schedule_id:doctor_schedule_id},
			success:function(data)
			{
				window.location.href=data;
			}
		})
	});
});

</script>