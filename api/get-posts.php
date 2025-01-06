<?php 
require_once("../utils/_init.php");
header("Content-Type: application/json; charset=UTF-8");

// if (!$auth->authorize(["user"])) {
//   http_response_code(403); // Forbidden
//   print("{ \"error\" => \"You have to log in to request this information\" }");
//   exit();
// }

if (verify_get("teamId")) {
  $teamId = $_GET["teamId"];
  if ($teamStorage->findById($teamId)) {
    // The requested topic exists
    http_response_code(200);
    // Load all posts with given topic ID
    $posts = $commentStorage->findAll(["teamid" => $teamId]);
    // Add user name information to the response object
    foreach ($posts as $index => $post) {
      // Insert the user's name based on the ID
      $posts[$index]["username"] = $userStorage->findById($post["author"])["username"];
    }
    print(json_encode($posts));
  } else {
    // Topic does not exist
    http_response_code(404); // Not found
    print("{}");
  }
} else {
  // No topicId was given
  http_response_code(400); // Bad request
  print("{}");
}