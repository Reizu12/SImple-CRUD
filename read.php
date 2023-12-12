<?php
    include 'connection.php';

    if (isset($_POST['Save'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $age = $_POST['age'];

        $sql = "INSERT INTO user (FName, LName, Email, Number, Age) VALUES ('$fname', '$lname', '$email', '$number', $age)";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>$("#addUserModal").modal("hide");</script>';
            echo '<script>$("#successModal").modal("show");</script>';
            header("location: read.php");
        } else {
            die(mysqli_error($conn));
        }
    }

    if (isset($_POST['update'])) {
        $edit_id = $_POST['edit_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $age = $_POST['age'];
    
        $sql = "UPDATE user SET FName='$fname', LName='$lname', Email='$email', Number='$number', Age='$age' WHERE ID='$edit_id'";
        $result = mysqli_query($conn, $sql);
    
        if ($result) {
            echo '<script>$("#updateUserModal").modal("hide");</script>';
            echo '<script>$("#successModal").modal("show");</script>';
            header('location: read.php');
        } else {
            echo "Student Update Failed";
            die(mysqli_error($conn));
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <title>CRUD</title>
    </head>

    <body>
        <div class="read_container">
            <div class="row">
                <div class="col-md-10 mx-auto mt-4">
                    <div class="card-header">
                        <h4 class="header mb-3">User Details
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-border table-striped rounded-3 overflow-hidden scrollable-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Number</th>
                                    <th>Age</th>
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody class="tbody">
                                <?php
                                    $sql = "SELECT * FROM user";
                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                ?>
                                            <tr>
                                                <td> <?php echo $row['ID'] ?> </td>
                                                <td> <?php echo $row['FName'] ?> </td>
                                                <td> <?php echo $row['LName'] ?> </td>
                                                <td> <?php echo $row['Email'] ?> </td>
                                                <td> <?php echo $row['Number'] ?> </td>
                                                <td> <?php echo $row['Age'] ?> </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary action-btn editbtn">Edit</button>
                                                    <input type="hidden" name="id" id="id" value=" <?php echo $row["ID"] ?>">
                                                    <a href="delete.php?ID=<?php echo $row['ID']; ?>"><button type="button" class="btn btn-danger action-btn">Delete</button></a>
                                                </td>
                                            </tr>
                             
                                            <?php 
                                        }
                                    }else{
                                        echo "No Data.";
                                    }
                                    ?>
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!---------------------------------------------------------------- Add User Modal ---------------------------------------------------------------->
        <div class="modal fade modalAdd" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
   
                <div class="modal-body">
                    <form action="" method="POST" autocomplete="off">
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter First Name" required>
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Enter Email" required>
                            </div>
                            <div class="mb-3">
                                <label>Number</label>
                                <input type="text" class="form-control" name="number" placeholder="Enter Phone Number" required>
                            </div>
                            <div class="mb-3">
                                <label>Age</label>
                                <input type="text" class="form-control" name="age" placeholder="Enter Age" required>
                            </div>
                            <div class="mb-4 float-end mt-3">
                                <button type="submit" name="Save" class="btn btn-primary">Save</button>
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!---------------------------------------------------------------- Update User Modal ---------------------------------------------------------------->
    <div class="modal fade modalUpdate" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="" method="POST" autocomplete="off">

                        <input type="hidden" name="edit_id" id="edit_id">

                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label>Number</label>
                                <input type="text" class="form-control" id="number" name="number" required>
                            </div>
                            <div class="mb-3">
                                <label>Age</label>
                                <input type="text" class="form-control" id="age" name="age" required>
                            </div>
                            <div class="mb-4 float-end mt-3">
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------------------------------------- JavaScript ---------------------------------------------------------------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>


        <script>
            $(document).ready(function() {
                $('.editbtn').on('click', function() {
                    console.log("Edit button clicked!");
                    $('#updateUserModal').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.find("td:not(:last-child)").map(function () {
                        return $(this).text().trim();
                    }).get();

                    console.log(data);

                    $('#edit_id').val(data[0]);
                    $('#fname').val(data[1]);
                    $('#lname').val(data[2]);
                    $('#email').val(data[3]);
                    $('#number').val(data[4]);
                    $('#age').val(data[5]);
                });
            });
        </script>

    </body>
</html>