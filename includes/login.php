<?php
session_start();

include 'auth.php';

// If already logged in, redirect to dashboard
if (isUserLoggedIn()) {
    header('Location: ../dashboard.php');
    exit;
}

$error_message = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error_message = 'Please enter both username and password';
    } else {
        $auth_result = authenticateUser($username, $password);
        
        if ($auth_result['success']) {
            startUserSession(
                $auth_result['user_id'],
                $auth_result['username'],
                $auth_result['full_name']
            );
            header('Location: ../dashboard.php');
            exit;
        } else {
            $error_message = $auth_result['error'];
        }
    }
}

// Return JSON response if AJAX request (inpa AI ko ini sir)
if (!empty($_POST) && !empty($error_message)) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $error_message]);
        exit;
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Visitor Log System Login">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Belano - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<form class="form-signin" method="POST" action="">
  <img class="mb-4" src="../img/bootstrap-solid.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-1 font-weight-normal">ACCOUNT LOGIN</h1>
  <p class="mb-3 text-secondary">Signin to the Visitor Log System</p>

  <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <label for="username" class="sr-only">Username</label>
  <div class="input-group mb-2">
    <div class="input-group-prepend">
      <div class="input-group-text"><i class="fas fa-user"></i></div>
    </div>
    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required autofocus>
  </div>
  
  <label for="password" class="sr-only">Password</label>
  <div class="input-group mb-2">
    <div class="input-group-prepend">
      <div class="input-group-text"><i class="fas fa-key"></i></div>
    </div>
    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
  </div>
  
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  
  <div class="mt-4 p-3 bg-light rounded">
    <small class="text-muted">
      Username: <code>pogi</code><br>
      Password: <code>pogi123</code>
    </small>
  </div>

  <p class="mt-5 mb-3 text-muted">&copy; 2025 Belano Visitor Log System</p>
</form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
