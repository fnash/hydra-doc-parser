<?php

namespace Fnash\HydraDoc;

class Resource
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Field[]
     */
    private $fields = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Field $field
     *
     * @return self
     */
    public function addField(Field $field): Resource
    {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
