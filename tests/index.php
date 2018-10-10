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
    $token = $teamleader->getToken();
    $var_str = var_export($token, true);
    $var = "<?php\n\n\$token = $var_str;\n\n?>";
    file_put_contents('token.php', $var);
    $refresh = $teamleader->getRefreshToken();
    $var_str = var_export($refresh, true);
    $var = "<?php\n\n\$refresh = $var_str;\n\n?>";
    file_put_contents('refreshtoken.php', $var);
    $expire = $teamleader->getExpiredDate();
    $var_str = var_export($expire, true);
    $var = "<?php\n\n\$text = $expire;\n\n?>";
    file_put_contents('expiredin.php', $var);
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
