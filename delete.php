<?php
    include 'connection.php';
    
    if(isset($_GET['ID'])){
        $ID = mysqli_real_escape_string($conn, $_GET['ID']);
        $sql = "DELETE FROM user WHERE ID='$ID'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("location: read.php");
        } else {
            echo "Failed to Delete User: " . mysqli_error($conn);
            die();
        }
    }
?>
