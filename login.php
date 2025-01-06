<?php
require_once("utils/_init.php");

if (verify_post("username", "password")) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $user = $auth->authenticate($username, $password);
  if ($user === NULL) {
    $errors[] = "Invalid username or password";
  }

  if (empty($errors)) {
    $auth->login($user);
    redirect("index.php");
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
<h1 style = "color : white">Log in</h1>

<?php require("partials/errors.inc.php") ?>

<form class="col-md-6 col-xs-12" method="post">
  <div class="form-group">
    <label for="username" style = "color : white">Username</label>
    <input class="form-control" type="text" name="username" id="username" value="<?= $username ?? "" ?>">
  </div>
  <div class="form-group">
    <label for="password" style = "color : white">Password</label>
    <input class="form-control" type="password" name="password" id="password">
  </div>
  <button class="btn btn-primary">Log in</button>
  <a href="signup.php">If you don't have a user yet, you can sign up here</a>

</form>
</body>
<?php require("partials/footer.inc.php") ?>