<?php
include_once __DIR__ . "/../vendor/autoload.php";

$client = new \PostShift\Client();
print 'New Mail:' . PHP_EOL;
print '- Response: ' . $client->newMail()->toJson() . PHP_EOL . PHP_EOL;

$randomName = 'testname' . rand(1111,9999);
print 'New Mail (with name '.$randomName.'):' . PHP_EOL;
print '- Response: ' . $client->newMail($randomName)->toJson() . PHP_EOL . PHP_EOL;

print 'New Mail (with name '.$randomName.'):' . PHP_EOL;
print '- Response: ' . $client->newMail($randomName)->toJson() . PHP_EOL . PHP_EOL;