<?php
include('db.php');
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
?>
<?php  
if (isset($_GET['rid'])) {
    // Get the booking ID from the URL parameter
    $booking_id = $_GET['rid'];

    // Check if the action parameter is set to "confirm"
    if (isset($_GET['action']) && $_GET['action'] == 'confirm') {
        // Update the booking status in the database to "confirmed"
        $query = "UPDATE reservations SET status = 'confirmed' WHERE id = $booking_id";
        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Display a success message
            echo "<script>alert('Booking confirmed!')</script>";
        } else {
            // Display an error message
            echo "<script>alert('Error updating booking status: " . mysqli_error($conn) . "')</script>";
        }
    }
}
?>
<?php
if (isset($_GET['xid']) ){
    $delete_id = $_GET['xid'];
    if (isset($_GET['action']) && $_GET['action'] == 'delete'){
        $query = "DELETE FROM reservations WHERE id = $delete_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Display a success message
            echo '<script>alert("Reservation deleted successfully!")</script>';
            header("Location: room-booking.php");
}
        } else {
            // Display an error message
            echo '<script>alert("Error: Could not delete reservation from database.")</script>';
        }
    }
    

// Close the database connection
mysqli_close($conn);

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
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../img/favicon/site.webmanifest">
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
                        <a href="manage-food.php"> Manage Food</a>
                    </li>
					<li>
                        <a class="active-menu" href="room-booking.php"> Room Booking</a>
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
                            <small>Room Booking </small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
				<?php
						include ('db.php');
						$sql = "select * from reservations";
						$re = mysqli_query($conn,$sql);
						$c =0;
						while($row=mysqli_fetch_array($re) )
						{
								$new = $row['status'];
								$cin = $row['checkin'];
								$id = $row['id'];
								if($new=="pending")
								{
									$c = $c + 1;
									
								
								}
						
						}
						
									
									

						
				?>

					<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
							
							<div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
											<button class="btn btn-default" type="button">
												 New Room Bookings  <span class="badge"><?php echo $c ; ?></span>
											</button>
											</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                                        <div class="panel-body">
                                           <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Check In</th>
											<th>Check Out</th>
                                            <th>Adults</th>
											<th>Children</th>
											<th>Room</th>
											<th>Request</th>
											<th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
									<?php
									$tsql = "select * from reservations";
									$tre = mysqli_query($conn,$tsql);
									while($trow=mysqli_fetch_array($tre) )
									{	
										$co =$trow['status']; 
										if($co=="pending")
										{
											echo"<tr>
												<th>".$trow['id']."</th>
												<th>".$trow['name']."</th>
												<th>".$trow['phone']."</th>
												<th>".$trow['email']."</th>
												<th>".$trow['checkin']."</th>
												<th>".$trow['checkout']."</th>
												<th>".$trow['adults']."</th>
												<th>".$trow['children']."</th>
												<th>".$trow['room']."</th>
												<th>".$trow['request']."</th>
												
												<th><a href='room-booking.php?rid=".$trow['id']."&action=confirm' class='btn btn-primary'>Approve</a></th>
";
										}	
									
									}
									?>
                                        
                                    </tbody>
                                </table>
								
                            </div>
                        </div>
                    </div>
                      <!-- End  Basic Table  --> 
                                        </div>
                                    </div>
                                </div>
								<?php
								
								$rsql = "SELECT * FROM `reservations`";
								$rre = mysqli_query($conn,$rsql);
								$r =0;
								while($row=mysqli_fetch_array($rre) )
								{		
										$br = $row['status'];
										if($br=="confirmed")
										{
											$r = $r + 1;
											
											
											
										}
										
								
								}
						
								?>
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">
											<button class="btn btn-primary" type="button">
												 Booked Rooms  <span class="badge"><?php echo $r ; ?></span>
											</button>
											
											</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
                                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Check In</th>
											<th>Check Out</th>
                                            <th>Adults</th>
											<th>Children</th>
											<th>Room</th>
											<th>Status</th>
											<th>View</th>
                                            <th>UnBook</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
									<?php
									$tsql = "select * from reservations";
									$tre = mysqli_query($conn,$tsql);
									while($trow=mysqli_fetch_array($tre) )
									{	
										$co =$trow['status']; 
										if($co=="confirmed")
										{
											echo"<tr>
												<th>".$trow['id']."</th>
												<th>".$trow['name']."</th>
												<th>".$trow['phone']."</th>
												<th>".$trow['email']."</th>
												<th>".$trow['checkin']."</th>
												<th>".$trow['checkout']."</th>
												<th>".$trow['adults']."</th>
												<th>".$trow['children']."</th>
												<th>".$trow['room']."</th>
												<th>".$trow['status']."</th>
												
                                                <th><a href=show.php?sid=".$id ."><button  class='btn btn-primary btn' data-toggle='modal' data-target='#myModal'>
                                                Show
                                                </button></a></th>
												<th><a href='room-booking.php?xid=".$trow['id']."&action=delete' class='btn btn-primary'>Delete</a></th>

                                                
";
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