<?php
require_once 'config.php';
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập admin</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            margin-top: 100px;
        }
    </style>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $sql = "SELECT user.id, user.email, user.fullname, user.role_id, role.name as role_name
                FROM user 
                JOIN role ON user.role_id = role.id 
                WHERE user.email = :email AND user.password = :password";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['role_name'] == 'Role_Admin') {
                $_SESSION['admin'] = $user['email'];
                header("Location: index.php");
                exit();
            } else {
                header("Location: notadmin.php");
                exit();
            }
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">Sai thông tin đăng nhập</div>';
        }
    }
}
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-container">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Đăng nhập</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="email">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name='btnLogin'>Đăng nhập</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>