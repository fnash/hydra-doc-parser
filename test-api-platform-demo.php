<?php

require_once 'vendor/autoload.php';

$doc = \Fnash\HydraDoc\HydraDoc::fromUrl('https://demo.api-platform.com/docs.jsonld');

echo $doc->pretty();
