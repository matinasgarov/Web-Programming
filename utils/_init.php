<?php

session_start();
require_once(__DIR__ . "/input.inc.php");
require_once(__DIR__ . "/storage.inc.php");
require_once(__DIR__ . "/auth.inc.php");
require_once(__DIR__ . "/flash.inc.php");

$teamStorage = new Storage(new JsonIO(__DIR__ . "/../data/teams.json"));
$commentStorage = new Storage(new JsonIO(__DIR__ . "/../data/comments.json"));
$userStorage = new Storage(new JsonIO(__DIR__ . "/../data/users.json"));
$matchStorage = new Storage(new JsonIO(__DIR__ . "/../data/matches.json"));

$auth = new Auth($userStorage);

$errors = load_from_flash("errors", []);
$successes = load_from_flash("successes", []);

function redirect($page) {
  header("Location: ${page}");
  exit();
}