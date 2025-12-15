<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use DOMElement;
use SimpleSAML\WebServices\Policy\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class representing a wsp:URI type
 *
 * @package simplesamlphp/xml-ws-policy
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractURI extends AbstractWspElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = AnyURIValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsp:URI
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $content
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        AnyURIValue $content,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Convert XML into an wsp:URI type element
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
            AnyURIValue::fromString($xml->textContent),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this wsp:URI type to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:URI to.
     * @return \DOMElement This wsp:URI type element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
