<?php
// Start the session
include "./dbconn.php";
session_start();

if ($_SESSION["role"] !== "admin") {
    header("location: ./error/unauthorized.php");
    exit();
}

if(isset($_POST['submit'])) {
    $GroupName = $_POST['groupPermission'];
    $permissions = $_POST['permission'];
    $description = $_POST['description'];

    $permissionString = implode(',', $permissions);

    $sql = "INSERT INTO `grouppermission`(`id`, `groupName`, `groupPermission`, `description`) 
            VALUES (NULL,'$GroupName','$permissionString','$description')";

    $result = mysqli_query($connect, $sql);

    if($result) {
        header("Location: ./defineGroupPermission.php");
        exit();
    } else {
        echo "Failed to add a group permission in the permission group table";
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
        <title>Control Panel | Define Group Permission</title>
        <!-- Awesome Fonts -->
        <script src="https://kit.fontawesome.com/20fbad04b0.js" crossorigin="anonymous"></script>
        <link href="./css/dashboard.css" rel="stylesheet">
        <!-- Select 2 -->
        <link href="./css/select2.min.css" rel="stylesheet" />
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
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="./admin.php">Account Management</a></li>
                            <li class="breadcrumb-item"><a href="./admin.php">Role Base Access Control</a></li>
                            <li class="breadcrumb-item active">Define Group Permission</li>
                        </ol>
                        <h1>Group Role Permission</h1>
                        <br>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="roles">Permission Group Name:</label>
                                <input type="text" class="form-control" name="groupPermission">
                            </div>

                            <div class="mb-3">
                                <label for="permission">Permission:</label>
                                <select class="multiple-select form-select" multiple name="permission[]" id="spinnerType" required>
                                    <?php 
                                        $permissionData = getPermissionSpinnerTypesFromDatabase();  

                                        foreach($permissionData as $permissions) {
                                            $permission = $permissions['permission'];

                                            echo "<option value='$permission'>$permission</option>";
                                        }

                                        function getPermissionSpinnerTypesFromDatabase() {
                                            include "./dbconn.php";

                                            $sql = "SELECT permission FROM `permission`";

                                            $result = mysqli_query($connect, $sql);

                                            $permissionData = array();

                                            if($result->num_rows > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    $permissionData[] = $row;
                                                }
                                            }
                                            
                                            return $permissionData;
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Group Role Description:</div>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-success" name="submit">Submit</button>
                            </div>
                        </form>
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
        <!-- Bootstrap core JavaScript-->
        <script src="./js/dashboard.js"></script>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="./js/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="./js/sidebarfuntion.js"></script>
        <script src="./js/modalfunction.js"></script>
        <!-- Selection 2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(".multiple-select").select2({
                placeholder: '--Permission--',
                allowClear: true    
            });
        </script>
    </body>
</html>