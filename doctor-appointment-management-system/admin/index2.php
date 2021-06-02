
<?php

include('headerlogin.php');

include('../class/Appointment.php');

$object = new Appointment;

if($object->is_login())
{
    header("location:".$object->base_url."admin/dashboard.php");
}
?>

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col col-md-4">
			<?php
			if(isset($_SESSION["success_message"]))
			{
				echo $_SESSION["success_message"];
				unset($_SESSION["success_message"]);
			}
			?>
			<span id="message"></span>
			<div class="card">
				<div class="card-header">Bác Sĩ Đăng Nhập</div>
				<div class="card-body">
					<form method="post" id="login_form">
						<div class="form-group">
							<label>Tài Khoản (Email)</label>
							<input type="text" name="admin_email_address" id="admin_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
						</div>
						<div class="form-group">
							<label>Mật Khẩu</label>
							<input type="password" name="admin_password" id="admin_password" class="form-control" required  data-parsley-trigger="keyup" />
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="admin_login" />
							<input type="submit" name="login_button" id="login_button" class="btn btn-primary" value="Đăng Nhập" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

include('footerlogin.php');

?>

<script>

$(document).ready(function(){

    $('#login_form').parsley();

    $('#login_form').on('submit', function(event){
        event.preventDefault();
        if($('#login_form').parsley().isValid())
        {       
            $.ajax({
                url:"login_action.php",
                method:"POST",
                data:$(this).serialize(),
                dataType:'json',
                beforeSend:function()
                {
                    $('#login_button').attr('disabled', 'disabled');
                    $('#login_button').val('Đang xử lý...');
                },
                success:function(data)
                {
                    $('#login_button').attr('disabled', false);
                    if(data.error != '')
                    {
                        $('#message').html(data.error);
                        $('#login_button').val('Đăng Nhập');
                    
                    }
                    else
                    {
                        window.location.href = data.url;
                        
                    }
                }
            })
        }
    });

});

</script>