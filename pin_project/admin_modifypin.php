<?php
    $login_session = 'admin';
    include('db.inc.php');

    if(isset($_GET['alert'])) {
        $alert = $_GET['alert'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $serial_start = $_POST['serial_start'];
        $serial_end = $_POST['serial_end'];

        if($serial_start > $serial_end) {
            $alert = "ERROR - START_ID MUST BE LESS THAN END_ID";
            header("Location: ./admin_modifypin.php?alert=$alert");
            die();
        } 

        $nqur = "SELECT COUNT(id) AS count_state FROM pin_new WHERE id>=$serial_start AND id<=$serial_end AND state!='Unused'";
        $nexe = mysqli_query($conn, $nqur);
        $ndata = mysqli_fetch_array($nexe);
        $count_state = $ndata['count_state'];
        if($count_state > 0) {
            $alert = "PIN ALREADY USED";
            header("Location:admin_modifypin.php?alert=$alert");
            die();
        }

        //now insert
        $query1 = "UPDATE pin_new SET zone = NULL WHERE id>=$serial_start AND id<=$serial_end";
        $exe1 = mysqli_query($conn, $query1);
        $nsql = "INSERT INTO requests (zone, serial_start, serial_end, approved, updated_by, updated_time) VALUES ('released', '$serial_start', '$serial_end', 8, '$login_session', NOW())";
        $nres = mysqli_query($conn, $nsql);
        $alert = "ID " . $serial_start . " TO " . $serial_end . " - ZONE RELEASED";
        if ($exe1 && $nres) {
            // approved
            $alert = "ZONE RELEASED";
            header("Location:admin_modifypin.php?alert=$alert");
            die();
        } 
        else {
            $alert = "FAILED TO RELEASE ZONE";
            header("Location:admin_modifypin.php?alert=$alert");
            die();
        }

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
                        <a class="nav-link" href="admin_requests.php">All Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_home.php">Pending Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_modifypin.php">Release Zone</a>
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
            <?php if(isset( $alert )) { ?>
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <?php echo $alert; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <h3 class="text-center bg-light mt-1 mb-1 pt-2 pb-2">Release Zone</h3>

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
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" name="submit" class="btn btn-warning w-25">Release</button>
                    </div>
            </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <?php unset($alert); ?>
    </body>
</html>