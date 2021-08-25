<?php
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

//contact_query

//

$query1 = "SELECT * from device_list where state='ACTIVE'";
$exe1 = mysqli_query($conn, $query1);

while ($row1 = mysqli_fetch_array($exe1)) {
    $node_name = $row1['node_name'];
    $node_ip = $row1['node_ip'];
    $last_status = $row1['last_status'];
    $sms_sent = $row1['sms_sent'];

    # PING Test
    exec("ping -c 4 " . $node_ip . " | grep 'received' | awk '{print $4}'", $ping_time);

    // echo $ping_time;
    $res = $ping_time[0];

    if ($res > 0) { //current_state up
        if ($last_status == 'DOWN') { //current_state up, prev_state up, sms_sent true
            //send sms
            $query = "SELECT mobile, email FROM contact_list";
            $exe = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($exe)) {
                $mobile = $row['mobile'];
                $email = $row['email'];

                $body = $node_name . " - " . $node_ip . ": Current status is UP now. \n";

                // SMS Part 

                # ALT EMAIL Part
                // $email = "ammerashraf@protonmail.com";
                $subject = "NODE STATUS - CRITICAL";
                // $body = "STATE CHANGED";
                # $headers = "From: ammer@test.com";

                if (mail($email, $subject, $body)) {
                    echo ("\nEmail successfully sent to $email \n $body \n");
                } else {
                    echo ("\nEmail sending failed...\n");
                }
                # END EMAIL Part

            }

            $query2 = "INSERT INTO sms_log (node_ip, node_name, message, state, entry_time) values ('$node_ip','$node_name', '$body','UP', NOW())";
            $exe2 = $conn->query($query2);

            $query3 = "UPDATE device_list SET last_checked=NOW(),last_status='UP',sms_sent='TRUE' WHERE node_ip='$node_ip';";
            $exe3 = $conn->query($query3);
        } else if ($last_status == 'UP') { //prev up, now up, no need to send sms
            $query4 = "UPDATE device_list SET last_checked=NOW(),last_status='UP',sms_sent='FALSE' WHERE node_ip='$node_ip';";
            $exe4 = mysqli_query($conn, $query4);
        }
    } else { //new state down
        if ($last_status == 'UP') { //current_state down, prev_state up, sms_sent true
            //send sms
            $query = "SELECT mobile, email FROM contact_list";
            $exe = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($exe)) {
                $mobile = $row['mobile'];
                $email = $row['email'];

                $body = $node_name . " - " . $node_ip . ": Current status is DOWN now. \n";

                // SMS Part 

                # ALT EMAIL Part
                // $email = "ammerashraf@protonmail.com";
                $subject = "NODE STATUS - CRITICAL";
                // $body = "STATE CHANGED";
                # $headers = "From: ammer@test.com";

                if (mail($email, $subject, $body)) {
                    echo ("\nEmail successfully sent to $email \n $body \n");
                } else {
                    echo ("\nEmail sending failed...\n");
                }
                # END EMAIL Part

            }

            $query5 = "INSERT INTO sms_log (node_ip, node_name, message, state, entry_time) values ('$node_ip', '$node_name', '$body', 'DOWN', NOW())";
            $exe5 = $conn->query($query5);

            $query6 = "UPDATE device_list SET last_checked=NOW(),last_status='DOWN',sms_sent='TRUE' WHERE node_ip='$node_ip';";
            $exe6 = $conn->query($query6);
        } else if ($last_status == 'DOWN') { //prev down, now down, no need to send sms
            $query7 = "UPDATE device_list SET last_checked=NOW(),last_status='DOWN',sms_sent='FALSE' WHERE node_ip='$node_ip';";
            $exe7 = mysqli_query($conn, $query7);
        }
    }
}
