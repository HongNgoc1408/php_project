<?php
session_start();
include_once __DIR__ . "../../../partials/admin_boostrap.php";
require_once __DIR__ . '../../../partials/connect.php';

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
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


if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_comment = $pdo->prepare("DELETE FROM `reviews` WHERE id = ?");
    $delete_comment->execute([$delete_id]);
    header('location: list_comment.php');
}

?>

<title>Comment</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Danh sách đánh giá</h1>
                    </div>

                    <div class="table-responsive">
                        <form id="product-form" action="" method="POST" enctype="multipart/form-data"
                            class="text_center form-horizontal">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Pid</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    $i = 1;
                                    $select_comment = $pdo->prepare("SELECT * from reviews");
                                    $select_comment->execute();
                                    if ($select_comment->rowCount() > 0) {
                                        while ($fetch_comment = $select_comment->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <td class="pt-4">
                                                    <b>
                                                        <?= htmlspecialchars($i++); ?>
                                                    </b>
                                                </td>

                                                <td class="pt-4">
                                                    <?= htmlspecialchars($fetch_comment['user_id']); ?>
                                                </td>

                                                <td class="pt-4">
                                                    <?= htmlspecialchars($fetch_comment['pid']); ?>
                                                </td>

                                                <td class="col-2">
                                                    <img src="uploaded_img/reviews/<?= htmlspecialchars($fetch_comment['image']); ?>" alt="" width="50%">
                                                </td>

                                                <td class="pt-4">
                                                    <?= htmlspecialchars($fetch_comment['comment']); ?>
                                                </td>

                                                <td class="pt-4">
                                                    <?= htmlspecialchars($fetch_comment['review_time']); ?>
                                                </td>

                                                <td class="pt-4">
                                                    <a class="btn btn-danger" data-id="<?= htmlspecialchars($fetch_comment['id']); ?>"
                                                        data-toggle="modal" data-target="#deleteConfirmationModal">Delete</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        }
                                    }
                                    ?>
                            </table>
                        </form>
                    </div>

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
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa dòng này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a id="deleteLink" href="" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        // JavaScript code to handle delete from modal
        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var Id = button.data('id');

                // Set the delete button link with productId
                var deleteLink = 'list_comment.php?delete=' + Id;
                $('#deleteLink').attr('href', deleteLink);
            });
        });
    </script>


    <?php
    include_once __DIR__ . '../../../partials/admin_footer.php';
