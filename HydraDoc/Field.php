<?php

namespace Fnash\HydraDoc;

class Field
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $isLink;

    /**
     * @var bool
     */
    private $isList;


    public function __construct(string $name, string $type, bool $isLink = false, bool $isList = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->isLink = $isLink;
        $this->isList = $isList;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isLink(): bool
    {
        return $this->isLink;
    }

    /**
     * @return bool
     */
    public function isList(): bool
    {
        return $this->isList;
    }
}
