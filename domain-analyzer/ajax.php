<?php
require 'vendor/autoload.php';

$command = new \App\Command\Nslookup();
echo "<ul>";
foreach ($command->run($_POST['search']) as $ip) {
    echo "<li>$ip</li>";
}
echo "</ul>";