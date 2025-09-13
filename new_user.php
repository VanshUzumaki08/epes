<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
		<form action="" id="manage_user" class="needs-validation" novalidate>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">

					<div class="form-group">
  <label class="control-label">First Name</label>
  <input type="text" name="firstname" 
         class="form-control form-control-sm" 
         required minlength="3" 
         pattern="[A-Za-z]{3,}" 
         value="<?php echo isset($firstname) ? $firstname : '' ?>">
  <div class="invalid-feedback">First name must be at least 3 letters.</div>
</div>

						<!-- Last Name -->
						<div class="form-group">
  <label class="control-label">Last Name</label>
  <input type="text" name="lastname" 
         class="form-control form-control-sm" 
         required minlength="3" 
         pattern="[A-Za-z]{3,}" 
         value="<?php echo isset($lastname) ? $lastname : '' ?>">
  <div class="invalid-feedback">Last name must be at least 3 letters.</div>
</div>

						<!-- Avatar -->
						<div class="form-group">
							<label class="control-label">Avatar</label>
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="img" 
									 onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label" for="customFile">Choose file</label>
		                    </div>
						</div>
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar :'' ?>" 
								 alt="Avatar" id="cimg" class="img-fluid img-thumbnail ">
						</div>
					</div>

					<div class="col-md-6">

						<!-- Email -->
						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" required
								   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
								   value="<?php echo isset($email) ? $email : '' ?>">
							<div class="invalid-feedback">Please enter a valid email.</div>
							<small id="msg"></small>
						</div>

						<!-- Password -->
<!-- Password -->
<div class="form-group">
  <label class="control-label">Password</label>
  <input type="password" class="form-control form-control-sm" 
         name="password" 
         <?php echo !isset($id) ? "required":'' ?>
         minlength="8"
         pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
         placeholder="Password">
  <div class="invalid-feedback">
    Password must be at least 8 characters and include uppercase, lowercase, number, and special character.
  </div>
  <small><i><?php echo isset($id) ? "Leave this blank if you don't want to change your password" : '' ?></i></small>
</div>

<!-- Confirm Password -->
<div class="form-group">
  <label class="label control-label">Confirm Password</label>
  <input type="password" class="form-control form-control-sm" 
         id="cpass"
         name="cpass" <?php echo !isset($id) ? 'required' : '' ?>>
  <div class="invalid-feedback">Confirm Password must match Password.</div>
  <small id="pass_match"></small>
</div>

					</div>
				</div>

				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" 
							onclick="location.href = 'index.php?page=user_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>

<script>
// Password Match Check
$('[name="password"],[name="cpass"]').keyup(function(){
    var pass = $('[name="password"]').val();
    var cpass = $('[name="cpass"]').val();
    if (cpass === '' || pass === '') {
        $('#pass_match').attr('data-status','');
    } else {
        if (cpass === pass) {
            $('#pass_match').attr('data-status','1')
                .html('<i class="text-success">Password Matched.</i>');
        } else {
            $('#pass_match').attr('data-status','2')
                // .html('<i class="text-danger">Password does not match.</i>');
        }
    }
});


// Preview Avatar
function displayImg(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#cimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Bootstrap Validation
(function () {
  'use strict';

  // Bootstrap validation
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      let pass = document.getElementById('password').value;
      let cpass = document.getElementById('cpass').value;

      if (form.checkValidity() === false || pass !== cpass) {
        event.preventDefault();
        event.stopPropagation();
        if (pass !== cpass) {
          document.getElementById('cpass').setCustomValidity("Passwords do not match");
        }
      } else {
        document.getElementById('cpass').setCustomValidity("");
      }

      form.classList.add('was-validated');
    }, false);
  });
})();

// Live check while typing
$('#password, #cpass').on('keyup', function () {
  let pass = $('#password').val();
  let cpass = $('#cpass').val();
  if (cpass === "") {
    $('#pass_match').html('');
    return;
  }
  if (pass === cpass) {
    $('#cpass')[0].setCustomValidity("");
    $('#pass_match').html('<i class="text-success">Passwords match.</i>');
  } else {
    $('#cpass')[0].setCustomValidity("Passwords do not match");
    $('#pass_match').html('<i class="text-danger">Passwords do not match.</i>');
  }
});


// Submit with AJAX if valid
$('#manage_user').submit(function(e){
	e.preventDefault()
	if (!this.checkValidity()) {
		this.classList.add('was-validated');
		return false;
	}

	// Password match validation
	if($('[name="password"]').val() != '' && $('[name="cpass"]').val() != ''){
		if($('#pass_match').attr('data-status') != 1){
			$('[name="password"],[name="cpass"]').addClass("border-danger")
			return false;
		}
	}

	start_load()
	$('#msg').html('')

	$.ajax({
		url:'ajax.php?action=save_user',
		data: new FormData($(this)[0]),
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		success:function(resp){
			if(resp == 1){
				alert_toast('Data successfully saved.',"success");
				setTimeout(function(){
					location.replace('index.php?page=user_list')
				},750)
			}else if(resp == 2){
				$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
				$('[name="email"]').addClass("border-danger")
				end_load()
			}
		}
	})
})
</script>
