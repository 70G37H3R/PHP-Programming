<?php

//prescription.php

include('../class/Appointment.php');

$object = new Appointment;

if(!isset($_SESSION['admin_id']))
{
    header('location:'.$object->base_url.'');
}

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Quản Lý Đơn Thuốc</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col-sm-6">
                            		<h6 class="m-0 font-weight-bold text-primary">Danh Sách Đơn Thuốc</h6>
                            	</div>
                            	<div class="col-sm-6" align="right">
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-9">
                                            <div class="row input-daterange">
                                                <div class="col-md-6">
                                                    <input type="text" name="start_date" id="start_date" value="Ngày bắt đầu" class="form-control form-control-sm" readonly />
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="end_date" id="end_date" value="Ngày kết thúc" class="form-control form-control-sm" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <button type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"><i class="fas fa-search"></i></button>&nbsp;
                                                <button type="button" name="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>&emsp;&emsp;
                                                <button type="button" name="add_prescription" id="add_prescription" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                                            </div>
                                            
                                        </div>
                                    </div>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="prescription_table">
                                    <thead>
                                        <tr>
                                            <th>Số Thứ Tự Đơn Thuốc</th>
                                            <th>Tên Bệnh Nhân</th>
                                            <?php
                                            if($_SESSION['type'] == 'Admin')
                                            {
                                            ?>
                                            <th>Tên Bác Sĩ</th>
                                            <?php
                                            }
                                            ?>
                                            <th>Ngày ra đơn</th>
                                            <th>In</th>
                                            <th>Tùy Chọn</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>
