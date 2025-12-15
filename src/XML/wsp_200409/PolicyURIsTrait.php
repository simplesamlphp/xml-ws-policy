<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200409;

use SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue;

/**
 * Trait grouping common functionality for elements that can hold a PolicyURI attribute.
 *
 * @package simplesamlphp/xml-ws-policy
 *
 * @phpstan-ignore trait.unused
 */
trait PolicyURITrait
{
    /**
     * The PolicyURI.
     *
     * @var \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue
     */
    protected AnyURIListValue $PolicyURI;


    /**
     * Collect the value of the PolicyURI-property
     *
     * @return \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue
     */
    public function getPolicyURI(): AnyURIListValue
    {
        return $this->PolicyURI;
    }


    /**
     * Set the value of the PolicyURI-property
     *
     * @param \SimpleSAML\XMLSchema\Type\Helper\AnyURIListValue $PolicyURI
     */
    protected function setPolicyURI(AnyURIListValue $PolicyURI): void
    {
        $this->PolicyURI = $PolicyURI;
    }
}
