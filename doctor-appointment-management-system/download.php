<?php

//download.php

include('class/Appointment.php');

$object = new Appointment;

require_once('class/pdf.php');

$html = '<style>
	table {
	font-family: DejaVu Sans, sans-serif;
	font-size: 12px;
  	}
	</style>
  ';

if(isset($_GET["id"]))
{
	$html .= '<table border="0" cellpadding="5" cellspacing="5" width="100%">';

	
	$html .= '<tr><td align="center">';
		
			// $html .= '<img src="'.substr($hospital_row['hospital_logo'], 3).'" /><br />';
	$html .= '<img src="img/logo.jpg" /><br />';
		
	$html .= '<h2 align="center">Phòng Khám Tư</h2>
		<p align="center"><b>Địa chỉ: </b>Cần thơ - Việt Nam</p>
		<p align="center"><b>SĐT đường dây nóng: </b>0123456789</p></td></tr>
	';
	

	$html .= "
	<tr><td><hr /></td></tr>
	<tr><td>
	";

	$object->query = "
	SELECT * FROM appointment_table 
	WHERE appointment_id = '".$_GET["id"]."'
	";

	$appointment_data = $object->get_result();

	foreach($appointment_data as $appointment_row)
	{

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_id = '".$appointment_row["patient_id"]."'
		";

		$patient_data = $object->get_result();

		$object->query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = doctor_schedule_table.doctor_id 
		WHERE doctor_schedule_table.doctor_schedule_id = '".$appointment_row["doctor_schedule_id"]."'
		";

		$doctor_schedule_data = $object->get_result();
		
		$html .= '
		<h4 align="center">Thông Tin Bệnh Nhân</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">';

		foreach($patient_data as $patient_row)
		{
			$html .= '<tr><th width="50%" align="right">Họ và tên</th><td>'.$patient_row["patient_first_name"].' '.$patient_row["patient_last_name"].'</td></tr>
			<tr><th width="50%" align="right">SĐT liên lạc</th><td>'.$patient_row["patient_phone_no"].'</td></tr>
			<tr><th width="50%" align="right">Địa chỉ liên lạc</th><td>'.$patient_row["patient_address"].'</td></tr>';
		}

		$html .= '</table><br /><hr />
		<h4 align="center">Thông tin đơn hẹn</h4>
		<table border="0" cellpadding="5" cellspacing="5" width="100%">
			<tr>
				<th width="50%" align="right">Số thứ tự cuộc hẹn</th>
				<td>'.$appointment_row["appointment_number"].'</td>
			</tr>
		';
		foreach($doctor_schedule_data as $doctor_schedule_row)
		{
			$dayrs= 'Chủ Nhật';
			if ($doctor_schedule_row["doctor_schedule_day"] == 'Monday')
				$dayrs= 'Thứ Hai';
			else if ($doctor_schedule_row["doctor_schedule_day"] == 'Tuesday')
				$dayrs= 'Thứ Ba';
			else if ($doctor_schedule_row["doctor_schedule_day"] == 'Wednesday')
				$dayrs= 'Thứ Tư';
			else if ($doctor_schedule_row["doctor_schedule_day"] == 'Thursday')
				$dayrs= 'Thứ Năm';
			else if ($doctor_schedule_row["doctor_schedule_day"] == 'Friday')
				$dayrs= 'Thứ Sáu';
			else if ($doctor_schedule_row["doctor_schedule_day"] == 'Saturday')
				$dayrs= 'Thứ Bảy';
			$html .= '
			<tr>
				<th width="50%" align="right">Tên bác sĩ</th>
				<td>'.$doctor_schedule_row["doctor_name"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Ngày hẹn</th>
				<td>'.date('d-m-Y', strtotime($doctor_schedule_row["doctor_schedule_date"])).'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Thứ hẹn</th>
				<td>'.$dayrs.'</td>
			</tr>
				
			';
		}
		$confirm= 'Có';
			if ($appointment_row["patient_come_into_hospital"] == 'No')
				$confirm= 'Không';
		$html .= '
			<tr>
				<th width="50%" align="right">Giờ hẹn</th>
				<td>'.$appointment_row["appointment_time"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Lí do</th>
				<td>'.$appointment_row["reason_for_appointment"].'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Xác nhận bệnh nhân đến khám</th>
				<td>'.$confirm.'</td>
			</tr>
			<tr>
				<th width="50%" align="right">Lời dặn bác sĩ</th>
				<td>'.$appointment_row["doctor_comment"].'</td>
			</tr>
		</table>
			';
	}

	$html .= '
			</td>
		</tr>
	</table>';

	echo $html;

	$pdf = new Pdf();

	$pdf->loadHtml($html, 'UTF-8');
	$pdf->render();
	ob_end_clean();
	//$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>1 ));
	$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>false ));
	exit(0);

}

?>