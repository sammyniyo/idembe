<?php
include('db.php');
if (!isset($_GET['id'])) {
    echo "Error: Room ID not specified.";
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

?>
<?php
if (isset($_POST['sub'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $room = $_POST['room'];
    $request = $_POST['request'];
        // Check if room is available for the requested dates
        $sql_check = "SELECT * FROM reservations WHERE room = '$room' AND checkin <= '$checkout' AND checkout >= '$checkin'";
        $result_check = mysqli_query($conn, $sql_check);
        if (mysqli_num_rows($result_check) > 0) {
            echo '<script>alert("Sorry, the room is already booked for the selected dates. Please choose different dates or room.")</script>';
        } else {
            // Inserting reservation into database
            $sql = "INSERT INTO reservations (name, phone, email, checkin, checkout, adults, children, room, request)
            VALUES ('$name', '$phone', '$email', '$checkin', '$checkout', '$adults', '$children', '$room', '$request')";
            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Reservation successful!")</script>';
                header("Location: success.php");
                exit();
            } else {
                echo '<script>alert("Error: Could not add reservation to database.")</script>';
            }
        }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Booking | IDEMBE</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="IDEMBE Hotel" name="description" />
	<meta content="Discover the beauty of Rwanda at Idembe, a premier hotel that offers unparalleled comfort and convenience. Our modern and well-appointed rooms, stunning views of the surrounding landscapes, and exceptional service make us the perfect choice for business and leisure travelers alike. 
    Experience the best of Rwanda with Idembe - book your stay today!"
		name="keywords" />
	<meta content="Samuel NIYOMUHOZA-sammuhoza.com" name="author" />
    <meta content="Samuel NIYOMUHOZA-sammuhoza.com" name="author" />
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Calendar styles */
        .ui-datepicker {
            font-family: Arial, sans-serif;
            font-size: 14px;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .ui-datepicker-header {
            background-color: #ccc;
            border-bottom: 1px solid #999;
            font-weight: bold;
        }

        .ui-datepicker-prev,
        .ui-datepicker-next {
            background-color: #ccc;
            color: #333;
            font-weight: bold;
        }

        .ui-datepicker-calendar {
            width: 100%;
        }

        .ui-datepicker-calendar td {
            border: none;
            padding: 5px;
            text-align: center;
        }

        .ui-datepicker-calendar .ui-state-default {
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #333;
            cursor: pointer;
            padding: 5px;
            text-align: center;
        }

        .ui-datepicker-calendar .ui-state-default:hover {
            background-color: #ccc;
        }

        .ui-datepicker-calendar .ui-state-active {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .ui-datepicker-calendar .ui-state-active:hover {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .ui-datepicker-calendar .ui-state-disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="index.php"
                        class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <img src="img/logo.png" height="60" width="150" alt="idembe-logo-light">
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row gx-0 bg-white d-none d-lg-flex">
                        <div class="col-lg-7 px-5 text-start">
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                <p class="mb-0">booking@idembe.com</p>
                            </div>
                            <div class="h-100 d-inline-flex align-items-center py-2">
                                <i class="fa fa-phone-alt text-primary me-2"></i>
                                <p class="mb-0">+250 783 871 782</p>
                            </div>
                        </div>
                        <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <a class="me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                <a class="me-3" href=""><i class="fab fa-instagram"></i></a>
                                <a class="" href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="index.php" class="navbar-brand d-block d-lg-none">
                            <img src="img/logo.png" height="60" width="150" alt="idembe-logo-light">
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="index.php" class="nav-item nav-link">Home</a>
                                <a href="about.php" class="nav-item nav-link">About</a>
                                <a href="service.php" class="nav-item nav-link">Services</a>
                                <a href="acommodation.php" class="nav-item nav-link active">Acommodation</a>
                                <a href="restaurant.php" class="nav-item nav-link">Restaurant</a>
                                <a href="contact.php" class="nav-item nav-link">Contact</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Acommodation</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Acommodation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->
        <?php while($row = $result->fetch_assoc()) { ?>
        <!-- Booking Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Room Booking</h6>
                    <h1 class="mb-5">Book A <span class="text-primary text-uppercase"><?php echo $row['name']; ?></span></h1>
                </div>
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="room-item shadow rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="admin/<?php echo $row['image']; ?>"
                                    alt="<?php echo $name; ?>">
                                <small
                                    class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">$
                                    <?php echo $row['price']; ?>/Night
                                </small>
                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">
                                    <?php echo $row['name']; ?>
                                    </h5>
                                </div>
                                <div class="d-flex mb-3">
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>
                                        <?php echo $row['beds']; ?> Bed
                                    </small>
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i>
                                        <?php echo $row['baths']; ?> Bath
                                    </small>

                                    <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>

                                </div>
                                <p class="text-body mb-3">
                                    <?php echo $row['features']; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form method="POST" action="">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                                required>
                                            <label for="name">Your Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="phone" class="form-control" id="name" placeholder="Your Phone"
                                                requied>
                                            <label for="name">Your Phone</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email"
                                                required>
                                            <label for="email">Your Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating date" id="date3">
                                            <input type="text" name="checkin" class="form-control datetimepicker-input" id="checkin"
                                                type="text" data-toggle="datepicker" placeholder="Check In" />
                                            <label for="checkin">Check In</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating date" id="date4">
                                            <input id="checkout" name="checkout" class="form-control datetimepicker-input" type="text"
                                                data-toggle="datepicker" />
                                            <label for="checkout">Check Out</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="adults" id="select1">
                                                <option value="0"> 0</option>
                                                <option value="1"> 1</option>
                                                <option value="2"> 2</option>
                                                <option value="3"> 3</option>
                                            </select>
                                            <label for="select1">Select Adult</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="children" class="form-select" id="select2">
                                                <option value="0"> 0</option>
                                                <option value="1"> 1</option>
                                                <option value="2"> 2</option>
                                                <option value="3"> 3</option>
                                            </select>
                                            <label for="select2">Select Child</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="room"
                                                value="<?php echo $row['name']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="request" placeholder="Special Request" id="message"
                                                style="height: 100px"></textarea>
                                            <label for="message">Special Request</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" name="sub" type="submit">Book Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- Booking End -->


         <!-- Footer Start -->
         <div class="container-fluid mt-5 bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-4">
                        <img src="img/logo.png" height="60" width="150" alt="idembe-logo-light">
                        <p class="text-white mb-0">
                            Hotel And Lodges
                        </p>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>KK 57 St, Kigali, RWANDA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+250 783 871 782</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>booking@idembe.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Company</h6>
                                <a class="btn btn-link" href="about.php">About Us</a>
                                <a class="btn btn-link" href="contact.php">Contact Us</a>
                                <a class="btn btn-link" href="acommodation.php">Acommodation</a>
                                <a class="btn btn-link" href="restaurant.php">Restaurant</a>
                            </div>
                            <div class="col-md-6">
                                <h6 class="section-title text-start text-primary text-uppercase mb-4">Services</h6>
                                <a class="btn btn-link" href="#">Food & Restaurant</a>
                                <a class="btn btn-link" href="#">Fitness</a>
                                <a class="btn btn-link" href="#">Sports & Gaming</a>
                                <a class="btn btn-link" href="#">Event & Party</a>
                                <a class="btn btn-link" href="#">GYM & Yoga</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            <p class="mb-0 text-center" style="color: rgba(255,255,255,.5);">
                                Copyright ©<span class="year"> 2023</span> - Idembe.
                                All Rights Reserved
                            </p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="index.php">Home</a>
                                <a href="about.php">About</a>
                                <a href="contact.php">Contact</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
    <script>
       jQuery(document).ready(function ($) {
    $('[data-toggle="datepicker"]').datepicker({
        dateFormat: "yy/mm/dd",
        numberOfMonths: 1,
        minDate: 0
    });

    $('#submit').click(function (event) {
        var checkin = $('#checkin').val();
        var checkout = $('#checkout').val();

        var checkin_split = checkin.split('/');
        var arrival_month = checkin_split[0];
        var arrival_day = checkin_split[1];
        var arrival_year = checkin_split[2];
        var arrival_yearmonth = arrival_year + arrival_month;

        var checkout_split = checkout.split('/');
        var departure_month = checkout_split[0];
        var departure_day = checkout_split[1];
        var departure_year = checkout_split[2];
        var departure_yearmonth = departure_year + departure_month;

        if (new Date(checkin) >= new Date(checkout)) {
            alert('Check-out date must be greater than check-in date');
            event.preventDefault();
        } else {
            // your code here
        }
    });
});

    </script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

