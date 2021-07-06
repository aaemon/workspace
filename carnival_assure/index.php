<?php
    include('db.inc.php');

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    else {
        $page = 1;
    }
    
    $num = 20; //change num value to max limit in one page
    $start =($page - 1) * 20; //also change this last multiplication value to max limit in one page

    $query = "SELECT username, firstname, lastname, expiration, srvname FROM assure_test WHERE srvname LIKE '200MBPS%' LIMIT $start, $num";

    $result = mysqli_query($ronn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Carnival Assure</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Carnival Assure</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container table-responsive" style="padding-top: 20px">
        <h2 class="text-center bg-light p-2">Carnival Assure User List</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Carnival ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Package</th>
                    <th scope="col">Link</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while ($row = mysqli_fetch_assoc($result)) {
                    $username = $row['username'];
                    $name = $row['firstname'] . " " . $row['lastname'];
                    $expiration = $row['expiration'];
                    $srvname = $row['srvname']; 
                ?>
                <tr>
                    <th scope="col"><?php echo $username ?></th>
                    <td scope="col"><?php echo $name ?></td>
                    <td scope="col"><?php echo $srvname ?></td>
                    <td scope="col"><a href="#" class="btn btn-sm btn-success">Generate</a></td>
                </tr> 
                <?php } ?>
            <tbody>
        </table>
        <?php 
            $pr_query = "SELECT * FROM assure_test WHERE srvname LIKE '200MBPS%'";
            $pr_result = mysqli_query($ronn, $pr_query);
            $total_record = mysqli_num_rows($pr_result);
            $total_page = ceil($total_record/$num);

        ?>

        <nav aria-label="Page Navigation">
            <ul class="pagination justify-content-center">
                <li <?php echo ($page == '1') ? 'class="page-item disabled"': 'class="page-item"'; ?> >
                <a class="page-link" href="index.php?page=<?php echo ($page - 1) ?>">Previous</a>
                </li>

                <?php for ($i=1; $i<=$total_page; $i++) { ?>
                    <li <?php echo ($page == $i) ? 'class="page-item active"': 'class="page-item"'; ?>><a class="page-link" href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php } ?>
                <li <?php echo ($page == $total_page) ? 'class="page-item disabled"': 'class="page-item"'; ?> >
                <a class="page-link" href="index.php?page=<?php echo ($page + 1) ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>