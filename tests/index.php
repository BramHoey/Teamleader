<?php

spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);
    if ($parts[0] == 'SumoCoders' && $parts[1] == 'Teamleader') {
        unset($parts[0], $parts[1]);
        $root = __DIR__ . DIRECTORY_SEPARATOR . '..';
        $file = '';
        foreach ($parts as $part) {
            $file .= DIRECTORY_SEPARATOR . $part;
        }
        $file .= '.php';
        require_once $root . $file;
    }
});

require_once 'config.php';
require_once '../vendor/autoload.php';

include 'token.php';
include 'refreshtoken.php';
include 'expiredin.php';

use \SumoCoders\Teamleader\Teamleader;

// create instance
$teamleader = new Teamleader(CLIENT_ID,CLIENT_SECRET, USERNAME, PASSWORD, REDIRECT_URL,$token,$refresh,$text);
?>
<html>
<head>
</head>
<body>
<?php
try {
    $response = $teamleader->crmGetContacts(1,1,'evelyn.goffin@kuleuven.be');
} catch (Exception $e) {
    var_dump($e);
}
?>
<pre>
<?=print_r($response);?>
</pre>
<a href="http://dev.teamleader.api"><button>Rerun</button></a>
</body>
</html>
