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

```bash
- #ConstraintViolation
--- message: xmls:string
--- propertyPath: xmls:string
- #ConstraintViolationList
--- violations: #ConstraintViolation
- #Entrypoint
- #Parchment
--- description: xmls:string
--- title: xmls:string
- http://schema.org/Book
--- author: xmls:string
--- description: xmls:string
--- isbn: xmls:string
--- publicationDate: xmls:dateTime
--- reviews: http://schema.org/Review
--- title: xmls:string
- http://schema.org/Review
--- author: xmls:string
--- body: xmls:string
--- book: http://schema.org/Book
--- letter: xmls:string
--- publicationDate: xmls:dateTime
--- rating: xmls:integer
```

