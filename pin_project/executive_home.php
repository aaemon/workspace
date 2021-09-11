<?php
    $login_session = 'ammer';
    include('db.inc.php');

    function background_color ($approved) {
        if($approved == 0) {
            echo "bg-warning";
        }
        else if($approved == 1) {
            echo "bg-success";
        }
        if($approved == 9) {
            echo "bg-danger";
        }
    }

    if(isset($_GET['alert'])) {
        $alert = $_GET['alert'];
    }

    if(isset($_GET['deleteid'])) {
        $deleteid = $_GET['deleteid'];
        // $dqur = "DELETE from device_list WHERE id=$deleteid";
        echo "deleteid";
        $dqur = "UPDATE requests SET approved = 9, updated_by = '$login_session', updated_time = NOW() WHERE id = $deleteid";
        $dres = mysqli_query($conn, $dqur);
        if (!$dres) {
            $alert = "FAILED TO CANCEL";
            header("Location:executive_home.php?alert=$alert");
            die();
        } else {
            $alert = $deleteid . " - CANCELLED";
            echo $alert;
            header("Location:executive_home.php?alert=$alert");
        }
    }

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    else {
        $page = 1;
    }
    
    $num = 25; 
    $start =($page - 1) * 25;

    $query = "SELECT * FROM requests WHERE requested_by = '$login_session' ORDER BY id DESC LIMIT $start, $num";

    $result = mysqli_query($conn, $query);

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
            <?php if(isset( $alert )) { ?>
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <?php echo $alert; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <h3 class="text-center bg-light mt-1 mb-1 pt-2 pb-2">All Requests</h3>


            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                    <th scope="col" class="bg-info">#</th>
                    <th scope="col" class="bg-info">Serial Start</th>
                    <th scope="col" class="bg-info">Serial End</th>
                    <th scope="col" class="bg-info">Zone</th>
                    <th scope="col" class="bg-info">Package</th>
                    <th scope="col" class="bg-info">Request Date</th>
                    <th scope="col" class="bg-info">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $zone = $row['zone'];
                        $serial_start = $row['serial_start'];
                        $serial_end = $row['serial_end'];
                        $serial_end = $row['serial_end'];
                        $day = $row['day']; 
                        $package_name = $row['package_name']; 
                        $approved = $row['approved']; 
                        $requested_by = $row['requested_by']; 
                        $requested_time = $row['requested_time']; 
                        $approved_by = $row['approved_by']; 
                        $approved_time = $row['approved_time']; 
                    ?>
                    <tr>
                        <th class="<?php background_color($approved) ?>"><?php echo $id ?></th>
                        <td><?php echo $serial_start ?></td>
                        <td><?php echo $serial_end ?></td>
                        <td><?php echo $zone ?></td>
                        <td><?php echo $package_name ?></td>
                        <td><?php echo $requested_time ?></td>
                        <td>
                            <?php if($approved == 0) { //pending ?>
                                <a href="executive_home.php?deleteid=<?php echo $id; ?>" class="btn btn-sm btn-danger">Cancel</a>
                            <?php } else if ($approved == 1) { echo "Approved"; }
                                    else if ($approved == 9) { echo "Cancelled"; }
                                    else { echo "Error"; };
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php 
                $pr_query = "SELECT * FROM requests WHERE requested_by='$login_session'";
                $pr_result = mysqli_query($conn, $pr_query);
                $total_record = mysqli_num_rows($pr_result);
                $total_page = ceil($total_record/$num);
            if ($total_record > 25) {
            ?>
            <nav aria-label="Page Navigation">
                <ul class="pagination justify-content-center">
                    <li <?php echo ($page == '1') ? 'class="page-item disabled"': 'class="page-item"'; ?> >
                    <a class="page-link" href="executive_home.php?page=<?php echo ($page - 1) ?>">Previous</a>
                    </li>

                    <?php for ($i=1; $i<=$total_page; $i++) { ?>
                        <li <?php echo ($page == $i) ? 'class="page-item active"': 'class="page-item"'; ?>><a class="page-link" href="executive_home.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php } ?>
                    <li <?php echo ($page == $total_page) ? 'class="page-item disabled"': 'class="page-item"'; ?> >
                    <a class="page-link" href="executive_home.php?page=<?php echo ($page + 1) ?>">Next</a>
                    </li>
                </ul>
            </nav>    
            <?php } ?>        

        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <?php unset($alert); ?>
    </body>
</html>