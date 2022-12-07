<?php

declare(strict_types=1);

$hostname = "localhost";
$username = "root";
$password = "";
$port = 3308;
$dbName = "loginsys";

try {
  $dbConn = mysqli_connect($hostname, $username, $password, $dbName, $port);

  if (isset($_POST["login"])) {
    login($dbConn);
  }
  if (isset($_POST["register"])) {
    register($dbConn);
  }
} catch (Exception $e) {
  echo $e;
}

function login(mysqli $conn) {
  if (empty($_POST["username"]) || empty($_POST["password"])) {
    header("Location: ./login.php?error=1");
    exit();
  }

  session_start();
  $username = $_POST["username"];
  $password = $_POST["password"];

  $user = userExist($conn, $username);
  if (empty($user)) {
    header("Location: ./login.php?error=2");
    exit();
  }

  $_SESSION["loginForm"] = [
    "username" => $username
  ];

  $passwordMatched = password_verify($password, $user["password"]);
  if (!$passwordMatched) {
    header("Location: ./login.php?error=3");
    exit();
  }

  $userData = [
    "id" => $user["id"],
    "username" => $user["username"],
    "firstName" => $user["first_name"],
    "lastName" => $user["last_name"]
  ];
  $_SESSION["user"] = $userData;

  unset($_SESSION["loginForm"]);
  header("Location: ./");
}

function register(mysqli $conn) {
  if (
    empty($_POST["username"]) || empty($_POST["fname"]) ||
    empty($_POST["lname"]) || empty($_POST["dob"]) || empty($_POST["gender"]) ||
    empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["passwordR"])
  ) {
    header("Location: ./register.php?error=1");
    exit();
  }

  session_start();
  $username = $_POST["username"];
  $firstName = $_POST["fname"];
  $lastName = $_POST["lname"];
  $dob = $_POST["dob"];
  $gender = $_POST["gender"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $passwordR = $_POST["passwordR"];

  $_SESSION["regForm"] = [
    "username" => $username,
    "firstName" => $firstName,
    "lastName" => $lastName,
    "email" => $email,
    "dob" => $dob,
    "gender" => $gender,
  ];

  if (!usernameValid($username)) {
    header("Location: ./register.php?error=2");
    exit();
  }

  if (strlen($firstName) < 2 || strlen($lastName) < 2) {
    header("Location: ./register.php?error=3");
    exit();
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ./register.php?error=4");
    exit();
  }

  if (strlen($password) < 8) {
    header("Location: ./register.php?error=5");
    exit();
  }

  if (strcmp($password, $passwordR)) {
    header("Location: ./register.php?error=6");
    exit();
  }

  if (userExist($conn, $username)) {
    header("Location: ./register.php?error=7");
    exit();
  }

  if (userExist($conn, $email)) {
    header("Location: ./register.php?error=8");
    exit();
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO `users` (`username`, `first_name`, `last_name`, `dob`, `gender`, `email`, `password`) 
          VALUES (?, ?, ?, ?, ?, ?, ?);");
  $stmt->bind_param("sssssss", $username, $firstName, $lastName, $dob, $gender, $email, $hashedPassword);
  $result = $stmt->execute();

  if ($result) {
    unset($_SESSION["regForm"]);
    header("Location: ./login.php?createSuccess");
  } else {
    header("Location: ./register.php?error=-1");
  }
}

function usernameValid(string $username) {
  $pattern = "/^([A-Za-z0-9_]){3,15}$/";
  return preg_match($pattern, $username);
}

function userExist(mysqli $conn, string $key) {
  $stmt = $conn->prepare("SELECT * FROM `users` WHERE `username`=? OR `email`=?;");
  $stmt->bind_param("ss", $key, $key);
  $stmt->execute();

  return $stmt->get_result()->fetch_assoc();
}