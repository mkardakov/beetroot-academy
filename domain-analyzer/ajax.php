<?php
require 'vendor/autoload.php';

$command = new \App\Command\Nslookup();
$output = $command->run($_POST['search']);
$whois = new \App\Command\Whois();
$output = array_merge($output, $whois->run($_POST['search']));
require "templates/main.phtml";