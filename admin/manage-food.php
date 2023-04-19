<?php
include('db.php');
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Idembe | Administrator</title>
    <meta content="IDEMBE Hotel" name="description" />
	<meta content="Discover the beauty of Rwanda at Idembe, a premier hotel that offers unparalleled comfort and convenience. Our modern and well-appointed rooms, stunning views of the surrounding landscapes, and exceptional service make us the perfect choice for business and leisure travelers alike. 
    Experience the best of Rwanda with Idembe - book your stay today!"
		name="keywords" />
	<meta content="Samuel NIYOMUHOZA-sammuhoza.com" name="author" />
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
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
                <a class="navbar-brand" href="home.php"> <?php echo $_SESSION["user"]; ?> </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
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
                        <a href="add-room.php"> Add Rooms</a>
                    </li>
                    <li>
                        <a href="manage-room.php"> Manage Rooms</a>
                    </li>
                    <li>
                        <a href="add-food.php"> Add Food</a>
                    </li>
                    <li>
                        <a class="active-menu" href="manage-food.php"> Manage Food</a>
                    </li>
					<li>
                        <a href="room-booking.php"> Room Booking</a>
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
                            <small>Manage Room</small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
				
					<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Features</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM food";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['features'] . "</td>";
                    echo "<td><a href='manage-food.php?uid=" . $row['id'] . "&action=delete' class='btn btn-primary'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No food found.</td></tr>";
            }

            // Check if delete button was clicked and perform deletion
            if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['uid'])) {
                $id = $_GET['uid'];
                $delete_sql = "DELETE FROM food WHERE id = $id";
                if (mysqli_query($conn, $delete_sql)) {
                    echo "<script>alert('food deleted successfully.');</script>";
                    echo "<script>window.location.href='manage-food.php';</script>";
                } else {
                    echo "<script>alert('Error deleting food.');</script>";
                    echo "<script>window.location.href='manage-food.php';</script>";
                }
            }
        ?>
    </tbody>
</table>

								
                            </div>
                        </div>
                                           
										</div>
										
                                    </div>
									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
			<!-- /. ROW  -->
				
            </div>
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
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>