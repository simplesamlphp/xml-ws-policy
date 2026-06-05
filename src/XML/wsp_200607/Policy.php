<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use Dom;
use SimpleSAML\WebServices\Policy\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_merge;

/**
 * Class defining the Policy element
 *
 * @package simplesamlphp/xml-ws-policy
 */
final class Policy extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:anyAttribute element */
    public const array XS_ANY_ATTR_EXCLUSIONS = [
        ['http://www.w3.org/2006/07/ws-policy', 'Name'],
    ];

    /** The exclusions for the xs:any element */
    public const array XS_ANY_ELT_EXCLUSIONS = [
        ['http://schemas.xmlsoap.org/ws/2004/09/policy', 'All'],
        ['http://schemas.xmlsoap.org/ws/2004/09/policy', 'ExactlyOne'],
        ['http://schemas.xmlsoap.org/ws/2004/09/policy', 'Policy'],
        ['http://schemas.xmlsoap.org/ws/2004/09/policy', 'PolicyReference'],
    ];


    /**
     * Initialize a wsp:Policy
     *
     * @param (\SimpleSAML\WebServices\Policy\XML\wsp_200607\All|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\ExactlyOne|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\Policy|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyReference
     * )[] $operatorContent
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Name
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        array $operatorContent = [],
        array $children = [],
        protected ?AnyURIValue $Name = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);

        parent::__construct($operatorContent, $children);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getName(): ?AnyURIValue
    {
        return $this->Name;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    final public function isEmptyElement(): bool
    {
        return empty($this->getName())
            && empty($this->getAttributesNS())
            && parent::isEmptyElement();
    }


    /*
     * Convert XML into an wsp:Policy element
     *
     * @param \Dom\Element $xml The XML element we should load
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    #[\Override]
    public static function fromXML(Dom\Element $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $all = All::getChildrenOfClass($xml);
        $exactlyOne = ExactlyOne::getChildrenOfClass($xml);
        $policy = Policy::getChildrenOfClass($xml);
        $policyReference = PolicyReference::getChildrenOfClass($xml);

        return new static(
            array_merge($all, $exactlyOne, $policy, $policyReference),
            self::getChildElementsFromXML($xml),
            self::getOptionalAttribute($xml, 'Name', AnyURIValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this wsp:Policy to XML.
     *
     * @param \Dom\Element|null $parent The element we should add this wsp:Policy to
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::toXML($parent);

        if ($this->getName() !== null) {
            $e->setAttribute('Name', $this->getName()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
