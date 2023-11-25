<?php
session_start();
include_once __DIR__ . "../../../partials/admin_boostrap.php";
require_once __DIR__ . '../../../partials/connect.php';

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
;

if (isset($_POST['submit'])) {
    $name = $_POST['name'];

    $phone = $_POST['phone'];

    $email = $_POST['email'];

    $password = md5($_POST['password']);

    $cpassword = md5($_POST['cpassword']);

    $role = 1;
    $select = $pdo->prepare("SELECT * FROM `user` WHERE email = ?");
    $select->execute([$email]);

    if ($select->rowCount() > 0) {
        $message[] = 'User email already exist!';
    } else {
        if ($password != $cpassword) {
            $message[] = 'Confirm password not matched!';
        } else {
            $insert = $pdo->prepare("INSERT INTO `user`(name, phone, email, password, role) VALUES(?, ?, ?, ?, ?)");
            $insert->execute([$name, $phone, $email, $password, $role]);
            $message[] = 'Add staffs successfully!';
            header('Location: list_staffs.php');
        }
    }
}
;

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($message) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
}
?>

<title>List staffs</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include_once __DIR__ . "../../../partials/admin_header_column.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once __DIR__ . "../../../partials/admin_header.php";
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Thêm nhân viên</h1>
                        <a href="list_staffs.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-solid fa-list fa-sm text-white-50"></i> Danh sách nhân viên</a>
                    </div>

                    <section class="">
                        <div class="container text-center">
                            <h2 class="position-relative d-inline-block">Thông tin nhân viên</h2>
                            <!-- <hr class="mx-auto"> -->
                        </div>

                        <div class="mx-auto container">
                            <div class="card col-md-6 offset-md-3 shadow-sm">
                                <div class="card-body">
                                    <form action="" id="register-form" method='post'
                                        class="text_center form-horizontal">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="register-name" name="name"
                                                placeholder="Name" for="name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="register-phone" name="phone"
                                                placeholder="Phone" for="phone">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="register-email" name="email"
                                                placeholder="Email" for="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="register-password"
                                                name="password" placeholder="Password" for="password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="register-confirm-password"
                                                name="cpassword" placeholder="Confirm Password" for="cpassword">
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="submit" class="btn w-100 btn-primary shadow-sm"
                                                id="register-btn" value="Add staff" name="submit" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once __DIR__ . '../../../partials/admin_footer.php';