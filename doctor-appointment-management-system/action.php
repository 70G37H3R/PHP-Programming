<?php

//action.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'check_login')
	{
		if(isset($_SESSION['patient_id']))
		{
			echo 'dashboard.php';
		}
		else
		{
			echo 'login.php';
		}
	} 

	if($_POST['action'] == 'patient_register')
	{
		$error = '<div class="alert alert-danger">ErrorInfo</div>';

		$msg = '';

		$data = array(
			':patient_email_address'	=>	$_POST["patient_email_address"]
		);

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_email_address = :patient_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Error Info</div>';
		}
		else
		{
			// $patient_verification_code = md5(uniqid());
			$data = array(
				':patient_email_address'		=>	$object->clean_input($_POST["patient_email_address"]),
				':patient_password'				=>	$_POST["patient_password"],
				':patient_first_name'			=>	$object->clean_input($_POST["patient_first_name"]),
				':patient_last_name'			=>	$object->clean_input($_POST["patient_last_name"]),
				':patient_date_of_birth'		=>	$object->clean_input($_POST["patient_date_of_birth"]),
				':patient_gender'				=>	$object->clean_input($_POST["patient_gender"]),
				':patient_address'				=>	$object->clean_input($_POST["patient_address"]),
				':patient_phone_no'				=>	$object->clean_input($_POST["patient_phone_no"]),
				':patient_height'				=>	$object->clean_input($_POST["patient_height"]),
				':patient_weight'				=>	$object->clean_input($_POST["patient_weight"]),
				':patient_blood'				=>	$object->clean_input($_POST["patient_blood"]),
				':patient_added_on'				=>	$object->now,
				// ':patient_verification_code'	=>	$patient_verification_code,
				':patient_status'					=>	'Inactive'
			);

			$object->query = "
			INSERT INTO patient_table 
			(patient_email_address, patient_password, patient_first_name, patient_last_name, patient_date_of_birth, patient_gender, patient_address, patient_phone_no, patient_height, patient_weight, patient_blood, patient_added_on, patient_status) 
			VALUES (:patient_email_address, :patient_password, :patient_first_name, :patient_last_name, :patient_date_of_birth, :patient_gender, :patient_address, :patient_phone_no, :patient_height, patient_weight, patient_blood, :patient_added_on, :patient_status)
			";

			$object->execute($data);

			$msg = '<div class="alert alert-success">Your registeration will be check soon!</div>';
			// require 'class/class.phpmailer.php';
			// $mail = new PHPMailer;
			// $mail->IsSMTP();
			// $mail->Host = 'smtpout.secureserver.net';
			// $mail->Port = '80';
			// $mail->SMTPAuth = true;
			// $mail->Username = 'xxxxx';
			// $mail->Password = 'xxxxx';
			// $mail->SMTPSecure = '';
			// $mail->From = 'tutorial@webslesson.info';
			// $mail->FromName = 'Webslesson';
			// $mail->AddAddress($_POST["patient_email_address"]);
			// $mail->WordWrap = 50;
			// $mail->IsHTML(true);
			// $mail->Subject = 'Verification code for Verify Your Email Address';

			// $message_body = '
			// <p>For verify your email address, Please click on this <a href="'.$object->base_url.'verify.php?code='.$patient_verification_code.'"><b>link</b></a>.</p>
			// <p>Sincerely,</p>
			// <p>Webslesson.info</p>
			// ';
			// $mail->Body = $message_body;

			// if($mail->Send())
			// {
			// 	$success = '<div class="alert alert-success">Please Check Your Email for email Verification</div>';
			// }
			// else
			// {
			// 	$error = '<div class="alert alert-danger">' . $mail->ErrorInfo . '</div>';
			// }
		}

		$output = array(
			'error'		=>	$error,
			'msg'	=>	$msg
		);
		echo json_encode($output);
	}

	if($_POST['action'] == 'patient_login')
	{
		$error = '';

		$data = array(
			':patient_email_address'	=>	$_POST["patient_email_address"]
		);

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_email_address = :patient_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{

			$result = $object->statement_result();

			foreach($result as $row)
			{
				if($row["patient_status"] == 'Active')
				{
					if($row["patient_password"] == $_POST["patient_password"])
					{
						$_SESSION['patient_id'] = $row['patient_id'];
						$_SESSION['patient_name'] = $row['patient_first_name'] . ' ' . $row['patient_last_name'];
					}
					else
					{
						$error = '<div class="alert alert-danger">Wrong Password</div>';
					}
				}
				else
				{
					$error = '<div class="alert alert-danger">Your account have been inactivated</div>';
				}
			}
		}
		else
		{
			$error = '<div class="alert alert-danger">Wrong Email Address</div>';
		}

		$output = array(
			'error'		=>	$error
		);

		echo json_encode($output);

	}

	if($_POST['action'] == 'fetch_schedule')
	{
		$output = array();

		$order_column = array('doctor_table.doctor_name', 'doctor_table.doctor_degree', 'doctor_table.doctor_expert_in', 'doctor_schedule_table.doctor_schedule_date', 'doctor_schedule_table.doctor_schedule_day', 'doctor_schedule_table.doctor_schedule_start_time');
		
		$main_query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = doctor_schedule_table.doctor_id
		 
		";

		$search_query = '
		WHERE doctor_schedule_table.doctor_schedule_date >= "'.date('Y-m-d').' " 
		AND doctor_schedule_table.doctor_schedule_status = "Active" 
		AND doctor_table.doctor_status = "Active" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_degree LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_expert_in LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_start_time LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY doctor_schedule_table.doctor_schedule_date ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["doctor_name"];

			$sub_array[] = $row["doctor_degree"];

			$sub_array[] = $row["doctor_expert_in"];

			$sub_array[] = date('d-m-Y', strtotime($row["doctor_schedule_date"]));

			$sub_array[] = $row["doctor_schedule_day"];

			$sub_array[] = $row["doctor_schedule_start_time"];

			$sub_array[] = '
			<div align="center">
			<button type="button" name="get_appointment" class="btn btn-primary btn-sm get_appointment" data-doctor_id="'.$row["doctor_id"].'" data-doctor_schedule_id="'.$row["doctor_schedule_id"].'">Đặt lịch hẹn</button>
			</div>
			';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

	if($_POST['action'] == 'edit_profile')
	{
		$data = array(
			':patient_password'			=>	$_POST["patient_password"],
			':patient_first_name'		=>	$_POST["patient_first_name"],
			':patient_last_name'		=>	$_POST["patient_last_name"],
			':patient_date_of_birth'	=>	$_POST["patient_date_of_birth"],
			':patient_gender'			=>	$_POST["patient_gender"],
			':patient_address'			=>	$_POST["patient_address"],
			':patient_phone_no'			=>	$_POST["patient_phone_no"],
			':patient_height'			=>	$_POST["patient_height"],
			':patient_weight'			=>	$_POST["patient_weight"],
			':patient_blood'			=>	$_POST["patient_blood"]
		);

		$object->query = "
		UPDATE patient_table  
		SET patient_password = :patient_password, 
		patient_first_name = :patient_first_name, 
		patient_last_name = :patient_last_name, 
		patient_date_of_birth = :patient_date_of_birth, 
		patient_gender = :patient_gender, 
		patient_address = :patient_address, 
		patient_phone_no = :patient_phone_no, 
		patient_height = :patient_height,
		patient_weight = :patient_weight,
		patient_blood = :patient_blood
		WHERE patient_id = '".$_SESSION['patient_id']."'
		";

		$object->execute($data);

		$_SESSION['success_message'] = '<div class="alert alert-success">Profile Data Updated</div>';

		echo 'done';
	}

	if($_POST['action'] == 'make_appointment')
	{
		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_id = '".$_SESSION["patient_id"]."'
		";

		$patient_data = $object->get_result();

		$object->query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = doctor_schedule_table.doctor_id 
		WHERE doctor_schedule_table.doctor_schedule_id = '".$_POST["doctor_schedule_id"]."'
		";

		$doctor_schedule_data = $object->get_result();

		$html = '
		<h4 class="text-center">Thông Tin Bệnh Nhân</h4>
		<table class="table">
		';

		foreach($patient_data as $patient_row)
		{
			$html .= '
			<tr>
				<th width="40%" class="text-left">Họ và tên</th>
				<td>'.$patient_row["patient_first_name"].' '.$patient_row["patient_last_name"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-left">SĐT liên lạc</th>
				<td>'.$patient_row["patient_phone_no"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-left">Địa chỉ liên lạc</th>
				<td>'.$patient_row["patient_address"].'</td>
			</tr>
			';
		}

		$html .= '
		</table>
		<hr />
		<h4 class="text-center">Thông Tin Cuộc Hẹn</h4>
		<table class="table">
		';
		foreach($doctor_schedule_data as $doctor_schedule_row)
		{
			$html .= '
			<tr>
				<th width="40%" class="text-left">Tên Bác Sĩ</th>
				<td>'.$doctor_schedule_row["doctor_name"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-left">Ngày hẹn</th>
				<td>'.$doctor_schedule_row["doctor_schedule_date"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-left">Thứ hẹn</th>
				<td>'.$doctor_schedule_row["doctor_schedule_day"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-left">Thời Gian Khả Dụng</th>
				<td>'.$doctor_schedule_row["doctor_schedule_start_time"].' - '.$doctor_schedule_row["doctor_schedule_end_time"].'</td>
			</tr>
			';
		}

		$html .= '
		</table>';
		echo $html;
	}

	if($_POST['action'] == 'book_appointment')
	{
		$error = '';
		$data = array(
			':patient_id'			=>	$_SESSION['patient_id'],
			':doctor_schedule_id'	=>	$_POST['hidden_doctor_schedule_id']
		);

		$object->query = "
		SELECT * FROM appointment_table 
		WHERE patient_id = :patient_id 
		AND doctor_schedule_id = :doctor_schedule_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">You have already applied for appointment for this day, try for other day.</div>';
		}
		else
		{
			$object->query = "
			SELECT * FROM doctor_schedule_table 
			WHERE doctor_schedule_id = '".$_POST['hidden_doctor_schedule_id']."'
			";

			$schedule_data = $object->get_result();

			$object->query = "
			SELECT COUNT(appointment_id) AS total FROM appointment_table 
			WHERE doctor_schedule_id = '".$_POST['hidden_doctor_schedule_id']."' 
			";

			$appointment_data = $object->get_result();

			$total_doctor_available_minute = 0;
			$average_consulting_time = 0;
			$total_appointment = 0;

			foreach($schedule_data as $schedule_row)
			{
				$end_time = strtotime($schedule_row["doctor_schedule_end_time"] . ':00');

				$start_time = strtotime($schedule_row["doctor_schedule_start_time"] . ':00');

				$total_doctor_available_minute = ($end_time - $start_time) / 60;

				$average_consulting_time = $schedule_row["average_consulting_time"];
			}

			foreach($appointment_data as $appointment_row)
			{
				$total_appointment = $appointment_row["total"];
			}

			$total_appointment_minute_use = $total_appointment * $average_consulting_time;

			$appointment_time = date("H:i", strtotime('+'.$total_appointment_minute_use.' minutes', $start_time));

			$status = '';

			$appointment_number = $object->Generate_appointment_no();

			if(strtotime($end_time) > strtotime($appointment_time . ':00'))
			{
				$status = 'Booked';
			}
			else
			{
				$status = 'Waiting';
			}
			
			$data = array(
				':doctor_id'				=>	$_POST['hidden_doctor_id'],
				':patient_id'				=>	$_SESSION['patient_id'],
				':doctor_schedule_id'		=>	$_POST['hidden_doctor_schedule_id'],
				':appointment_number'		=>	$appointment_number,
				':reason_for_appointment'	=>	$_POST['reason_for_appointment'],
				':appointment_time'			=>	$appointment_time,
				':status'					=>	'Booked'
			);

			$object->query = "
			INSERT INTO appointment_table 
			(doctor_id, patient_id, doctor_schedule_id, appointment_number, reason_for_appointment, appointment_time, status) 
			VALUES (:doctor_id, :patient_id, :doctor_schedule_id, :appointment_number, :reason_for_appointment, :appointment_time, :status)
			";

			$object->execute($data);

			$_SESSION['appointment_message'] = '<div class="alert alert-success">Your Appointment has been <b>'.$status.'</b> with Appointment No. <b>'.$appointment_number.'</b></div>';
		}
		echo json_encode(['error' => $error]);
		
	}

	if($_POST['action'] == 'fetch_appointment')
	{
		$output = array();

		$order_column = array('appointment_table.appointment_number','doctor_table.doctor_name', 'doctor_schedule_table.doctor_schedule_date', 'appointment_table.appointment_time', 'doctor_schedule_table.doctor_schedule_day', 'appointment_table.status');
		
		$main_query = "
		SELECT * FROM appointment_table  
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = appointment_table.doctor_id 
		INNER JOIN doctor_schedule_table 
		ON doctor_schedule_table.doctor_schedule_id = appointment_table.doctor_schedule_id 
		
		";

		$search_query = '
		WHERE appointment_table.patient_id = "'.$_SESSION["patient_id"].'" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY appointment_table.appointment_id ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["appointment_number"];

			$sub_array[] = $row["doctor_name"];

			$sub_array[] = date('d-m-Y', strtotime($row["doctor_schedule_date"]));			

			$sub_array[] = $row["appointment_time"];

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
			

			$sub_array[] = $dayrs;

			$status = '';

			if($row["status"] == 'Booked')
			{
				$status = '<span class="badge badge-warning">Đã Hẹn</span>';
			}

			if($row["status"] == 'In Process')
			{
				$status = '<span class="badge badge-primary">Đang Xử Lý</span>';
			}

			if($row["status"] == 'Completed')
			{
				$status = '<span class="badge badge-success">Thành công</span>';
			}

			if($row["status"] == 'Cancel')
			{
				$status = '<span class="badge badge-danger">Hủy</span>';
			}

			$sub_array[] = $status;

			$sub_array[] = '<a href="download.php?id='.$row["appointment_id"].'" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>';

			$sub_array[] = '<button type="button" name="cancel_appointment" class="btn btn-danger btn-sm cancel_appointment" data-id="'.$row["appointment_id"].'"><i class="fas fa-times"></i></button>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

	if($_POST['action'] == 'cancel_appointment')
	{
		$data = array(
			':status'			=>	'Cancel',
			':appointment_id'	=>	$_POST['appointment_id']
		);
		$object->query = "
		UPDATE appointment_table 
		SET status = :status 
		WHERE appointment_id = :appointment_id
		";
		$object->execute($data);
		echo '<div class="alert alert-success">Your Appointment has been Cancel</div>';
	}

	if($_POST['action'] == 'fetch_prescription')
	{
		$output = array();

		$order_column = array('prescription.prescription_id','doctor_table.doctor_name', 'prescription.prescription_date');
		
		$main_query = "
		SELECT * FROM prescription  
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = prescription.doctor_id 
		";

		$search_query = '
		WHERE prescription.patient_id = "'.$_SESSION["patient_id"].'" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( prescription.prescription_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR prescription.prescription_date LIKE "%'.$_POST["search"]["value"].'%") ';
		
			
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY prescription.prescription_id ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["prescription_id"];

			$sub_array[] = $row["doctor_name"];

			$sub_array[] = date('d-m-Y', strtotime($row["prescription_date"]));			


			$sub_array[] = '<a href="reciptest.php?id='.$row["prescription_id"].'" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>';

			$sub_array[] = '<button type="button" name="cancel_appointment" class="btn btn-danger btn-sm cancel_appointment" data-id="'.$row["prescription_id"].'"><i class="fas fa-times"></i></button>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}
}



?>