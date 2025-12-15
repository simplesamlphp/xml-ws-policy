<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200409;

use DOMElement;
use SimpleSAML\WebServices\Policy\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the PolicyReference element
 *
 * @package simplesamlphp/xml-ws-policy
 */
final class PolicyReference extends AbstractWspElement implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        [null, 'Digest'],
        [null, 'DigestAlgorithm'],
        [null, 'URI'],
    ];


    /**
     * Initialize a wsp:PolicyReference
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $URI
     * @param \SimpleSAML\XMLSchema\Type\Base64BinaryValue|null $Digest
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $DigestAlgorithm
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        protected AnyURIValue $URI,
        protected ?Base64BinaryValue $Digest = null,
        protected ?AnyURIValue $DigestAlgorithm = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getURI(): AnyURIValue
    {
        return $this->URI;
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\Base64BinaryValue|null
     */
    public function getDigest(): ?Base64BinaryValue
    {
        return $this->Digest;
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getDigestAlgorithm(): ?AnyURIValue
    {
        return $this->DigestAlgorithm;
    }


    /*
     * Convert XML into an wsp:PolicyReference element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getAttribute($xml, 'URI', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'Digest', Base64BinaryValue::class, null),
            self::getOptionalAttribute($xml, 'DigestAlgorithm', AnyURIValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this wsp:PolicyReference to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:Policy to
     * @return \DOMElement This wsp:PolicyReference element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('URI', $this->getURI()->getValue());

        if ($this->getDigest() !== null) {
            $e->setAttribute('Digest', $this->getDigest()->getValue());
        }

        if ($this->getDigestAlgorithm() !== null) {
            $e->setAttribute('DigestAlgorithm', $this->getDigestAlgorithm()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
