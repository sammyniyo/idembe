<?php
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
if (isset($_POST['submit'])) {
  // Get form data
  $name = $_POST['name'];
  $price = $_POST['price'];
  $beds = $_POST['beds'];
  $baths = $_POST['baths'];
  $features = $_POST['features'];

  // Upload image file
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["image"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "<script>alert('File is not an image.');</script>";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "<script>alert('Sorry, file already exists.');</script>";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["image"]["size"] > 500000) {
    echo "<script>alert('Sorry, your file is too large.');</script>";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
    $uploadOk = 0;
  }

  // If everything is ok, upload file
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

      // Insert room data into database
      $conn = mysqli_connect("localhost","root","","idembe") or die(mysql_error());

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "INSERT INTO rooms (name, image, price, beds, baths, features) VALUES ('$name', '$target_file', $price, $beds, $baths, '$features')";

      if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New room added successfully.');</script>";
      } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
      }

      $conn->close();
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
    }
  }
}
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | IDEMBE</title>
    <meta content="IDEMBE Hotel" name="description" />
	<meta content="Discover the beauty of Rwanda at Idembe, a premier hotel that offers unparalleled comfort and convenience. Our modern and well-appointed rooms, stunning views of the surrounding landscapes, and exceptional service make us the perfect choice for business and leisure travelers alike. 
    Experience the best of Rwanda with Idembe - book your stay today!"
		name="keywords" />
	<meta content="Samuel NIYOMUHOZA-sammuhoza.com" name="author" />
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../img/favicon/site.webmanifest">
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Admin </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>

                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="home.php"> Status</a>
                    </li>
                    <li>
                        <a class="active-menu" href="add-room.php"> Add Rooms</a>
                    </li>
                    <li>
                        <a href="manage-room.php"> Manage Rooms</a>
                    </li>
                    <li>
                        <a href="add-food.php"> Add Food</a>
                    </li>
                    <li>
                        <a href="manage-food.php"> Manage Food</a>
                    </li>
                    <li>
                        <a href="roombook.php"> Room Booking</a>
                    </li>
                    <li>
                        <a href="logout.php"> Logout</a>
                    </li>




                </ul>


            </div>

        </nav>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Add <small>Room</small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-5">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ROOM INFORMATION
                            </div>
                            <div class="panel-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="name">Room Name:</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Room Image:</label>
                                        <input type="file" id="image" name="image" accept="image/*" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price per Night:</label>
                                        <input type="number" id="price" name="price" min="0" step="0.01"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="beds">Number of Beds:</label>
                                        <input type="number" id="beds" name="beds" min="0" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="baths">Number of Baths:</label>
                                        <input type="number" id="baths" name="baths" min="0" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="features">Other Features:</label><br>
                                        <textarea id="features" name="features" rows="5" cols="50"
                                            class="form-control"></textarea>
                                    </div>
                                    <input type="submit" value="Add Room" class="btn btn-primary" name="submit">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->

                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. WRAPPER  -->
        <!-- JS Scripts-->
        <!-- jQuery Js -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- Bootstrap Js -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Metis Menu Js -->
        <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- Custom Js -->
        <script src="assets/js/custom-scripts.js"></script>


</body>

</html>