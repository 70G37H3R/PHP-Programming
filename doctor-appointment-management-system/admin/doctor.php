<?php

//doctor.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Quản Lý Bác Sĩ</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-primary">Danh Sách Bác Sĩ</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_doctor" id="add_doctor" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="doctor_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Ảnh Đại Diện</th>
                                            <th>Tài Khoản (Email)</th>
                                            <th>Tên Bác Sĩ</th>
                                            <th>SĐT Liên Lạc</th>
                                            <th>Chuyên Ngành</th>
                                            <th>Trạng Thái</th>
                                            <th>Tùy Chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>

<div id="doctorModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="doctor_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Tài Khoản (Email)<span class="text-danger">*</span></label>
                                <input type="text" name="doctor_email_address" id="doctor_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Mật Khẩu<span class="text-danger">*</span></label>
                                <input type="password" name="doctor_password" id="doctor_password" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Tên Bác Sĩ<span class="text-danger">*</span></label>
                                <input type="text" name="doctor_name" id="doctor_name" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>SĐT Liên Lạc <span class="text-danger">*</span></label>
                                <input type="text" name="doctor_phone_no" id="doctor_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Địa Chỉ Liên Lạc</label>
                                <input type="text" name="doctor_address" id="doctor_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Ngày Tháng Năm Sinh</label>
                                <input type="text" name="doctor_date_of_birth" id="doctor_date_of_birth" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Học Vị <span class="text-danger">*</span></label>
                                <!-- <input type="text" name="doctor_degree" id="doctor_degree" class="form-control" required data-parsley-trigger="keyup" /> -->
								<select name="doctor_degree" id="doctor_degree" class="form-control" required data-parsley-trigger="keyup" >
									<option value="CK I">CK I</option>
									<option value="CK II">CK II</option>
								</select>
							</div>
                            <div class="col-md-6">
                                <label>Chuyên Ngành<span class="text-danger">*</span></label>
                                <!-- <input type="text" name="doctor_expert_in" id="doctor_expert_in" class="form-control" required  data-parsley-trigger="keyup" /> -->
								<select name="doctor_expert_in" id="doctor_expert_in" class="form-control" required  data-parsley-trigger="keyup" >
									<option value="Hồi sức - Cấp cứu">Hồi sức - Cấp cứu</option>
									<option value="Gây mê">Gây mê</option>
									<option value="Nội - Cơ xương khớp">Nội - Cơ xương khớp</option>
									<option value="Răng - Hàm - Mặt">Răng - Hàm - Mặt</option>
									<option value="Tai - Mũi - Họng">Tai - Mũi - Họng</option>
									<option value="Da liễu">Da liễu</option>
									<option value="Phục hồi chức năng">Phục hồi chức năng</option>
									<option value="Da liễu">Da liễu</option>
									<option value="Tim mạch">Tim mạch</option>
									<option value="Tiêu hóa">Tiêu hóa</option>
									<option value="Hô hấp">Hô hấp</option>
									<option value="Nhi">Nhi</option>
								</select>
							</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ảnh Đại diện <span class="text-danger">*</span></label>
                        <br />
                        <input type="file" name="doctor_profile_image" id="doctor_profile_image" />
                        <div id="uploaded_image" ></div>
                        <input type="hidden" name="hidden_doctor_profile_image" id="hidden_doctor_profile_image"  />
                    </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Xem Thông Tin Chi Tiết Bác Sĩ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="doctor_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#doctor_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"doctor_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"language": {
			"sProcessing":    "Đang Xử Lý...",
			"sSearch" : "Tìm Kiếm",
			"oPaginate": {
            "sFirst":    "Đầu Tiên",
            "sLast":    "Cuối Cùng",
            "sNext":    "Sau",
            "sPrevious": "Trước"
        	},
			"sEmptyTable":    "Không Tìm Thấy Thông Tin Nào",
		},
		"columnDefs":[
			{
				"targets":[0, 1, 3, 5, 6],
				"orderable":false,
			},
		],
	});

    $('#doctor_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#add_doctor').click(function(){
		
		$('#doctor_form')[0].reset();

		$('#doctor_form').parsley().reset();

    	$('#modal_title').text('Thêm Mới Bác Sĩ');

    	$('#action').val('Add');

    	$('#submit_button').val('Thêm');

    	$('#doctorModal').modal('show');

    	$('#form_message').html('');

	});

	$('#doctor_form').parsley();

	$('#doctor_form').on('submit', function(event){
		event.preventDefault();
		if($('#doctor_form').parsley().isValid())
		{		
			$.ajax({
				url:"doctor_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:'json',
				contentType: false,
                cache: false,
                processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Add');
					}
					else
					{
						$('#doctorModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        },1000);
					}
				},
				
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var doctor_id = $(this).data('id');

		$('#doctor_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"doctor_action.php",

	      	method:"POST",

	      	data:{doctor_id:doctor_id, action:'fetch_single'},

	      	dataType:'JSON',
		
			

	      	success:function(data)
	      	{

	        	$('#doctor_email_address').val(data.doctor_email_address);

                $('#doctor_email_address').val(data.doctor_email_address);
                $('#doctor_password').val(data.doctor_password);
                $('#doctor_name').val(data.doctor_name);
                $('#uploaded_image').html('<img src="'+data.doctor_profile_image+'" class="img-fluid img-thumbnail" width="150" />')
                $('#hidden_doctor_profile_image').val(data.doctor_profile_image);
                $('#doctor_phone_no').val(data.doctor_phone_no);
                $('#doctor_address').val(data.doctor_address);
                $('#doctor_date_of_birth').val(data.doctor_date_of_birth);
                $('#doctor_degree').val(data.doctor_degree);
                $('#doctor_expert_in').val(data.doctor_expert_in);

	        	$('#modal_title').text('Cập Nhật Thông Tin Chi Tiết Bác Sĩ');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Cập Nhật');

	        	$('#doctorModal').modal('show');

	        	$('#hidden_id').val(doctor_id);

	      	},
			cache: false,
			

	    })

	});

	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var next_status = 'Active';
		if(status == 'Active')
		{
			next_status = 'Inactive';
		}
		if(confirm("Bạn có muốn thay đổi trạng thái?"))
    	{

      		$.ajax({

        		url:"doctor_action.php",

        		method:"POST",

        		data:{id:id, action:'change_status', status:status, next_status:next_status},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}
	});

    $(document).on('click', '.view_button', function(){
        var doctor_id = $(this).data('id');

        $.ajax({

            url:"doctor_action.php",

            method:"POST",

            data:{doctor_id:doctor_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><td colspan="2" class="text-center"><img src="'+data.doctor_profile_image+'" class="img-fluid img-thumbnail" width="150" /></td></tr>';

                html += '<tr><th width="40%" class="text-left">Tài Khoản (Email)</th><td width="60%">'+data.doctor_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Mật Khẩu</th><td width="60%">'+data.doctor_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Tên Bác Sĩ</th><td width="60%">'+data.doctor_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">SĐT Liên Lạc</th><td width="60%">'+data.doctor_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Địa Chỉ Liên Lạc</th><td width="60%">'+data.doctor_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Ngày Tháng Năm Sinh</th><td width="60%">'+data.doctor_date_of_birth+'</td></tr>';
                html += '<tr><th width="40%" class="text-left">Học Vị</th><td width="60%">'+data.doctor_degree+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Chuyên Ngành</th><td width="60%">'+data.doctor_expert_in+'</td></tr>';
				html += '<tr><th width="40%" class="text-left">Thời Gian Bắt Đầu Công Tác</th><td width="60%">'+data.doctor_added_on+'</td></tr>';
                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#doctor_details').html(html);

            }

        })
    });

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Bạn có chắc chắn muốn xóa dữ liệu này?"))
    	{

      		$.ajax({

        		url:"doctor_action.php",

        		method:"POST",

        		data:{id:id, action:'delete'},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}

  	});



});
</script>