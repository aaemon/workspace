<?php
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "iptsp";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection

    if(!$conn) {
        die('Could not connect: ' . mysql_error());
    }

    // $query = "SELECT zone, COUNT(zone) AS total_live FROM zones WHERE caller_id_number IN (SELECT vicidial_did_log.caller_id_number 
    // FROM vicidial_did_log INNER JOIN live_channels ON vicidial_did_log.channel=live_channels.channel) GROUP BY zone;";
    $query = "SELECT zone, COUNT(zone) AS total_live FROM zones WHERE caller_id_number IN (SELECT vicidial_did_log.caller_id_number 
    FROM vicidial_did_log INNER JOIN live_channels ON vicidial_did_log.channel=live_channels.channel) GROUP BY zone ORDER BY COUNT(zone) DESC;";
    $result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            margin: auto;
            min-width: 500px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;
            font-family: Arial, Helvetica, sans-serif;
        }
        tr:hover {
            background-color: #ccccff;
        }
        th {
            background-color: #6699ff;
            color: white;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>Zone Name</th>
        <th>Live User</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        $zone = $row['zone'];
        $total_live = $row['total_live'];
        ?>
        <tr>
            <td><?php echo $zone ?></td>
            <td><?php echo $total_live ?></td>
        </tr>
    <?php } ?> 
</table>
</body>
</html>



<!-- ////// -->
<!-- <table>
    <tr>
        <th>Zone Name</th>
        <th>Live User</th>
    </tr>
    <?php
	$querydb = "SELECT zone, COUNT(zone) AS total_live FROM test_zones WHERE caller_id_number IN (SELECT vicidial_did_log.caller_id_number 
    FROM vicidial_did_log INNER JOIN live_channels ON vicidial_did_log.channel=live_channels.channel) GROUP BY zone ORDER BY COUNT(zone) DESC;";
	
    $result = mysqli_query($conn, $querydb);
    while ($row = mysqli_fetch_assoc($result)) {
        $zone = $row['zone'];
        $total_live = $row['total_live'];
        ?>
        <tr>
            <td><?php echo $zone ?></td>
            <td><?php echo $total_live ?></td>
        </tr>
    <?php } ?> 
</table>
// -->
