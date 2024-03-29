<?php
// Start the session
include "./dbconn.php";
session_start();

if ($_SESSION["role"] !== "admin") {
    header("location: ./error/unauthorized.php");
    exit();
}

$role = $_SESSION["role"];
$username = $_SESSION["username"];

if(isset($_POST["submit"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $fullname = $firstName . " " . $lastName;

    $email = $_POST["email"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['roleName'];

    $sql = "INSERT INTO `employees`(`id`, `name`, `email`, `username`, `password`, `role`) 
        VALUES (NULL, '$fullname', '$email', '$username', '$password', '$role')";

    $result = mysqli_query($connect, $sql);

    if ($result) {
        echo "Successfully added the employees";
        header("Location: ./employees.php");
        exit();
    } else {
        echo "Failed to add employees information: " . mysqli_error($connect);
    }
}

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Control Panel">
        <meta name="author" content="Argie Delgado">
        <title>Control Panel | Create Employees</title>
        <!-- Awesome Fonts -->
        <script src="https://kit.fontawesome.com/20fbad04b0.js" crossorigin="anonymous"></script>
        <link href="./css/dashboard.css" rel="stylesheet">
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php
                include "./include/sidebar.php";
            ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php
                        include "./include/topbar.php";
                    ?>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                    <div class="card mb-4">
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="./admin.php">Account Management</a></li>
                                <li class="breadcrumb-item active">Add Employees</li>
                            </ol>
                            <div class="card-body">
                                You can add a employees and make it visible in the table. 
                                <button onclick="openModal()" type="button" style="float: right; color: white;" class="btn btn-info">+ Add Employees</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatablesSimple" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Name</th>
                                                <th scope="col" class="text-center">Username</th>
                                                <th scope="col" class="text-center">Password</th>
                                                <th scope="col" class="text-center">Role</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include "./dbconn.php";
                                                $sql = "SELECT * FROM `employees`";
                                                $result = mysqli_query($connect, $sql);

                                                while ($row = mysqli_fetch_assoc($result)) {

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['name'] ?></td>
                                                        <td><?php echo $row['username'] ?></td>
                                                        <td><?php echo str_repeat('&bull;', strlen($row['password'])); ?></td>
                                                        <td><?php echo $row['role'] ?></td>
                                                        <td>
                                                            <div class="d-flex" style="gap: 10px; justify-content: center;">
                                                                <a href="./editEmployees.php?id=<?php echo $row['id'] ?>" class="btn btn-primary me-3" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="far fa-pen-to-square fs-5"></i>
                                                                </a>
                                                                <a href="./viewEmployees.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="View">
                                                                    <i class="far fa-eye fs-5"></i>
                                                                </a>
                                                                <a href="./delete_row_employees.php?id=<?php echo $row['id'] ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                    <i class="far fa-trash-can fs-5"></i>
                                                                </a>
                                                                <!-- Initialize tooltips -->
                                                                <script>
                                                                    $(function () {
                                                                        $('[data-toggle="tooltip"]').tooltip();
                                                                    });
                                                                </script>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Page Content -->
                </div>
                <!-- End of Main Content -->
                <?php
                    include "./include/footer.php";
                ?>
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <?php
            include "./include/logout.php";
        ?>
        <!-- Modal View Insert-->
        <div id="modal" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="text-muted">Complete the form below to add a new Role<p>
                            <h5 class="modal-title">Add New Role Permission</h5>
                            <button onclick="closeModal()" class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="container d-grid">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="">
                                    <div class="mb-2">
                                        <div class="form-label">First Name:</div>
                                        <input type="text" class="form-control" name="firstName" required>
                                    </div>

                                    <div class="mb-2">
                                        <div class="form-label">Last Name:</div>
                                        <input type="text" class="form-control" name="lastName" required>
                                    </div>

                                    <div class="mb-2" style="display: none;">
                                        <div class="form-label">FullName:</div>
                                        <input type="text" class="form-control" name="adminName">
                                    </div>

                                    <div class="mb-2">
                                        <div class="form-label">Email:</div>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="mb-2">
                                        <div class="form-label">Username:</div>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-label">Password:</div>
                                        <input type="text" class="form-control" name="password" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-label">Role:</div>
                                        <select class="form-select" name="roleName" id="spinnerType" required>
                                                <?php
                                                $roleName = getSpinnerTypesFromDatabase();

                                                foreach ($roleName as $row) {
                                                    $roleName = $row['roleName'];

                                                    echo "<option value='$roleName'>$roleName</option>";
                                                }

                                                function getSpinnerTypesFromDatabase()
                                                {
                                                    include "./dbconn.php";

                                                    $sql = "SELECT roleName FROM `role`";

                                                    $result = mysqli_query($connect, $sql);

                                                    $roleName = array();

                                                    if ($result->num_rows > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $roleName[] = $row;
                                                        }
                                                    }

                                                    return $roleName;
                                                }
                                                ?>
                                            </select>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <button type="reset" class="btn btn-danger" name="Reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="./js/dashboard.js"></script>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="./js/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="./js/sidebarfuntion.js"></script>
        <script src="./js/modalfunction.js"></script>
    </body>
</html>