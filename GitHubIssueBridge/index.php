<?php

function FilterInput($value)
{
  if (isset($value))
  {
    return $value;
  }
  else
  {
    die("Input requred");
  }
}

require "config.php";

$serviceURL = "https://api.github.com/repos/" . $GitHubRepoOwner . "/" . $GitHubRepoName . "/issues";
$postdata = new stdClass();
$postdata->title = FilterInput($_GET['issueTitle']);
$postdata->body = FilterInput($_GET['issueDescription']);
$postdata->labels = array("Web Report");

$curlService = curl_init($serviceURL);

curl_setopt($curlService, CURLOPT_POST, true);
curl_setopt($curlService, CURLOPT_USERPWD, $GitHubUserName . ":" . $GitHubPassword);
curl_setopt($curlService, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
curl_setopt($curlService, CURLOPT_POSTFIELDS, json_encode($postdata));

$result = curl_exec($curlService);
if ($result === FALSE)
{
  die(curl_error($curlService));
}
?>
