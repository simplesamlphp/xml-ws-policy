<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200409;

use DOMElement;
use SimpleSAML\WebServices\Policy\Assert\Assert;
use SimpleSAML\WebServices\Policy\Constants as C;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\IDTrait;
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
    use IDTrait;
    use SchemaValidatableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:anyAttribute element */
    public const array XS_ANY_ATTR_EXCLUSIONS = [
        ['http://schemas.xmlsoap.org/ws/2004/09/policy', 'Name'],
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Id'],
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
     * @param (\SimpleSAML\WebServices\Policy\XML\wsp_200409\All|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200409\ExactlyOne|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200409\Policy|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyReference
     * )[] $operatorContent
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Name
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(
        array $operatorContent = [],
        array $children = [],
        protected ?AnyURIValue $Name = null,
        ?IDValue $Id = null,
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
            && empty($this->getId())
            && empty($this->getAttributesNS())
            && parent::isEmptyElement();
    }


    /*
     * Convert XML into an wsp:Policy element
     *
     * @param \DOMElement $xml The XML element we should load
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    #[\Override]
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        $all = All::getChildrenOfClass($xml);
        $exactlyOne = ExactlyOne::getChildrenOfClass($xml);
        $policy = Policy::getChildrenOfClass($xml);
        $policyReference = PolicyReference::getChildrenOfClass($xml);

        return new static(
            array_merge($all, $exactlyOne, $policy, $policyReference),
            self::getChildElementsFromXML($xml),
            self::getOptionalAttribute($xml, 'Name', AnyURIValue::class, null),
            $Id,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this wsp:Policy to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:Policy to
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getName() !== null) {
            $e->setAttribute('Name', $this->getName()->getValue());
        }

        $this->getId()?->toAttribute()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
