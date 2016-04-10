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
//echo  '{"number": 21, "url": "https://github.com/crossan007/GitHubIssueBridge/issues/21"}';
//exit;
require "config.php";

$serviceURL = "https://api.github.com/repos/" . $GitHubRepoOwner . "/" . $GitHubRepoName . "/issues";

$receivedData = json_decode(file_get_contents('php://input'));
if(!$receivedData->issueTitle)
{
  return "Error, no title supplied";
}
if(!$receivedData->issueDescription)
{
  return "Error, no description supplied";
}
$postdata = new stdClass();
$postdata->title = FilterInput($receivedData->issueTitle);
$postdata->body = FilterInput($receivedData->issueDescription);
$postdata->labels = array("Web Report");

$curlService = curl_init($serviceURL);

curl_setopt($curlService, CURLOPT_POST, true);
curl_setopt($curlService, CURLOPT_USERPWD, $GitHubUserName . ":" . $GitHubPassword);
curl_setopt($curlService, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
curl_setopt($curlService, CURLOPT_POSTFIELDS, json_encode($postdata));
curl_setopt($curlService,CURLOPT_RETURNTRANSFER,true);

$result = curl_exec($curlService);
if ($result === FALSE)
{
  die(curl_error($curlService));
}
$issue = json_decode($result);
$returnIssue = new stdClass();
$returnIssue->number = $issue->number;
$returnIssue->url = $issue->html_url;
echo json_encode($returnIssue);
?>
