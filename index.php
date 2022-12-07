<?php
session_start();

if (empty($_SESSION["user"])) {
  header("Location: ./login.php");
  exit();
}

function getUserData($item)
{
  if (empty($_SESSION["user"]))
    return NULL;
  return !empty($_SESSION["user"][$item]) ? $_SESSION["user"][$item] : NULL;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Welcome</title>
</head>

<body class="flex items-center justify-center w-full h-screen bg-gradient-0">
  <div class="flex flex-col items-center justify-center gap-4 p-3 bg-white rounded-md shadow-md w-96">
    <h1 class="text-4xl font-semibold text-center">Welcome, <br><span
        class="font-bold"><?php echo getUserData("firstName") . " " . getUserData("lastName") ?></span>!
    </h1>
    <a class="px-3 py-2 text-xl text-white rounded-md shadow-md button-primary" href="./logout.php">Sign Out</a>
  </div>
</body>

</html>