<?php
echo "#############################\n";

# Database Connection
$server = "localhost";
$username = "";
$password = "";
$database = "sms_project";

$conn =  new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Error: " . $conn->connect_error);
    echo 'Connection Error';
}

//Query in Original table and add new entry
$query1 = "SELECT * FROM devices";
$exe1 = mysqli_query($conn, $query1);
while ($row1 = mysqli_fetch_array($exe1)) {
    $hostname = $row1['hostname']; 
    $sysName = $row1['sysName']; 
    $status = $row1['status']; 
    $last_ping = $row1['last_ping'];

    //check if hostname is new in libre_device_list
    $query2 = "SELECT node_ip FROM libre_device_list where node_ip='$hostname'";
    $exe2 = mysqli_query($conn, $query2);
    if (mysqli_num_rows($exe2) != 0) { //exist already
        // echo "###\n";
    } else { // new entry        
        if($status == '1') {
            $query3 = "INSERT INTO libre_device_list (node_ip, node_name, last_checked, last_status, sms_sent, state, entry_time, last_update) VALUES ('$hostname', '$sysName', NOW(), 'UP', 'FALSE', 'ACTIVE', NOW(), '$last_ping')";
            $exe3 = mysqli_query($conn, $query3);
            echo $hostname . ' - Added';
            echo "\n+++++\n";
        }
        else if($status == '0') {
            $query4 = "INSERT INTO libre_device_list (node_ip, node_name, last_checked, last_status, sms_sent, state, entry_time, last_update) VALUES ('$hostname', '$sysName', NOW(), 'DOWN', 'FALSE', 'ACTIVE', NOW(), '$last_ping')";  
            $exe4 = mysqli_query($conn, $query4); 
            echo $hostname . ' - Added';
            echo "\n-----\n";      
        } 
        else {
            echo "!!!"; //STATUS ERROR 
        }
    }
} //added

//new query to fetch all entry in original table
$query5 = "SELECT * from libre_device_list where state='ACTIVE'";
$exe5 = mysqli_query($conn, $query5);
while ($row5 = mysqli_fetch_array($exe5)) {
    $node_name = $row5['node_name'];
    $node_ip = $row5['node_ip'];
    $last_status = $row5['last_status'];
    $sms_sent = $row5['sms_sent'];
    $last_update = $row5['last_update'];

    echo $node_ip; //

    $query6 = "SELECT * from devices where hostname='$node_ip'";
    $exe6 = mysqli_query($conn, $query6);
    $data6 = mysqli_fetch_array($exe6);

    $hostname = $data6['hostname'];
    $sysName = $data6['sysName'];
    $status = $data6['status'];
    $last_ping = $data6['last_ping'];

    if ($hostname == $node_ip) {
        if ($status == '1' && $last_status == 'DOWN') { //SEND SMS
            echo " - Previously DOWN, Now UP";
            $query = "SELECT mobile, email FROM libre_contact_list";
            $exe = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($exe)) {
                $mobile = $row['mobile'];
                $email = $row['email'];
                $body = $node_name . " - " . $node_ip . ": Current status is UP now. \n";

                // SMS Part 
                # ALT EMAIL Part
                echo "\n<<< MAILING >>>";
                $subject = "NODE STATUS - CRITICAL";
                if (mail($email, $subject, $body)) {
                    echo ("\nEmail successfully sent to $email \n $body");
                } else {
                    echo ("\nEmail sending failed...\n");
                }
                # END EMAIL Part
            }

            $query7 = "INSERT INTO libre_libre_sms_log (node_ip, node_name, message, state, entry_time) values ('$node_ip', '$node_name', '$body', 'UP', NOW())";
            $exe7 = $conn->query($query7);

            $query8 = "UPDATE libre_device_list SET last_checked=NOW(), last_status='UP', sms_sent='TRUE', last_update='$last_ping' WHERE node_ip='$node_ip';";
            $exe8 = $conn->query($query8);
        } else if ($status == '1' && $last_status == "UP") { //NO SMS
            echo " - Previously UP, Now UP";
            $query19 = "UPDATE libre_device_list SET last_checked=NOW(), last_status='UP', sms_sent='FALSE', last_update='$last_ping' WHERE node_ip='$node_ip';";
            $exe9 = mysqli_query($conn, $query19);
        } else if ($status == '0' && $last_status == "UP") { //SEND SMS
            echo " - Previously UP, Now DOWN";
            $query = "SELECT mobile, email FROM libre_contact_list";
            $exe = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($exe)) {
                $mobile = $row['mobile'];
                $email = $row['email'];
                $body = $node_name . " - " . $node_ip . ": Current status is DOWN now. \n";

                // SMS Part 
                # ALT EMAIL Part
                echo "\n<<< MAILING >>>";
                $subject = "NODE STATUS - CRITICAL";
                if (mail($email, $subject, $body)) {
                    echo ("\nEmail successfully sent to $email \n $body");
                } else {
                    echo ("\nEmail sending failed...\n");
                }
                # END EMAIL Part
            }

            $query10 = "INSERT INTO libre_sms_log (node_ip, node_name, message, state, entry_time) values ('$node_ip', '$node_name', '$body', 'DOWN', NOW())";
            $exe10 = $conn->query($query10);

            $query11 = "UPDATE libre_device_list SET last_checked=NOW(), last_status='DOWN', sms_sent='TRUE' WHERE node_ip='$node_ip';";
            $exe11 = $conn->query($query11);
        } else if ($status == '0' && $last_status == "DOWN") { //NO SMS
            echo " - Previously DOWN, Now DOWN";
            $query12 = "UPDATE libre_device_list SET last_checked=NOW(), last_status='DOWN', sms_sent='FALSE' WHERE node_ip='$node_ip';";
            $exe12 = mysqli_query($conn, $query12);
        } else {
            echo "All Condition Skipped";
        }
    } else {
        echo "Unknown Issue"; //$hostname != $node_ip
    }
    echo "\n*****\n";
}
echo "#############################\n";
?>