<?php
require_once("../utils/_init.php");
header("Content-Type: application/json; charset=UTF-8");

// if (!$auth->authorize(["user"])) {
//   http_response_code(403); // Forbidden
//   print("{ \"error\" => \"You have to log in to request this information\" }");
//   exit();
// }

if (!verify_post("text", "teamId")) {
  // No text was recieved
  http_response_code(400); // Bad request
  print("{ \"error\" => \"You have to send a team ID and the post text\" }");
  exit();
}


$text = $_POST["text"];
$teamId = $_POST["teamId"];

// Create new post
$commentStorage->add([
  "author" => $auth->authenticated_user()["id"],
  "text" => $text,
  "teamid" => $teamId,
  "date" => date("Y-m-d H:i:s")
]);