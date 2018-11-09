<?php

namespace Fnash\HydraDoc;

use JsonPath\JsonObject;

final class HydraDoc
{
    /**
     * @var JsonObject
     */
    private $jsonObject;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $entrypoint;

    /**
     * @var Resource[]
     */
    private $resources = [];

    /**
     * @param $hydraDocUrl
     *
     * @return self
     */
    public static function fromUrl($hydraDocUrl)
    {
        $jsonld = file_get_contents($hydraDocUrl);

        return static::fromJson($jsonld);
    }

    /**
     * @param $jsonld
     *
     * @return self
     */
    public static function fromJson($jsonld)
    {
        $doc = new static($jsonld);
        $doc->init();

        return $doc;
    }

    public function pretty()
    {
        $pretty = '';

        $resources = $this->resources;
        ksort($resources);

        /* @var Resource $resource */
        foreach ($resources as $resource) {
            $pretty .= sprintf("- %s\n", $resource->getName());

            /* @var $field Field */

            $fields = $resource->getFields();

            ksort($fields);
            foreach ($fields as $field) {

                if ($field->isLink() && $field->isList()) {
                    $pretty .= sprintf("--- %s: %s[]\n", $field->getName(), $field->getType());
                } else {
                    $pretty .= sprintf("--- %s: %s\n", $field->getName(), $field->getType());
                }
            }
        }

        return $pretty;
    }

    private function __construct(string $jsonld)
    {
        $this->jsonObject = new JsonObject($jsonld);
    }

    private function init()
    {
        $this->entrypoint = $this->parseEntrypoint();
        $this->title = $this->parseTitle();

        $resources = $this->parseResources();

        foreach ($resources as $resourceName) {
            $resource = new Resource($resourceName);

            $readableFields = $this->parseReadableFields($resourceName);

            foreach ($readableFields as $fieldName) {
                $field = $this->createField($resourceName, $fieldName);

                if ($field) {
                    $resource->addField($field);
                }
            }

            $this->resources[$resource->getName()] = $resource;
        }
    }

    private function parseReadableFields($resourceName)
    {
        return $this->jsonObject->get(sprintf("$['hydra:supportedClass'][?(@['@id'] == '%s')]['hydra:supportedProperty'][?(@['hydra:readable'] == true)]['hydra:title']", $resourceName));
    }

    private function parseResources()
    {
        return $this->jsonObject->get("$['hydra:supportedClass'][*]['@id']");
    }

    private function parseTitle()
    {
        return $this->jsonObject->get('$["hydra:title"]');
    }

    private function parseEntrypoint()
    {
        return $this->jsonObject->get('$["hydra:entrypoint"]');
    }

    /**
     * @param $resourceName
     * @param $fieldName
     *
     * @return Field|null
     */
    private function createField($resourceName, $fieldName)
    {
        $property = $this->jsonObject->get(sprintf("$['hydra:supportedClass'][?(@['@id'] == '%s')]['hydra:supportedProperty'][?(@['hydra:readable'] == true and @['hydra:title'] == '%s')]['hydra:property']", $resourceName, $fieldName));

        $property = array_pop($property);

        if (!isset($property['range'], $property['@type'])) {
            return null;
        }

        if ($property['@type'] === 'rdf:Property') {
            if (array_key_exists('owl:maxCardinality', $property) && ((int) $property['owl:maxCardinality']) === 1 && strpos($property['range'], '#') === 0) {
                $field = new Field($fieldName, $property['range'], true, false);
            } else {
                $field = new Field($fieldName, $property['range']);
            }
        } elseif ($property['@type'] === 'hydra:Link') {
            $field = new Field($fieldName, $property['range'], true, true);
        }

        return $field;
    }
}
