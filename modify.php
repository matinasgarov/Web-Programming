<?php
require_once("utils/_init.php");

if (!$auth->authorize(["admin"])) {
    $errors[] = "You have no permission to access this page";
    save_to_flash("errors", $errors);
    redirect("index.php");
  }

$matches = $matchStorage->findAll();
$score1 = null;
$errors = [];

if (verify_get("gameId")){
    foreach ($matches as $id => $match) {
        if($id == $_GET["gameId"]){
            $date = $match['date'];
            $team1 = $match['home'][0]['id'];
            $team2 = $match['away'][0]['id'];
            if(array_key_exists('score', $match['home'][0])){
                $score1 = $match['home'][0]['score'];
                $score2 = $match['away'][0]['score'];
            }
        }
    }
}

if (verify_post("date", "scoreteam1", "scoreteam1") ) {
    
    $newDate = strtotime($_POST["date"]);
    $scoreteam1 = intval($_POST["scoreteam1"]);
    $scoreteam2 = intval($_POST["scoreteam2"]);
  
    if (!$newDate) {
      $errors[] = "Bad format of day";
    } else {
      $pieces = explode("-", $_POST["date"]);
      $day2 = $pieces[0] . "-" . $pieces[1] . "-" . $pieces[2];
    }
  
    if ($scoreteam1 < 0 || $scoreteam2 < 0) {
      $errors[] = "Score should be natural number";
    }

    if (empty($errors)) {
        foreach ($matches as $id => $match) {
            if($id == $_GET["gameId"]){
                $date = $match['date'];
                $team1 = $match['home'][0]['id'];
                $team2 = $match['away'][0]['id'];
                if(array_key_exists('score', $match['home'][0])){
                    $score1 = $match['home'][0]['score'];
                    $score2 = $match['away'][0]['score'];
                }
                // unset($matches[$id]);
                $matches[$id]['date'] = $day2;
                $matches[$id]['home'][0]['score'] = $scoreteam1;
                $matches[$id]['away'][0]['score'] = $scoreteam2;

                $items = $matchStorage->findAll();
                foreach ($items as $idd => $item) {
                    if($idd == $_GET["gameId"]){
                        $matchStorage->update($_GET["gameId"], $matches[$id]);
                        $matches = $matchStorage->findAll();
                        break;
                    }
                }
                break;
            }
        }
        redirect("index.php");
    }
}

?>

<?php require("partials/header.inc.php") ?>

<h3>Modifying the match</h3>
<p>Here are the previous details</p>

<ul>
    <li>date : <?= $date?></li>
    <li>First team name : <?= $teamStorage->findById($team1)["name"]?></li>
    <li>Second team name : <?= $teamStorage->findById($team2)["name"]?></li>
    <li>Is the game played?  
        <?php 
        if($score1 === null){
            echo "No";
        } else {
            echo "Yes";
        }
    ?>
    </li>
    <?php if($score1 != null) : ?>
        <li> Scores :
            <ul>
                <li><?= $teamStorage->findById($team1)["name"] ?> -> <?= $score1?></li>
                <li><?= $teamStorage->findById($team2)["name"] ?> -> <?= $score2?></li>
            </ul>
        </li>
    <?php endif; ?>
</ul>

<h3>Modify these below or leave them as it is:</h3>

<?php require("partials/errors.inc.php") ?>
<form class="col-md-6 col-xs-12" method="post">
  <div class="form-group">
    <label for="date">Date</label>
    <input class="form-control" type="date" name="date" id="date" value="<?= $_POST["date"] ?? $date ?>">
  </div>
  <div class="form-group">
    <label for="scoreteam1">Score of the <?= $teamStorage->findById($team1)["name"] ?></label>
    <input class="form-control" type="number" name="scoreteam1" id="scoreteam1" value="<?= $scoreteam1 ?? $score1 ?? "" ?>">
  </div>
  <div class="form-group">
    <label for="scoreteam2">Score of the <?= $teamStorage->findById($team2)["name"] ?></label>
    <input class="form-control" type="number" name="scoreteam2" id="scoreteam2" value="<?= $scoreteam2 ?? $score2 ?? "" ?>">
  </div>
  <button class="btn btn-primary">Submit</button>
</form>


<?php require("partials/footer.inc.php") ?>