<?php
session_start();

if (!empty($_SESSION["user"])) {
  header("Location: ./");
}

$msgContent = NULL;
$msgStyle = "msgBox-info";

if (isset($_GET["createSuccess"])) {
  $msgContent = "Account created successfully.";
  $msgStyle = "msgBox-success";
}

if (!empty($_GET["error"])) {
  switch ($_GET["error"]) {
    case '-1':
      $msgContent = "Server error.";
      break;
    case '1':
      $msgContent = "Invalid input.";
      break;

    case '2':
      $msgContent = "Username must be at least 3 characters long and can only contain alphanumeric and underscore.";
      break;
    case '3':
      $msgContent = "Name must be at least 2 characters long.";
      break;
    case '4':
      $msgContent = "Invalid email address.";
      break;
    case '5':
      $msgContent = "Password length must be at least 8 characters long.";
      break;
    case '6':
      $msgContent = "Passwords don't match.";
      break;
    case '7':
      $msgContent = "Username already taken.";
      break;
    case '8':
      $msgContent = "Email already in use.";
      break;
  }
  $msgStyle = "msgBox-error";
}

function getFormValue($item)
{
  if (empty($_SESSION["regForm"]))
    return NULL;
  return !empty($_SESSION["regForm"][$item]) ? $_SESSION["regForm"][$item] : NULL;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Register</title>
</head>

<body class="flex items-center justify-center w-full h-screen bg-gradient-0">
  <form class="flex flex-col gap-2 bg-white p-4 rounded-md shadow-md text-xl w-[532px]" action="./database.php"
    method="post">
    <h1 class="text-4xl font-bold text-center">Create an Account</h1>
    <span class="<?php echo $msgStyle;
                  echo (empty($msgContent)) ? "hidden" : NULL ?>"><?php echo $msgContent ?></span>
    <div class="flex flex-col gap-2">
      <div class="formInput">
        <input type="text" name="username" id="username" value="<?php echo getFormValue("username") ?>" required>
        <label for="username">Username</label>
      </div>
      <div class="flex flex-wrap gap-2">
        <div class="formInput">
          <input type="text" name="fname" id="fname" value="<?php echo getFormValue("firstName") ?>" required>
          <label for="fname">First Name</label>
        </div>
        <div class="formInput">
          <input type="text" name="lname" id="lname" value="<?php echo getFormValue("lastName") ?>" required>
          <label for="lname">Last Name</label>
        </div>
      </div>
      <div class="formInput">
        <input type="email" name="email" id="email" value="<?php echo getFormValue("email") ?>" required>
        <label for="email">Email</label>
      </div>
      <div class="flex flex-row gap-2">
        <div class="w-full formInput">
          <input class="" type="date" name="dob" id="dob" value="<?php echo getFormValue("dob") ?>" required>
          <label class="" for="dob">Birth Date</label>
        </div>
        <div class="flex flex-col w-full">
          <?php
          $gender = getFormValue("gender");
          ?>
          <p class="font-medium text-black/60">Gender</p>
          <div class="flex items-center h-full">
            <div class="w-full h-full">
              <input class="hidden peer" type="radio" name="gender" id="gender-male" value="m" checked>
              <label for="gender-male"
                class="flex items-center justify-center w-full h-full p-2 bg-gray-200 border-2 border-r-0 border-gray-400 rounded-l-md peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white">
                <span>Male</span>
              </label>
            </div>
            <div class="w-full h-full">
              <input class="hidden peer" type="radio" name="gender" id="gender-female" value="f"
                <?php echo ($gender === 'f') ? "checked" : NULL ?>>
              <label for="gender-female"
                class="flex items-center justify-center w-full h-full bg-gray-200 border-2 border-l-0 border-gray-400 rounded-r-md peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white">
                <span>Female</span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="formInput">
        <input type="password" name="password" id="password" required>
        <label for="password">Password</label>
      </div>
      <div class="formInput">
        <input type="password" name="passwordR" id="passwordR" required>
        <label for="passwordR">Repeat Password</label>
      </div>
    </div>
    <div class="w-full mt-2 text-center">
      <button class="w-full button-primary" type="submit" name="register">Sign Up</button>
      <p class="text-lg">Already have an account? <a class="font-medium text-cyan-500 hover:underline"
          href="./login.php">Sign In</a></p>
    </div>
  </form>
</body>

</html>

<?php
unset($_SESSION["regForm"]);
?>