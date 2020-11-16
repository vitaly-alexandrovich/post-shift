<?php
include_once __DIR__ . "/../vendor/autoload.php";

$client = new \PostShift\Client();
print 'New Mail:' . PHP_EOL;
$new = $client->newMail();

print '- Response: ' . $new->toJson() . PHP_EOL . PHP_EOL;

print 'GetList:' . PHP_EOL;
print '- Response: ' . $client->getList($new->getKey()) . PHP_EOL . PHP_EOL;