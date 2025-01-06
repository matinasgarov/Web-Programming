<?php
require_once("utils/_init.php");

if (verify_post("username", "email", "password", "confirm-password")) {
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm-password"];

  if (empty($username)) {
    $errors[] = "Username must not be empty";
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
  }

  if ($auth->user_exists($email)) {
    $errors[] = "This e-mail already used";
  }

  if (strlen($password) < 4) {
    $errors[] = "Password must be at least 4 characters long";
  }

  if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match";
  }

  if (empty($errors)) {
    $successes[] = "Registration successful. Please log in.";
    save_to_flash("successes", $successes);

    $auth->register([
      "username" => $username,
      "email" => $email,
      "password" => $password
    ]);
    redirect("login.php");
  }
}

?>
<?php require("partials/header.inc.php") ?>
<body>
<style>
  body{
    background-image : url("https://t4.ftcdn.net/jpg/02/02/14/83/360_F_202148311_XXPcpHC6X2PLeS71MPIPuGudfI63jas6.jpg");
    background-size : 1550px;
  } 
 </style>
<h1 style = "color : white">Sign up</h1>

<?php require("partials/errors.inc.php") ?>

<form class="col-md-6 col-xs-12" method="post">
  <div class="form-group">
    <label for="username" style = "color : white" >Username</label>
    <input class="form-control" type="text" name="username" id="username" value="<?= $username ?? "" ?>">
  </div>
  <div class="form-group">
    <label for="email" style = "color : white">E-mail</label>
    <input class="form-control" type="text" name="email" id="email" value="<?= $email ?? "" ?>">
  </div>
  <div class="form-group"style = "color : white">
    <label for="password">Password</label>
    <input class="form-control" type="password" name="password" id="password">
  </div>
  <div class="form-group">
    <label for="confirm-password" style = "color : white">Confirm password</label>
    <input class="form-control" type="password" name="confirm-password" id="confirm-password">
  </div>
  <button class="btn btn-primary">Submit</button>
  <a href="login.php">If you already have a user yet, you can log in here</a>

</form>
</body>
<?php require("partials/footer.inc.php") ?>