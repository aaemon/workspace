<?php 
    $login_session = 'ammer';
    include "db.inc.php"; 

    if(isset($_GET['error'])) {
        $alert_error = $_GET['error'];
    }
    if(isset($_GET['success'])) {
        $alert_success = $_GET['success'];
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $serial_start = $_POST['serial_start'];
        $serial_end = $_POST['serial_end'];
        $zone = $_POST['zone'];
        $package_name = $_POST['package_name'];

        //match $day with package name
        if ($package_name == '7 TK') {
            $day = 120;
        }
        else if ($package_name == '15 TK') {
            $day = 1440;
        }
        else if ($package_name == '25 TK') {
            $day = 2880;
        }
        else if ($package_name == '50 TK') {
            $day = 7200;
        }
        else if ($package_name == '249 TK') {
            $day = 43200;
        }
        else if ($package_name == '599 TK') {
            $day = 43200;
        }
        else if ($package_name == '899 TK') {
            $day = 43200;
        }
        else {
            $alert_error = "ERROR - PLEASE SELECT CORRECT PACKAGE";
            header("Location: ./executive_request.php?error=$alert_error");
            die();
        }
        
        if($serial_start > $serial_end) {
            $alert_error = "ERROR - START_ID MUST BE LESS THAN END_ID";
            header("Location: ./executive_request.php?error=$alert_error");
            die();
        } 

        //check submitted query matches pin_new Unused
        $nqur = "SELECT COUNT(id) AS count_state FROM pin_new WHERE id>=$serial_start AND id<=$serial_end AND state!='Unused'";
        $nexe = mysqli_query($conn, $nqur);
        $ndata = mysqli_fetch_array($nexe);
        $count_state = $ndata['count_state'];
        if($count_state > 0) {
            $alert_error = "PIN ALREADY USED";
            header("Location:executive_request.php?error=$alert_error");
            die();
        }

        $nqur = "SELECT COUNT(DISTINCT day) AS count_day FROM pin_new WHERE id>=$serial_start AND id<=$serial_end and day!=$day";
        $nexe = mysqli_query($conn, $nqur);
        $ndata = mysqli_fetch_array($nexe);
        $count_day = $ndata['count_day'];
        if($count_day > 0) {
            $alert_error = "PACKAGE MISMATCH";
            header("Location:executive_request.php?error=$alert_error");
            die();
        }

        $nqur = "SELECT DISTINCT zone FROM pin_new WHERE id>=$serial_start AND id<=$serial_end AND zone!='' AND ZONE IS NOT NULL;";
        $nexe = mysqli_query($conn, $nqur);
        $ndata = mysqli_fetch_array($nexe);
        if($ndata) {
            $n_zone = $ndata['zone'];
            // $alert = "PACKAGE ALREADY ASSIGNED TO ANOTHER ZONE";
            $alert_error = "PIN ALREADY ASSIGNED TO " . $n_zone;
            header("Location:executive_request.php?error=$alert_error");
            die();
        }

        //insert query
        $query = "INSERT INTO requests (zone, serial_start, serial_end, day, package_name, approved, requested_by, requested_time) values ('$zone', '$serial_start', '$serial_end', '$day', '$package_name', 0, '$login_session', NOW())";
        $exc = mysqli_query($conn, $query); 

        $alert_success= "SUCCESS - ADDED FOR APPROVAL";
        header("Location: ./executive_request.php?success=$alert_success");
        die();

    }

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

        <title>Carnival</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">CARNIVAL</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="executive_home.php">All Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="executive_request.php">New Request</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto"> 
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php if(isset( $alert_error )) { ?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <?php echo $alert_error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
            <?php if(isset( $alert_success )) { ?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <?php echo $alert_success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
            <h3 class="text-center bg-light mt-1 mb-1 pt-2 pb-2">New Pin Request</h3>
            <div class="container mt-3" style="max-width: 600px">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25" id="serial_start">Serial Start ID</span>
                        <input type="number" name="serial_start" class="form-control" placeholder="XXX" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25" id="serial_end">Serial End ID</span>
                        <input type="number" name="serial_end" class="form-control" placeholder="XXX" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25" id="zone">Zone Name</span>
                        <select class="form-select" name="zone" required>
                            <option selected>Select</option>
                            <?php 
                                $pqur = "SELECT * FROM zone_table";
                                $pres = mysqli_query($conn, $pqur);
                                while ($row = mysqli_fetch_assoc($pres)) { ?>
                                    <option value="<?php echo $row['zone']?>"><?php echo $row['zone'] ?></option>
                                <?php }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text w-25" id="package_name">Package List</span>
                        <select class="form-select" name="package_name" required>
                            <option selected>Select</option>
                            <?php 
                                $pqur = "SELECT * FROM zone_table";
                                $pres = mysqli_query($conn, $pqur);
                                while ($row = mysqli_fetch_assoc($pres)) {
                                    
                                }
                            ?>
                            <option value="7 TK">7 TK</option>
                            <option value="15 TK">15 TK</option>
                            <option value="25 TK">25 TK</option>
                            <option value="50 TK">50 TK</option>
                            <option value="249 TK">249 TK</option>
                            <option value="599 TK">599 TK</option>
                            <option value="899 TK">899 TK</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" name="submit" class="btn btn-primary w-25">Submit</button>
                    </div>
        
                </form>

            </div>

        </div> 



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <?php unset($alert_error); ?>
    </body>
</html>