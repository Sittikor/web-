
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  
  <section class="login-content">
    <h3 style="color: white;">ระบบ Key งบประมาณ ชธค.</h3> <br/>
    <div class="login-box">
      <form class="login-form" action="APIAuthen.php" method="post">
        
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
        <div class="form-group">
          <label class="control-label">USERNAME</label>
          <input name="username" id="username" class="form-control" autofocus required>
        </div>
        <div class="form-group">
          <label class="control-label">PASSWORD</label>
          <input name="password" id="password" class="form-control" type="password" id="password">
        </div>
        <div style="text-align: center"> <br/>
          <button type="submit" class="btn btn-primary"id="reportUsernameBtn">Login</button>
          <!-- <button type="button" class="btn btn-secondary" id="reportUsernameBtn">Report Username</button> -->
        </div>
      </form>
    </div>
  </section>
  
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/pace.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#reportUsernameBtn').click(function() {
        var username = $('#username').val();
        
        $.ajax({
          url: 'reportUsername.php',
          method: 'POST',
          data: { username: username },
          success: function(response) {
            // alert('Username reported successfully!');  แจ้งเตือนเข้าสู่ระบบ - แจ้งเตือน report usernames 
          },
          error: function(xhr, status, error) {
            console.error('Error reporting username:', error);
            alert('Failed to report username.');
          }
        });
      });
    });
  </script>

</body>
</html>
