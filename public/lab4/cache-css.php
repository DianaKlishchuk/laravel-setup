<?php

header('Content-Type: text/css; charset=UTF-8');
header('Cache-Control: public, max-age=86400');

header(
    'Expires: ' .
    gmdate('D, d M Y H:i:s', time() + 86400) .
    ' GMT'
);

echo "body { background-color: #eef7ff; }\n";
echo "h1 { color: #145da0; }\n";
echo ".cache-message { font-weight: bold; }\n";

?>