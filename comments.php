<?php
require_once("utils/_init.php");

if (!$auth->authorize(["admin"])) {
    $errors[] = "You have no permission to access this page";
    save_to_flash("errors", $errors);
    redirect("index.php");
  }

  $errors = [];
if(verify_get("teamId")){
    $teamId = $_GET["teamId"];
    $comments = $commentStorage->findAll(["teamid" => $teamId]);
    
}

?>

<?php require("partials/header.inc.php") ?>

<h3>Deleting the comment</h3>
<div class="float-right">
  <a class="btn btn-primary" href="team.php?teamId=<?=$teamId?>">Back</a>
</div>
<p>Here are the all of the comments for the team</p>

<div>
<?php foreach($comments as $id => $comment) : ?>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?=$userStorage->findById($comment["author"])["username"] ?></h5>
        <h6 class="card-subtitle mb-2 text-muted"><?=$comment['date']?></h6>
        <p class="card-text"><?=$comment['text']?></p>
        <div class="float-right">
            <a class="btn btn-primary" href="api/delete-comment.php?teamId=<?=$teamId?>&id=<?=$id?>">Delete</a>
        </div>
      </div>
    </div>
    <br>
<?php endforeach; ?>
</div>