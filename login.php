<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
  ob_start();
    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");
?>
<?php include 'header.php' ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ✅ Bootstrap 4.6 CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- ✅ Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- ✅ jQuery (needed for Bootstrap + Ajax) -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- ✅ Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="hold-transition login-page bg-black">
  <h2 class="text-center text-white mb-4">
    <b><?php echo $_SESSION['system']['name'] ?></b>
  </h2>

  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <form action="" id="login-form" class="needs-validation" novalidate autocomplete="off"> 
          <!-- Email -->
          <div class="input-group mb-3">
  <input type="email" class="form-control" name="email" required 
         placeholder="Email" autocomplete="off" value=""
         pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
  <div class="input-group-append">
    <div class="input-group-text"><span class="fas fa-envelope"></span></div>
  </div>
  <div class="invalid-feedback">Please enter a valid email.</div>
</div>

          <!-- Password -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" required minlength="6" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            <div class="invalid-feedback">Please enter your password (min 6 characters).</div>
          </div>

          <!-- Role -->
          <div class="form-group mb-3">
            <label for="login">Login As</label>
            <select name="login" id="login" class="custom-select custom-select-sm" required>
              <option value="">Choose...</option>
              <option value="0">Employee</option>
              <option value="1">Evaluator</option>
              <option value="2">Admin</option>
            </select>
            <div class="invalid-feedback">Please select a role.</div>
          </div>

          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ✅ Bootstrap validation script -->
  <script>
    (function () {
      'use strict';
      var forms = document.querySelectorAll('.needs-validation');
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    })();

  </script>

  <!-- ✅ AJAX Login -->
  <script>
    $(document).ready(function () {
      $('#login-form').submit(function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
          return; // stop Ajax if form invalid
        }

        start_load();
        if ($(this).find('.alert-danger').length > 0)
          $(this).find('.alert-danger').remove();

        $.ajax({
          url: 'ajax.php?action=login',
          method: 'POST',
          data: $(this).serialize(),
          error: function (err) {
            console.log(err);
            end_load();
          },
          success: function (resp) {
            if (resp == 1) {
              location.href = 'index.php?page=home';
            } else {
              $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
              end_load();
            }
          }
        });
      });
    });
  </script>

  <?php include 'footer.php' ?>
</body>
</html>
