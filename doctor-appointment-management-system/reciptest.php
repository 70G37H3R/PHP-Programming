<?php

//download.php

include('class/Appointment.php');

$object = new Appointment;

require_once('class/pdf.php');
$pdf = new Pdf();

$html = '<style>
	table {
	font-family: DejaVu Sans, sans-serif;
	font-size: 12px;
  	}
	</style>
  ';

if(isset($_GET["id"]))
{
	$html .= '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">';


	$html .= '<tr>
			<th style="width:50%" rowspan="3"><img src="img/logo.jpg"  /></th>
			<th style="width:50%"><h2>Phòng Khám Tư</h2></th>
			</tr>
			<tr>
			<th style="width:50%"><p><b>Địa chỉ: </b>Cần thơ - Việt Nam</p></th>
			</tr>
			<tr>
			<th style="width:50%"><p><b>SĐT đường dây nóng: </b>0123456789</p></th>
			</tr>
			';
		
	
	

	$html .= "
	<tr><th><hr /></th><th><hr /></th></tr>
	";
	
	$object->query = "
	SELECT * FROM prescription
	WHERE prescription_id = '".$_GET["id"]."'
	";

	$prescription_data = $object->get_result();

	foreach($prescription_data as $prescription_row)
	{
		
		$object->query = "
		SELECT * FROM doctor_table 
		WHERE doctor_id = '".$prescription_row["doctor_id"]."'
		";

		$doctor_data = $object->get_result();

		$html .= '<tr>
		<th><h4 align="center">Thông Tin Bác Sĩ</h4></th>
		<th><h4 align="center">Thông Tin Bệnh Nhân</h4></th>
		</tr>
		<tr><td>
		<table border="0"  width="100%"> ';

		foreach($doctor_data as $doctor_row)
		{
			$html .= '
			<tr><th width="50%" align="left">Họ và tên</th><td align="left">'.$doctor_row["doctor_name"].'</td></tr>
			<tr><th width="50%" align="left">Chuyên ngành</th><td align="left"> '.$doctor_row["doctor_degree"].' - '.$doctor_row["doctor_expert_in"].'</td></tr>';
		}

		$object->query = "
		SELECT * FROM patient_table 
		WHERE patient_id = '".$prescription_row["patient_id"]."'
		";

		$patient_data = $object->get_result();
		
		$html .= '</table></td><td>
		<table border="0"  width="100%">';

		foreach($patient_data as $patient_row)
		{
			$html .= '
			<tr><th width="40%" align="left">Họ và tên</th><td align="left">'.$patient_row["patient_first_name"].' '.$patient_row["patient_last_name"].'</td></tr>
			<tr><th width="40%" align="left">SĐT liên lạc</th><td align="left">'.$patient_row["patient_phone_no"].'</td></tr>
			<tr><th width="40%" align="left">Địa chỉ liên lạc</th><td align="left">'.$patient_row["patient_address"].'</td></tr>
			';
		}

		
		$html .= '</table></td>
		<tr><td colspan="3">
		';
		$html .= '<hr />
		
		<table border="0" width="100%" >
			<tr><th> <h4 align="left">Thông tin đơn thuốc</h4></th>
		
				<th  width="0%" align="left">Số thứ tự</th>
				<td colspan="3">'.$prescription_row["prescription_no"].'</td>
		
		
				<th   width="0" align="left">Ngày ra đơn</th>
				<td colspan="3">'.date('d-m-Y', strtotime($prescription_row["prescription_date"])).'</td>
			</tr>
			</td></tr><hr/>
		';

		
		$object->query = "
		SELECT * FROM medicine
		WHERE prescription_no = '".$prescription_row["prescription_no"]."'
		";

		$med_data = $object->get_result();
		
		$html .= '</table><tr><td colspan="3">
		<h4 align="center">Danh Sách Thuốc</h4>
		<table border="0"  width="100%" style="border-collapse: collapse; border: 1px solid black;">
		<tr><th style="border: 1px solid black;" width="80%" align="left">Tên thuốc</th>
							<th style="border: 1px solid black;" width="80%" align="left">Số lượng</th>
							<th style="border: 1px solid black;" width="80%" align="left">Cách dùng</th>
		</tr>';

		foreach($med_data as $med_row)
		{
			$html .= '<tr><td colspan="3">
			<tr>
			<td>'.$med_row["medicine_name"].'</td>
			<td>'.$med_row["unit"].'</td>
			<td>'.$med_row["dosage"].'</td>
			</tr>';
		}

		$html .= '
		</table>
		';
	}

	$html .= '
			</td>
		</tr>
	</table>';

	echo $html;

	

	$pdf->loadHtml($html, 'UTF-8');
	$pdf->render();
	ob_end_clean();
	//$pdf->stream($_GET["id"] . '.pdf', array( 'Attachment'=>1 ));
	$pdf->stream('RecipienceID_' . $_GET["id"] . '.pdf', array( 'Attachment'=>false ));
	exit(0);

}

?>