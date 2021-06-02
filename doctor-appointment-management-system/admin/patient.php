<?php

//patient.php

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
                    <h1 class="h3 mb-4 text-gray-800">Quản Lý Bệnh Nhân</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-primary">Danh Sách Bệnh Nhân</h6>
                            	</div>
                            	<div class="col" align="right">
                                <button type="button" name="add_patient" id="add_patient" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="patient_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Họ</th>
                                            <th>Địa chỉ email </th>
                                            <th>Số điện thoại</th>
                                            <th>Nhóm máu</th>
                                            <th>Trạng thái</th>
                                            <th>Tùy chọn</th>
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
<div id="patientModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="patient_form">
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
                                <label>Tên <span class="text-danger">*</span></label>
                                <input type="text" name="patient_first_name" id="patient_first_name" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Họ <span class="text-danger">*</span></label>
                                <input type="text" name="patient_last_name" id="patient_last_name" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Tài Khoản (Email) <span class="text-danger">*</span></label>
                                <input type="text" name="patient_email_address" id="patient_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
							<div class="col-md-6">
									<label>Mật Khẩu<span class="text-danger">*</span></label>
									<input type="text" name="patient_password" id="patient_password" class="form-control" required  data-parsley-trigger="keyup" />
								
							</div>
                        </div>
                    </div>


					<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Giới tính<span class="text-danger">*</span></label>
                                <select name="patient_gender" id="patient_gender" class="form-control" required  data-parsley-trigger="keyup">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                    <option value="Khác">Khác</option>
                                  
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>SĐT Liên Lạc</label>
                                <input type="text" name="patient_phone_no" id="patient_phone_no" class="form-control" required  data-parsley-trigger="keyup"/>
                            </div>
					    </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Ngày Tháng Năm Sinh</label>
                                <input type="text" name="patient_date_of_birth" id="patient_date_of_birth" readonly class="form-control"/>
                            </div>
                            <div class="col-md-6">
                                <label>Địa Chỉ Liên Lạc</label>
                                <input type="text" name="patient_address" id="patient_address" class="form-control" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Chiều Cao<span class="text-danger">*</span>(cm)</label>
                                <input type="text" name="patient_height" id="patient_height" class="form-control" required  data-parsley-trigger="keyup"/>
                            </div>
                            <div class="col-md-4">
                                <label>Cân Nặng<span class="text-danger">*</span>(kg)</label>
                                <input type="text" name="patient_weight" id="patient_weight" class="form-control"required  data-parsley-trigger="keyup">
                            </div>
                            <div class="col-md-4">
                                <label>Nhóm Máu</label>
                                <input type="text" name="patient_blood" id="patient_blood" class="form-control"required  data-parsley-trigger="keyup">
                            </div>
                        </div>
                    </div>
                </div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>


<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Xem Chi Tiết Thông Tin Bệnh Nhân</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="patient_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#patient_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"patient_action.php",
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
				"targets":[5, 6],
				"orderable":false,
			},
		],
	});

    $('#patient_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $('#patient_form').parsley();

	$('#patient_form').on('submit', function(event){
		event.preventDefault();
		if($('#patient_form').parsley().isValid())
		{		
			$.ajax({
				url:"patient_action.php",
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
						$('#patientModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});

    $(document).on('click', '.view_button', function(){

        var patient_id = $(this).data('id');

        $.ajax({

            url:"patient_action.php",

            method:"POST",

            data:{patient_id:patient_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                
                var html = '<div class="table-responsive">';
                html += '<table class="table">';
                
                html += '<tr><th width="40%" class="text-left">Địa chỉ email</th><td width="60%">'+data.patient_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Mật khẩu</th><td width="60%">'+data.patient_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Họ và tên</th><td width="60%">'+data.patient_first_name+' '+data.patient_last_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Số điện thoại</th><td width="60%">'+data.patient_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Nơi ở</th><td width="60%">'+data.patient_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Ngày sinh</th><td width="60%">'+data.patient_date_of_birth+'</td></tr>';
                html += '<tr><th width="40%" class="text-left">Giới tính</th><td width="60%">'+data.patient_gender+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Chiều cao</th><td width="60%">'+data.patient_height+'</td></tr>';
                html += '<tr><th width="40%" class="text-left">Cân Nặng</th><td width="60%">'+data.patient_weight+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Nhóm máu</th><td width="60%">'+data.patient_blood+'</td></tr>';

                html += '<tr><th width="40%" class="text-left">Ngày Tạo Tài Khoản</th><td width="60%">'+data.patient_added_on+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#patient_details').html(html);

                $('#hidden_id').val(patient_id);

            }

        })
    });


    $(document).on('click', '.edit_button', function(){

            var patient_id = $(this).data('id');

            $('#patient_form').parsley().reset();

            $('#form_message').html('');

            $.ajax({

                url:"patient_action.php",

                method:"POST",

                data:{patient_id:patient_id, action:'fetch_single'},

                dataType:'JSON',

                success:function(data)
                {
                    
                    $('#patient_first_name').val(data.patient_first_name);

                    $('#patient_last_name').val(data.patient_last_name);
                    $('#patient_email_address').val(data.patient_email_address);
                    
                    $('#patient_gender').val(data.patient_gender);
                    $('#patient_password').val(data.patient_password);
                    $('#patient_phone_no').val(data.patient_phone_no);
                    $('#patient_address').val(data.patient_address);
                    $('#patient_date_of_birth').val(data.patient_date_of_birth);
                    $('#patient_height').val(data.patient_height);
                    $('#patient_weight').val(data.patient_weight);
                    $('#patient_blood').val(data.patient_blood);


                    $('#modal_title').text('Cập Nhật Thông Tin Chi Tiết Bệnh Nhân');

                    $('#action').val('Edit');

                    $('#submit_button').val('Cập Nhật');

                    $('#patientModal').modal('show');

                    $('#hidden_id').val(patient_id);

                }

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

        		url:"patient_action.php",

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
    
	$('#add_patient').click(function(){
		
		$('#patient_form')[0].reset();

		$('#patient_form').parsley().reset();

    	$('#modal_title').text('Thêm Mới Bệnh Nhân');

    	$('#action').val('Add');

    	$('#submit_button').val('Thêm');

    	$('#patientModal').modal('show');

    	$('#form_message').html('');

	});

    $(document).on('click', '.delete_button', function(){

        var id = $(this).data('id');

        if(confirm("Bạn có chắc chắn muốn xóa dữ liệu này?"))
        {

            $.ajax({

                url:"patient_action.php",

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