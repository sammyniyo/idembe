<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>IDEMBE-Admin</title>
  
  
     
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

 <div class="container">


      <div id="login">

        <form method="post">

          <fieldset class="clearfix">

            <p><span class="fontawesome-user"></span><input type="text"  name="user" value="Username" onBlur="if(this.value == '') this.value = 'Username'" onFocus="if(this.value == 'Username') this.value = ''" required></p> <!-- JS because of IE support; better: placeholder="Username" -->
            <p><span class="fontawesome-lock"></span><input type="password" name="pass"  value="Password" onBlur="if(this.value == '') this.value = 'Password'" onFocus="if(this.value == 'Password') this.value = ''" required></p> <!-- JS because of IE support; better: placeholder="Password" -->
            <p><input type="submit" name="sub"  value="Login"></p>

          </fieldset>

        </form>

       

      </div> <!-- end login -->

    </div>  
  
</body>
</html>

<?php
   session_start();
   include('db.php');
   if(isset($_SESSION["user"]))  
 {  
      header("location:home.php");  
 } 
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($conn,$_POST['user']);
      $mypassword = mysqli_real_escape_string($conn,$_POST['pass']); 
      
      $stmt = $conn->prepare("SELECT id FROM login WHERE usname = ? and pass = ?");
      $stmt->bind_param("ss", $myusername, $mypassword);
      $stmt->execute();
      $stmt->store_result();
      $count = $stmt->num_rows;
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         
         $_SESSION['user'] = $myusername;
         
         header("location: home.php");
      } else {
         echo '<script>alert("Your Login Name or Password is invalid") </script>' ;
      }
   }
?>






