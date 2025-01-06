<?php
require_once("utils/_init.php");

$users = $userStorage->findAll();
$teams = $teamStorage->findAll();
$matches = $matchStorage->findAll();

function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['date']);
    $datetime2 = strtotime($element2['date']);
    return $datetime1 - $datetime2;
} 
  
usort($matches, 'date_compare');

?>

<?php require("partials/header.inc.php") ?>
<body>
<style>
  body{
    background-image : url("https://media.istockphoto.com/photos/soccer-field-with-illumination-green-grass-and-cloudy-sky-background-picture-id1293105095?b=1&k=20&m=1293105095&s=170667a&w=0&h=1guu6B_WTHw5B4EShizGVRf3pyeBNNaGbtowrOLVjyM=");
    background-size : 1800px;
  } 
 </style>
<header>
	<div class="overlay">
<h1>The Elte Stadium</h1>
<p> The ELTE Stadium wants the fans to be able to follow the results of their favorite teams.<br>
        You can see all the teams below where you can see matches and check particular team details.
</p>
		</div>
</header>

<div class = "my-all-teams">
<h3 id ="h3Teams">All the teams</h3>
<table>
    <tr>
        <th>Team name</th>
        <th>Based City</th>
    </tr>
    <?php foreach($teams as $id => $team) : ?>
        <tr>
            <?php
                $link = "team.php?teamId=" . $id;
                $text = "<div>";
                $text = $text . "<a href=$link>" . $team['name'] . "</a>";
                $text = $text . "</div>";
            ?>
            <td><?= $text?></td>
            <td><?= $team['city']?></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<div class ="my-5-matches">
<h3 id="h3">Last 5 matches</h3>
<table>
    <tr>
        <th>Date</th>
        <th>Teams</th>
    </tr>
    <?php 
        $count = count($matches) - 1;
    ?>
    <?php for ($i = 0; $i < 5; $i++) : ?>
            <?php if(array_key_exists('score', $matches[$count]['home'][0])) : ?>
        <tr>
            <td><?= $matches[$count]['date']?></td>
            <?php 
                $team1 = $teamStorage->findById($matches[$count]['home'][0]['id'])["name"];
                $team2 = $teamStorage->findById($matches[$count]['away'][0]['id'])["name"];
            ?>
            <td><?= $team1 ?> <?= $matches[$count]['home'][0]['score'] ?? "" ?> - <?= $matches[$count]['away'][0]['score'] ?? "" ?> <?= $team2 ?></td>
            <?php
                $count = $count - 1;
            ?>
        </tr>
        <?php else : ?>
            <?php 
                $count = $count - 1;
                $i = $i - 1;
            ?>
        <?php endif; ?>
    <?php endfor; ?>
</table>
</div>
</div>
</body>