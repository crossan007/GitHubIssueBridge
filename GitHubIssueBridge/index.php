<?php

require "config.php";
if (isset($_POST['issueTitle']))
{
  echo $_POST['issueTitle'];
}
if (isset($_POST['issueDescription']))
{
  echo $_POST['issueDescription'];
}
if (isset($_POST['issueAttachments']))
{
  echo "attachments";
}
?>
