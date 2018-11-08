<?php

require_once 'vendor/autoload.php';

$doc = \Fnash\HydraDoc\HydraDoc::fromJson(file_get_contents('thin-docs.hydra-doc.json'));

echo $doc->pretty();
