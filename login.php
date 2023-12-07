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

<style>
  .card{
    border: 2px solid #ccc;
        
        border-radius: 10px;
        
        max-width: 400px; /* Set a maximum width if desired */
        background: linear-gradient(to right, #1E5128, #191A19); /* Form background color */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional box shadow */
  }
  #container{
    background-color: rgba(0, 0, 0, 0);
    color: white;
  }
</style>

<body class="hold-transition login-page bg-black">
<div class="login-box">
  <div class="login-logo">
    <a href="#" class="text-white"><b><?php echo $_SESSION['system']['name'] ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body" id="container">
      <form action="" id="login-form">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
        <div class="signupbt"> You don't have an account?
        <a href="registration_form.php">Sign Up</a>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
    e.preventDefault()
    start_load()
    if($(this).find('.alert-danger').length > 0 )
      $(this).find('.alert-danger').remove();
    $.ajax({
      url:'ajax.php?action=login',
      method:'POST',
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        end_load();

      },
      success:function(resp){
        if(resp == 1){
          location.href ='index.php?page=home';
        }else{
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          end_load();
        }
      }
    })
  })
  })
</script>
<?php include 'footer.php' ?>
</body>
</html>