<div id="prescriptionModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="prescription_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Prescription</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
                    <?php
                    if($_SESSION['type'] == 'Admin')
                    {
                    ?>
                    <div class="form-group">
                        <label>Tên Bác Sĩ<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-md"></i></i></span>
                            </div>
                        <select name="doctor_id" id="doctor_id" class="form-control" required>
                            <option value="">Chọn Bác Sĩ</option>
                            <?php
                            $object->query = "
                            SELECT * FROM doctor_table 
                            WHERE doctor_status = 'Active' 
                            ORDER BY doctor_name ASC
                            ";

                            $result = $object->get_result();

                            foreach($result as $row)
                            {
                                echo '
                                <option value="'.$row["doctor_id"].'">'.$row["doctor_name"].'</option>
                                ';
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <label>Ngày ra đơn</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" name="prescription_date" id="prescription_date" class="form-control" required readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ID Bệnh Nhân<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="far fa-user-circle"></i></span>
                            </div>
                            <input type="text" name="patient_id" id="patient_id" class="form-control" required data-parsley-trigger="keyup" />
                
                        </div>
                    </div>
                    <div id="rows">
                    <div class="form-group" >
                            <label>Tên Thuốc<span class="text-danger">*</span></label>
                            <label style="float:right; margin-right:50px; display:inline_block;">Số lượng</label>
                            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-capsules"></i></span>
                                </div>
                          
                                <input type="text" name="med_name[]" id="med_name" class="form-control" required data-parsley-trigger="keyup" />
                                <input type="text" name="med_unit[]" id="med_unit" class="form-control col-md-3" required data-parsley-trigger="keyup" />
   
                            </div>
                    </div>
                    <div class="form-group">
                        <label>Cách dùng </label>
                        <div class="input-group">
                            <select name="med_dosage[]" id="med_dosage" class="form-control " required data-parsley-trigger="keyup">
                                    <option value="">Chọn cách dùng</option>
                                    <option value="1 viên - 1 lần - 1 ngày">1 viên - 1 lần - 1 ngày</option>
                                    <option value="2 viên - 1 lần - 1 ngày">2 viên - 1 lần - 1 ngày</option>
                                    <option value="3 viên - 1 lần - 1 ngày">3 viên - 1 lần - 1 ngày</option>
                                    <option value="1 viên - 2 lần - 1 ngày">1 viên - 2 lần - 1 ngày</option>
                                    <option value="2 viên - 2 lần - 1 ngày">2 viên - 2 lần - 1 ngày</option>
                                    <option value="3 viên - 2 lần - 1 ngày">3 viên - 2 lần - 1 ngày</option>
                                    <option value="1 viên - 3 lần - 1 ngày">1 viên - 3 lần - 1 ngày</option>
                                    <option value="2 viên - 3 lần - 1 ngày">2 viên - 3 lần - 1 ngày</option>
                                    <option value="3 viên - 3 lần - 1 ngày">3 viên - 3 lần - 1 ngày</option>
                                    
                            </select>
                
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <input type="button" id="add" value="Thêm mới thuốc" class="btn btn-primary" />
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
        <form method="post" id="edit_prescription_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Xem Thông Tin Chi Tiết Đơn Thuốc</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <div id="rows">
                    
                    <div id="prescription_details"> </div>
                </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_prescription_id" id="hidden_prescription_id" />
                    <input type="hidden" name="action" value="change_prescription_status" />
                    <input type="submit" name="save_prescription" id="save_prescription" class="btn btn-primary" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){

    
    var i = 1;

    // $("#add").click(function(){
    //   i++;
    //   $('#rows').append('<div id="row'+i+'"><div class="form-group"><label>Med Name <span class="text-danger">*</span></label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fa-user-circle"></i></span></div><input type="text" name="med_name[]" id="med_name" class="form-control" required data-parsley-trigger="keyup" /><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div>');  
    // });
    $("#add").click(function(){
      i++;
      $('#rows').append('<div id="row'+i+'"> <div class="form-group"><label>Tên Thuốc</label><label style="float:right; margin-right:50px; display:inline_block;">Số lượng</label>'
                           + '<div class="input-group">'
                           + '<div class="input-group-prepend">'
                           +        '<span class="input-group-text" id="basic-addon1"><i class="fas fa-capsules"></i></span>'
                           + '</div>'
                           +    '<input type="text" name="med_name[]" id="med_name" class="form-control " required data-parsley-trigger="keyup" />'
                           +    '<input type="text" name="med_unit[]" id="med_unit" class="form-control col-md-3" required data-parsley-trigger="keyup" />'           
                           + '</div>'
                        + '</div>'
                        + '<div class="form-group">'
                        + '<label>Cách dùng </label>'
                        + '<div class="input-group">'
                        +    '<select name="med_dosage[]" id="med_dosage" class="form-control required data-parsley-trigger="keyup" />'
                        +           '<option value="">Chọn cách dùng</option>'
                        +           '<option value="1 viên - 1 lần - 1 ngày">1 viên - 1 lần - 1 ngày</option>'
                        +           '<option value="2 viên - 1 lần - 1 ngày">2 viên - 1 lần - 1 ngày</option>'
                        +           '<option value="3 viên - 1 lần - 1 ngày">3 viên - 1 lần - 1 ngày</option>'
                        +           '<option value="1 viên - 2 lần - 1 ngày">1 viên - 2 lần - 1 ngày</option>'
                        +           '<option value="2 viên - 2 lần - 1 ngày">2 viên - 2 lần - 1 ngày</option>'
                        +           '<option value="3 viên - 2 lần - 1 ngày">3 viên - 2 lần - 1 ngày</option>'
                        +           '<option value="1 viên - 3 lần - 1 ngày">1 viên - 3 lần - 1 ngày</option>'
                        +           '<option value="2 viên - 3 lần - 1 ngày">2 viên - 3 lần - 1 ngày</option>'
                        +           '<option value="3 viên - 3 lần - 1 ngày">3 viên - 3 lần - 1 ngày</option>'    
                        +    '</select>'

                        +    '<span><button name="remove" id="'+i+'" class="btn btn-danger btn_remove ">X</button></span>'
                        + '</div>'
                        + '</div>');  
    });

  

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
    });

    fetch_data('no');

    function fetch_data(is_date_search, start_date='', end_date='')
    {
        var dataTable = $('#prescription_table').DataTable({
            "processing" : true,
            "serverSide" : true,
            
            "order" : [],
            "ajax" : {
                url:"prescription_action.php",
                type:"POST",
                
                data:{
                    is_date_search:is_date_search, start_date:start_date, end_date:end_date, action:'fetch'
                },
                
                
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
                    <?php
                    if($_SESSION['type'] == 'Admin')
                    {
                    ?>
                    "targets":[4, 5],
                    <?php
                    }
                    else
                    {
                    ?>
                    "targets":[3, 4],
                    <?php
                    }
                    ?>
                    "orderable":false,
                },
            ],
        });
    }

	/*var dataTable = $('#prescription_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"prescription_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
                <?php
                //if($_SESSION['type'] == 'Admin')
                //{
                ?>
				"targets":[7],
                <?php
               // }
               // else
              //  {
                ?>
                "targets":[6],
                <?php
               // }
                ?>
				"orderable":false,
			},
		],
	});*/

    $(document).on('click', '.view_button', function(){

        var prescription_id = $(this).data('id');

        $.ajax({

            url:"prescription_action.php",

            method:"POST",

            data:{prescription_id:prescription_id, action:'fetch_single'
            },
            cache: false,
           
            success:function(data)
            {
                $('#viewModal').modal('show');

                $('#prescription_details').html(data);

                $('#hidden_prescription_id').val(prescription_id);

            },

        })
    });

    $('.input-daterange').datepicker({
        todayBtn:'linked',
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $('#search').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if(start_date != '' && end_date !='')
        {
            $('#prescription_table').DataTable().destroy();
            fetch_data('yes', start_date, end_date);
        }
        else
        {
            alert("Both Date is Required");
        }
    });

    $('#refresh').click(function(){
        $('#prescription_table').DataTable().destroy();
        fetch_data('no');
    });

    $('#edit_prescription_form').parsley();

    $('#edit_prescription_form').on('submit', function(event){
        event.preventDefault();
        if($('#edit_prescription_form').parsley().isValid())
        {       
            $.ajax({
                url:"prescription_action.php",
                method:"POST",
                data: $(this).serialize(),
                cache: false,
                beforeSend:function()
                {
                    $('#save_prescription').attr('disabled', 'disabled');
                    $('#save_prescription').val('wait...');
                },
                success:function(data)
                {
                    $('#save_prescription').attr('disabled', false);
                    $('#save_prescription').val('Save');
                    $('#viewModal').modal('hide');
                    $('#message').html(data);
                    $('#prescription_table').DataTable().destroy();
                    fetch_data('no');
                    setTimeout(function(){
                        $('#message').html('');
                    }, 5000);
                }
            })
        }
    });

    $('#add_prescription').click(function(){
		
		$('#prescription_form')[0].reset();

		$('#prescription_form').parsley().reset();

    	$('#modal_title').text('Thêm Mới Đơn Thuốc');

    	$('#action').val('Add');

    	$('#submit_button').val('Thêm');

    	$('#prescriptionModal').modal('show');

    	$('#form_message').html('');

	});

    
	$('#prescription_form').parsley();

    $('#prescription_form').on('submit', function(event){
        event.preventDefault();
        if($('#prescription_form').parsley().isValid())
        {		
            $.ajax({
                url:"prescription_action.php",
                method:"POST",
                data:$(this).serialize(),
                dataType:'json',
                
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
                        $('#prescriptionModal').modal('hide');
                        $('#message').html(data.success);
                        $('#prescription_table').DataTable().destroy();
                        fetch_data('no');
                        setTimeout(function(){

                            $('#message').html('');

                        }, 1000);
                        
                    }
                },
                cache: false,
            })
        }
    });


    

    var date = new Date();
    date.setDate(date.getDate());

    $('#prescription_date').datepicker({
        startDate: date,
        format: "yyyy-mm-dd",
        autoclose: true
    });

    $(document).on('click', '.delete_button', function(){

    var id = $(this).data('id');

        if(confirm("Bạn có chắc chắn muốn xóa dữ liệu này?"))
        {

      $.ajax({

        url:"prescription_action.php",

        method:"POST",

        data:{id:id, action:'delete'},

        success:function(data)
        {

              $('#message').html(data);

              $('#prescription_table').DataTable().destroy();
              fetch_data('no');

              setTimeout(function(){

                $('#message').html('');

              }, 5000);

        }

      })

}

});


});
</script>