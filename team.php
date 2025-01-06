<?php
require_once("utils/_init.php");

$city = "";
$teams = $teamStorage->findAll();
$matches = $matchStorage->findAll();

if (verify_get("teamId")) {
    foreach ($teams as $id => $team) {
        if($id == $_GET["teamId"]){
            $teamName = $team['name'];
            $city = $team['city'];
            $teamId = $_GET["teamId"];
            break;
        }
    }

    if ($teamName === null) {
        redirect("index.php");
    }
} 
?>

<div style="background-color: #F3F2F2">
<?php require("partials/header.inc.php")?>
    <h1><?= $teamName?></h1>
    <h4>Football team <?= $teamName?> represents the city <?= $city?></h4>
    
    <?php if($teamId == "1") :?>
        <img src="logos/fcb.png" alt="logo" style = "  position: absolute; width: 100px;height: 100px;left : -2px;top : 75px;">
        
        <?php elseif($teamId == "2") : ?>
            <img src="logos/rma.png" alt="logo" style = "  position: absolute; width: 100px;height: 128px;left : 3px;top : 72px;">
            
            <?php elseif($teamId == "3") : ?>
                <img src="logos/liver.png" alt="logo" style = "position: absolute;width: 100px;height: 128px;left : 3px;top : 72px;"> 
                
        <?php elseif($teamId == "4") : ?>
            <img src="logos/bym.png" alt="logo" style = "position: absolute;width: 95px;height: 90px;left : 3px;top : 72px;">   

        <?php elseif($teamId == "5") : ?>
            <img src="logos/mtd.png" alt="logo" style = "position: absolute; width: 100px;height: 100px;left : 3px;top : 72px;">   

        <?php elseif($teamId == "6") : ?>
            <img src="logos/mc.png" alt="logo" style = "position: absolute;width: 100px;height: 101px;left : 3px;top : 72px;">   
               
            <?php elseif($teamId == "7") : ?>
                <img src="logos/psg1.png" alt="logo" style = "position: absolute;width: 101px;height: 95px;left : 3px;top : 72px;">     
                <?php endif; ?>
                <br>
                <br>
            </div>
            <h5 id="h5">Matches <?= $teamName?> played in the league</h5>
            
            <table>
                <tr>
                    <th>Date</th>
        <th>Teams</th>
        <?php if ($auth->authorize(["admin"])): ?>
            <th>Modifying the match</th>
        <?php endif; ?>
    </tr>
    <?php foreach($matches as $id => $match) : ?>
        <?php if($match['home'][0]['id'] == $teamId) : ?>
            <tr>
                <?php 
                    $opponent = $teamStorage->findById($match['away'][0]['id'])["name"];
                ?>
                <td><?= $match['date']?></td>
                <?php if(array_key_exists('score', $match['home'][0])) : ?>
                    <?php if ($match['home'][0]['score'] > $match['away'][0]['score']) : ?>
                        <td style="background-color:#32CD32"><?= $teamName ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $opponent ?></td>
                    <?php elseif($match['home'][0]['score'] < $match['away'][0]['score']) : ?>
                        <td style="background-color:#FF4D4D"><?= $teamName ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $opponent ?></td>
                    <?php elseif($match['home'][0]['score'] == $match['away'][0]['score']) : ?>
                        <td style="background-color:#FFFF00"><?= $teamName ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $opponent ?></td>
                    <?php endif; ?>
                <?php else : ?>
                    <td><?= $teamName ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $opponent ?></td>
                <?php endif; ?>
                <?php if ($auth->authorize(["admin"])): ?>
                    <td>
                        <div class="float-middle">
                            <a class="btn btn-primary" href="modify.php?gameId=<?=$id?>">Modify match</a>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php elseif($match['away'][0]['id'] == $teamId) : ?>
            <tr>
                <?php 
                    $opponent = $teamStorage->findById($match['home'][0]['id'])["name"];
                ?>
                <td><?= $match['date']?></td>
                <?php if(array_key_exists('score', $match['home'][0])) : ?>
                    <?php if ($match['home'][0]['score'] < $match['away'][0]['score']) : ?>
                        <td style="background-color:#32CD32"><?= $opponent ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $teamName ?></td>
                    <?php elseif($match['home'][0]['score'] > $match['away'][0]['score']) : ?>
                        <td style="background-color:#FF4D4D"><?= $opponent ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $teamName ?></td>
                    <?php elseif($match['home'][0]['score'] == $match['away'][0]['score']) : ?>
                        <td style="background-color:#FFFF00"><?= $opponent ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $teamName ?></td>
                    <?php endif; ?>
                <?php else : ?>
                    <td><?= $opponent ?> <?= $match['home'][0]['score'] ?? "" ?> - <?= $match['away'][0]['score'] ?? "" ?> <?= $teamName ?></td>
                <?php endif; ?>
                <?php if ($auth->authorize(["admin"])): ?>
                    <td>
                        <div class="float-middle">
                            <a class="btn btn-primary" href="modify.php?gameId=<?=$id?>">Modify match</a>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>

<h5>Comments</h5>

<?php if ($auth->authorize(["user"])): ?>
    <div id="err"></div>
    <div class="form">
    <div class="form-group">
        <label for="post" class="form-label">Your post message</label>
        <textarea id="post" class="form-control"></textarea>
    </div>
    <button id="send-post" class="btn btn-primary">Send</button>
    </div>
<?php else : ?>
    <div class="form-group">
        <p>You need to log in to post your comment!</p>
    </div>
<?php endif; ?>

<hr>
<?php if ($auth->authorize(["admin"])): ?>
    <div class="float-right">
        <a class="btn btn-primary" href="comments.php?teamId=<?=$_GET["teamId"]?>">Delete Comment</a>
    </div>
<?php endif; ?>
<br>
<br>
<div id="posts"></div>
<script src="view-topic.js"></script>
<?php require("partials/footer.inc.php") ?>