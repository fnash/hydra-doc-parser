# hydra-doc-parser
parser for Hydra documentation

## Install
```bash
$ composer require fnash/hydra-doc-parser dev-master
```



## Use
```php
require_once 'vendor/autoload.php';

$doc = \Fnash\HydraDoc\HydraDoc::fromUrl('https://demo.api-platform.com/docs.jsonld');

echo $doc->pretty();
```
