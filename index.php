<?php

require_once("virustotalapi.php");

$virustotal = new virustotalapi("APIKEY");

$scan = json_decode($virustotal->fileScan(realpath("file.pdf")),true);
print_r($scan["data"]["id"]);

$report = json_decode($virustotal->fileReport($scan["data"]["id"]),true);
print_r($report["data"]["attributes"]["stats"]);

