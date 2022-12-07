<?php
session_start();

if (!empty($_SESSION["user"])) {
  header("Location: ./");
  exit();
}

$msgContent = NULL;
$msgStyle = "msgBox-info";

if (isset($_GET["createSuccess"])) {
  $msgContent = "Account created successfully.";
  $msgStyle = "msgBox-success";
}

if (!empty($_GET["error"])) {
  switch ($_GET["error"]) {
    case '1':
      $msgContent = "Invalid input.";
      break;

    case '2':
      $msgContent = "User not found.";
      break;
    case '3':
      $msgContent = "Incorrect password.";
      break;
  }
  $msgStyle = "msgBox-error";
}

function getFormValue($item) {
  if (empty($_SESSION["loginForm"]))
    return NULL;
  return !empty($_SESSION["loginForm"][$item]) ? $_SESSION["loginForm"][$item] : NULL;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Login</title>
</head>

<body class="flex items-center justify-center w-full h-screen bg-gradient-0">
  <form class="flex flex-col gap-2 bg-white p-4 rounded-md shadow-md text-xl w-[532px]" action="./database.php"
    method="post">
    <h1 class="w-full text-4xl font-bold text-center">Login</h1>
    <span class="<?php echo $msgStyle;
    echo (empty($msgContent)) ? "hidden" : NULL ?>">
      <?php echo $msgContent ?>
    </span>
    <div class="flex flex-col gap-2">
      <div class="formInput">
        <input type="text" name="username" id="username" value="<?php echo getFormValue("username") ?>" required>
        <label for="username">Username / Email</label>
      </div>
      <div class="formInput">
        <input type="password" name="password" id="password" required>
        <label for="password">Password</label>
      </div>
      <div class="w-full mt-2 text-center">
        <button class="w-full button-primary" type="submit" name="login">Sign In</button>
        <p class="text-lg">Don't have an account yet? <a class="font-medium text-cyan-500 hover:underline"
            href="./register.php">Sign
            Up</a></p>
      </div>
    </div>
  </form>
</body>

</html>

<?php
unset($_SESSION["loginForm"]);
?>