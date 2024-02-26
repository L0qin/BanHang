<?php
require_once "includes/header.php";
?>

<div class="col-md-9">
  <h2>Người dùng</h2>

  <div class="card">
    <div class="card-header">
      Danh sách người dùng
    </div>
    <?php
    if (isset($_GET["stat"])) {
      if ($_GET["stat"] == 'thanhcong')
        echo '<div class="alert alert-success text-center" role="alert">Thành Công!</div>';
      if ($_GET["stat"] == 'loi')
        echo '<div class="alert alert-danger text-center" role="alert">Lỗi</div>';
    }
    ?>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once "config.php";

          $stmt = $pdo->query("SELECT * FROM user");
          $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . $user['id'] . '</td>';
            echo '<td>' . $user['email'] . '</td>';
            echo '<td>' . $user['fullname'] . '</td>';

            echo '<td>';
            echo '<a href="subsites/xoauser.php?id=' . $user['id'] . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>';
            echo '</td>';

            echo '</tr>';
          }
          ?>
        </tbody>
      </table>


    </div>
  </div>
</div>

<?php require_once "includes/footer.php" ?>