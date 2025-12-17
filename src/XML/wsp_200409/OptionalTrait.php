<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200409;

/**
 * Trait grouping common functionality for elements that can hold an Optional attribute.
 *
 * @package simplesamlphp/xml-ws-policy
 *
 * @phpstan-ignore trait.unused
 */
trait OptionalTrait
{
    /**
     * The Optional.
     */
    protected bool $Optional;


    /**
     * Collect the value of the Optional-property
     */
    public function getOptional(): bool
    {
        return $this->Optional;
    }


    /**
     * Set the value of the Optional-property
     */
    protected function setOptional(?bool $Optional): void
    {
        $this->Optional = $Optional ?? false;
    }
}
