<?php

//appointment_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$output = array();

		if($_SESSION['type'] == 'Admin')
		{
			$order_column = array('prescription.prescription_id', 'patient_table.patient_first_name', 'doctor_table.doctor_name', 'prescription.prescription_date');
			$main_query = "
			SELECT * FROM prescription
			INNER JOIN doctor_table
			ON doctor_table.doctor_id = prescription.doctor_id
			INNER JOIN patient_table
			ON patient_table.patient_id = prescription.patient_id
			";

			$search_query = '';

			if($_POST["is_date_search"] == "yes")
			{
			 	$search_query .= 'WHERE prescription.prescription_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND (';
			}
			else
			{
				$search_query .= 'WHERE ';
			}

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'prescription.prescription_id LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR prescription.prescription_date LIKE "%'.$_POST["search"]["value"].'%" ';
				
				
			}
			if($_POST["is_date_search"] == "yes")
			{
				$search_query .= ') ';
			}
			else
			{
				$search_query .= '';
			}
		}
		else
		{
			$order_column = array('prescription.prescription_id', 'patient_table.patient_first_name', 'prescription.prescription_date');

			$main_query = "
			SELECT * FROM prescription
			INNER JOIN patient_table
			ON patient_table.patient_id = prescription.patient_id
			";

			$search_query = '
			WHERE prescription.doctor_id = "'.$_SESSION["admin_id"].'" 
			';

			if($_POST["is_date_search"] == "yes")
			{
			 	$search_query .= 'AND prescription.prescription_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" ';
			}
			else
			{
				$search_query .= '';
			}

			if(isset($_POST["search"]["value"]))
			{
				$search_query .= 'AND (prescription.prescription_id LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_first_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR patient_table.patient_last_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR prescription.prescription_date LIKE "%'.$_POST["search"]["value"].'%") ';
			
			}
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY prescription.prescription_id DESC ';
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

			$sub_array[] = $row["prescription_no"];

			$sub_array[] = $row["patient_first_name"] . ' ' . $row["patient_last_name"];

			if($_SESSION['type'] == 'Admin')
			{
				$sub_array[] = $row["doctor_name"];
			}
			$sub_array[] = date('d-m-Y', strtotime($row["prescription_date"]));
			$sub_array[] = '<a href="../reciptest.php?id='.$row["prescription_id"].'" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>';
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-warning btn-circle btn-sm view_button" data-id="'.$row["prescription_id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["prescription_id"].'"><i class="fas fa-times"></i></button>
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

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM prescription
		WHERE prescription_id = '".$_POST["prescription_id"]."'
		";

		$prescription_data = $object->get_result();

		foreach($prescription_data as $prescription_row)
		{
			
			
			$html = '
			<h4 class="text-center">Thông Tin Bác Sĩ</h4>
			<table class="table">
			';
			$object->query = "
			SELECT * FROM doctor_table 
			WHERE doctor_id = '".$prescription_row["doctor_id"]."'
			";

			$doctor_data = $object->get_result();

			foreach($doctor_data as $doctor_row)
			{
				$html .= '
				<tr>
					<th width="40%" class="text-left">Họ và tên</th>
					<td>'.$doctor_row["doctor_name"].'</td>
					
				</tr>
				<tr>
					<th width="40%" class="text-left">Chuyên ngành</th>
				<td>'.$doctor_row["doctor_degree"].' '.$doctor_row["doctor_expert_in"].'</td>
			</tr>
				';
			}
			$html .= '
			</table>
			<hr />
			';
			$html .= '
			<h4 class="text-center">Thông Tin Bệnh Nhân</h4>
			<table class="table">
			';


			$object->query = "
			SELECT * FROM patient_table 
			WHERE patient_id = '".$prescription_row["patient_id"]."'
			";

			$patient_data = $object->get_result();

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
					<th width="40%" class="text-left">Địa chỉ</th>
					<td>'.$patient_row["patient_address"].'</td>
				</tr>
				';
			}

			$html .= '
			</table>
			<hr />
	
			<h4 class="text-center">Danh Sách Thuốc</h4>
			<table class="table" >
				<tr>
					<th width="40%" class="text-left">Số thứ tự đơn thuốc</th>
					<td>'.$prescription_row["prescription_no"].'</td>
					<td><input type="hidden" name="prescription_no" id="prescription_no" value="'.$prescription_row["prescription_no"].'" class="form-control" ></td>
				</tr>
			';


			$object->query = "
			SELECT * FROM medicine 
			WHERE prescription_no = '".$prescription_row["prescription_no"]."'
			";
			$medicine_data = $object->get_result();
			$i=0;
			foreach($medicine_data as $medicine_row)
			{
				$i++;
				$html .= '
				<tr>
					<th width="40%" class="text-left">'.$i.'.	Tên thuốc</th>
					<td><input type="text" name="medicine_name[]" id="medicine_name" value="'.$medicine_row["medicine_name"].'" class="form-control" ></td>
					<td><input type="hidden" name="medicine_id[]" id="medicine_id" value="'.$medicine_row["medicine_id"].'" class="form-control" ></td>
					
				</tr>
				<tr>
					<th width="40%" class="text-left">Số lượng</th>
					<td><input type="text" name="medicine_unit[]" id="medicine_unit" value="'.$medicine_row["unit"].'"class="form-control" ></td>
				</tr>
				<tr>
					<th width="40%" class="text-left">Cách dùng</th>
					<td>
					<select name="medicine_dosage[]" id="medicine_dosage"  class="form-control">
					<option value="1 viên - 1 lần - 1 ngày">1 viên - 1 lần - 1 ngày</option>
					<option value="2 viên - 1 lần - 1 ngày">2 viên - 1 lần - 1 ngày</option>
					<option value="3 viên - 1 lần - 1 ngày">3 viên - 1 lần - 1 ngày</option>
					<option value="1 viên - 2 lần - 1 ngày">1 viên - 2 lần - 1 ngày</option>
					<option value="2 viên - 2 lần - 1 ngày">2 viên - 2 lần - 1 ngày</option>
					<option value="3 viên - 2 lần - 1 ngày">3 viên - 2 lần - 1 ngày</option>
					<option value="1 viên - 3 lần - 1 ngày">1 viên - 3 lần - 1 ngày</option>
					<option value="2 viên - 3 lần - 1 ngày">2 viên - 3 lần - 1 ngày</option>
					<option value="3 viên - 3 lần - 1 ngày">3 viên - 3 lần - 1 ngày</option>
					<option value="'.$medicine_row["dosage"].'" selected hidden >'.$medicine_row["dosage"].'</option>
					</select>
					
					</td>
				</tr>
		
				
				';
			}

			$html .= '
			</table>
			
			<hr />
			
			';
			
		}

		echo $html;
	}

	
	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		$doctor_id = '';

		if($_SESSION['type'] == 'Admin')
		{
			$doctor_id = $_POST["doctor_id"];
		}

		if($_SESSION['type'] == 'Doctor')
		{
			$doctor_id = $_SESSION['admin_id'];
		}

		
		$prescription_number = $object->Generate_prescription_no();
		$medicine_name = $_POST["med_name"];
		$medicine_unit = $_POST["med_unit"];
		$medicine_dosage = $_POST["med_dosage"];

		$data1 = array(
			':doctor_id'					=>	$doctor_id,
			':prescription_no'				=>	$prescription_number,
			':patient_id'					=>	$_POST["patient_id"],
			':prescription_date'			=>	$_POST["prescription_date"]
			
		);

		$object->query = "
		INSERT INTO prescription
		(doctor_id, prescription_no, patient_id, prescription_date) 
		VALUES (:doctor_id, :prescription_no, :patient_id, :prescription_date)
		";

		$object->execute($data1);

		
		$medicine_name = $_POST["med_name"];
		$medicine_unit = $_POST["med_unit"];
		$medicine_dosage = $_POST["med_dosage"];
	
		
		$i = 0;
		foreach($medicine_name as $medicine_rows) {
			$data2 = array(
				':prescription_no'							=>  $prescription_number,
				':medicine_name'							=>	$medicine_name[$i],
				':unit'										=>	$medicine_unit[$i],
				':dosage'									=>  $medicine_dosage[$i]
			);	
		$object->query = "
		INSERT INTO medicine
		(prescription_no, medicine_name, unit, dosage) 
		VALUES (:prescription_no, :medicine_name, :unit, :dosage)
		";
		
		$object->execute($data2);
		$i++;
		}



		$success = '<div class="alert alert-success">Dữ liệu đã được thêm mới</div>';
	
		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'change_prescription_status')
	{
		
	
		$prescription_no = 	$_POST['prescription_no'];
		$medicine_id = $_POST['medicine_id'];
		$medicine_name = $_POST['medicine_name'];
		$medicine_unit = $_POST['medicine_unit'];
		$medicine_dosage = $_POST['medicine_dosage'];
		
		$i = 0;
		foreach($medicine_id as $medicine_rows) {
			$data = array(
				':prescription_no'							=>  $prescription_no,
				':medicine_id'								=>	$medicine_id[$i],
				':medicine_name'							=>	$medicine_name[$i],
				':unit'										=>	$medicine_unit[$i],
				':dosage'									=>  $medicine_dosage[$i],
			);	
		$object->query = "
		UPDATE medicine 
		SET medicine_name = :medicine_name, 
		unit = :unit, 
		dosage = :dosage
		WHERE medicine_id = :medicine_id 
		AND prescription_no= :prescription_no
		";
		
		$object->execute($data);
		$i++;
		}

		echo '<div class="alert alert-success">Dữ liệu đã được cập nhật </div>';

	}

	
	

	
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM prescription 
		WHERE prescription_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Dữ liệu đã bị xóa</div>';
	}
}

?>