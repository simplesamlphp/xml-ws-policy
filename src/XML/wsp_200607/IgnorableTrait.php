<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

/**
 * Trait grouping common functionality for elements that can hold an Ignorable attribute.
 *
 * @package simplesamlphp/xml-ws-policy
 *
 * @phpstan-ignore trait.unused
 */
trait IgnorableTrait
{
    /**
     * The Ignorable.
     */
    protected bool $Ignorable;


    /**
     * Collect the value of the Ignorable-property
     */
    public function getIgnorable(): bool
    {
        return $this->Ignorable;
    }


    /**
     * Set the value of the Ignorable-property
     */
    protected function setIgnorable(?bool $Ignorable): void
    {
        $this->Ignorable = $Ignorable ?? false;
    }
}
