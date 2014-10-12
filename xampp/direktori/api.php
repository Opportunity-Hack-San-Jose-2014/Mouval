<?php
// This is the API, 2 possibilities: show the app list or show a specific app by id.
// This would normally be pulled from a database but for demo purposes, I will be hardcoding the return values.

function get_categories()
{
  //normally this info would be pulled from a database.
  //build JSON array
  $categories_list = array(array("id" => 1, "name" => "Restaurants"), array("id" => 2, "name" => "Clothing"), array("id" => 3, "name" => "Auto care"), array("id" => 4, "name" => "Entertainment"));
  echo "Checking sms";

  return $categories_list;
}

$possible_url = array("get_categories");

$value = "An error has occurred";

if (isset($_GET["message"]) )
{
    $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
    $msg = $_GET["message"];
    fwrite($myfile, $msg);
    fclose($myfile);
}

if (isset($_GET["number"]) )
{
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    $msg = $_GET["number"];
    fwrite($myfile, $msg);
    fclose($myfile);
}

if (isset($_POST["categories"]))
{
    
}

//return JSON array
//exit(json_encode($value));
?>