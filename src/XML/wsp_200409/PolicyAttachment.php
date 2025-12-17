<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200409;

use DOMElement;
use SimpleSAML\WebServices\Policy\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_merge;

/**
 * Class representing a wsp:PolicyAttachment element.
 *
 * @package simplesamlphp/xml-ws-policy
 */
final class PolicyAttachment extends AbstractWspElement implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;
    use SchemaValidatableElementTrait;


    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::ANY;


    /**
     * Initialize a wsp:PolicyAttachment
     *
     * @param \SimpleSAML\WebServices\Policy\XML\wsp_200409\AppliesTo $appliesTo
     * @param (
     *   \SimpleSAML\WebServices\Policy\XML\wsp_200409\Policy|
     *   \SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyReference
     * )[] $policies
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected AppliesTo $appliesTo,
        protected array $policies,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        Assert::allIsInstanceOfAny(
            $policies,
            [Policy::class, PolicyReference::class],
            SchemaViolationException::class,
        );

        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the AppliesTo property.
     *
     * @return \SimpleSAML\WebServices\Policy\XML\wsp_200409\AppliesTo
     */
    public function getAppliesTo(): AppliesTo
    {
        return $this->appliesTo;
    }


    /**
     * Collect the value of the Policies property.
     *
     * @return (
     *   \SimpleSAML\WebServices\Policy\XML\wsp_200409\Policy|
     *   \SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyReference
     * )[]
     */
    public function getPolicies(): array
    {
        return $this->policies;
    }


    /*
     * Convert XML into an wsp:PolicyAttachment element
     *
     * @param \DOMElement $xml The XML element we should load
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $appliesTo = AppliesTo::getChildrenOfClass($xml);
        Assert::minCount($appliesTo, 1, MissingElementException::class);
        Assert::maxCount($appliesTo, 1, TooManyElementsException::class);

        $policy = Policy::getChildrenOfClass($xml);
        $policyReference = PolicyReference::getChildrenOfClass($xml);

        $policies = array_merge($policy, $policyReference);
        Assert::minCount($policies, 1, MissingElementException::class);

        return new static(
            $appliesTo[0],
            $policies,
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this wsp:PolicyAttachment to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:AppliesTo to.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getAppliesTo()->toXML($e);

        foreach ($this->getPolicies() as $pol) {
            $pol->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
