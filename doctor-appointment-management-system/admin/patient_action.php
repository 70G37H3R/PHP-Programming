<?php

//patient_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('patient_first_name', 'patient_last_name', 'patient_email_address', 'patient_phone_no', 'patient_status');

		$output = array();

		$main_query = "
		SELECT * FROM patient_table ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE patient_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR patient_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR patient_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR patient_phone_no LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR patient_blood LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR patient_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY patient_id DESC ';
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

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["patient_first_name"];
			$sub_array[] = $row["patient_last_name"];
			$sub_array[] = $row["patient_email_address"];
			$sub_array[] = $row["patient_phone_no"];
			$sub_array[] = $row["patient_blood"];
			$status = '';
			if($row["patient_status"] == 'Active')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["patient_id"].'" data-status="'.$row["patient_status"].'">Kích Hoạt</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["patient_id"].'" data-status="'.$row["patient_status"].'">Chặn</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-circle btn-sm view_button" data-id="'.$row["patient_id"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["patient_id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["patient_id"].'"><i class="fas fa-times"></i></button>
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

	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

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
			$error = '<div class="alert alert-danger">Tài Khoản (Email) đã tồn tại</div>';
		}
		else
		{
				$data = array(
					':patient_email_address'		=>	$object->clean_input($_POST["patient_email_address"]),
					':patient_password'				=>	$_POST["patient_password"],
					':patient_first_name'			=>	$object->clean_input($_POST["patient_first_name"]),
					':patient_last_name'			=>	$object->clean_input($_POST["patient_last_name"]),
					':patient_phone_no'				=>	$object->clean_input($_POST["patient_phone_no"]),
					':patient_address'				=>	$object->clean_input($_POST["patient_address"]),
					':patient_date_of_birth'		=>	$object->clean_input($_POST["patient_date_of_birth"]),
					':patient_gender'				=>	$object->clean_input($_POST["patient_gender"]),
					':patient_height'				=>	$object->clean_input($_POST["patient_height"]),
					':patient_weight'				=>	$object->clean_input($_POST["patient_weight"]),
					':patient_blood'				=>	$object->clean_input($_POST["patient_blood"]),
					':patient_status'				=>	'Active',
					':patient_added_on'				=>	$object->now
				);

				$object->query = "
				INSERT INTO patient_table 
				(patient_email_address, patient_password, patient_first_name, patient_last_name, patient_phone_no, patient_address, patient_date_of_birth, patient_gender, patient_height,  patient_weight,  patient_blood, patient_status, patient_added_on) 
				VALUES (:patient_email_address, :patient_password, :patient_first_name, :patient_last_name, :patient_phone_no, :patient_address, :patient_date_of_birth, :patient_gender, :patient_height, :patient_weight, :patient_blood, :patient_status, :patient_added_on)
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Dữ liệu đã được thêm mới</div>';
			
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_id = '".$_POST["patient_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['patient_email_address'] = $row['patient_email_address'];
			$data['patient_password'] = $row['patient_password'];
			$data['patient_first_name'] = $row['patient_first_name'];
			$data['patient_last_name'] = $row['patient_last_name'];
			$data['patient_date_of_birth'] = $row['patient_date_of_birth'];
			$data['patient_gender'] = $row['patient_gender'];
			$data['patient_address'] = $row['patient_address'];
			$data['patient_phone_no'] = $row['patient_phone_no'];
			$data['patient_height'] = $row['patient_height'];
			$data['patient_weight'] = $row['patient_weight'];
			$data['patient_blood'] = $row['patient_blood'];
			$data['patient_added_on'] = '<span class="badge badge-success">'.date('d-m-Y', strtotime($row['patient_added_on'])).'</span>';
			
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':patient_email_address'	=>	$_POST["patient_email_address"],
			':patient_id'			=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_email_address = :patient_email_address 
		AND patient_id != :patient_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Tài khoản (Email) đã tồn tại</div>';
		}
		else
		{

			if($error == '')
			{
				$data = array(
					':patient_first_name'				=>	$object->clean_input($_POST["patient_first_name"]),
					':patient_last_name'				=>	$object->clean_input($_POST["patient_last_name"]),
					':patient_email_address'			=>	$object->clean_input($_POST["patient_email_address"]),
					':patient_password'					=>	$_POST["patient_password"],
					':patient_date_of_birth' 			=>	$object->clean_input($_POST["patient_date_of_birth"]),
					':patient_height'					=>	$object->clean_input($_POST["patient_height"]),
					':patient_weight'					=>	$object->clean_input($_POST["patient_weight"]),
					':patient_blood'					=>	$object->clean_input($_POST["patient_blood"]),
					':patient_gender'					=>	$object->clean_input($_POST["patient_gender"]),
					':patient_phone_no'					=>	$object->clean_input($_POST["patient_phone_no"]),
					':patient_address'					=>	$object->clean_input($_POST["patient_address"]),
					
					
				);

				$object->query = "
				UPDATE patient_table  
				
				SET patient_email_address = :patient_email_address, 
				patient_first_name = :patient_first_name, 
				patient_last_name = :patient_last_name, 
				patient_password = :patient_password, 
				patient_gender = :patient_gender, 
				patient_phone_no = :patient_phone_no, 
				patient_address = :patient_address,
				patient_date_of_birth = :patient_date_of_birth,
				patient_height = :patient_height,
				patient_weight = :patient_weight,
				patient_blood = :patient_blood
			
				WHERE patient_id = '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Dữ liệu đã được cập nhật</div>';
			}	
		}		
		

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':patient_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE patient_table 
		SET patient_status = :patient_status 
		WHERE patient_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Thay đổi trạng thái thành công</div>';
	}


	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM patient_table 
		WHERE patient_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Dữ liệu đã bị xóa</div>';
	}
}

?>