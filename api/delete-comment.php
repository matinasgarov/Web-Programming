<?php
require_once("../utils/_init.php");

if (!$auth->authorize(["admin"])) {
    $errors[] = "You have no permission to access this page";
    save_to_flash("errors", $errors);
    redirect("index.php");
  }

  if (verify_get("teamId", "id"))
  {
    $teamsId = $_GET["teamId"];
    $cmtId = $_GET["id"];

    $cmt = $commentStorage->findAll(["teamid" => $teamsId]);
    foreach ($cmt as $id => $comment) 
       {
            if($id == $cmtId)
        {
            unset($cmt[$id]);
            $items = $commentStorage->findAll(["teamid" => $teamsId]);
            foreach ($items as $idd => $item) {
                if($idd == $cmtId){
                    $commentStorage->delete($cmtId);
                    break;
                }
            }
            break;
        }
    }
}

redirect("../comments.php?teamId=" . $_GET['teamId']);
