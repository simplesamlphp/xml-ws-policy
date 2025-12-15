<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use DOMElement;
use InvalidArgumentException;
use SimpleSAML\WebServices\Policy\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class representing a wsp:OperatorContentType element.
 *
 * @package simplesamlphp/xml-ws-policy
 *
 * @phpstan-consistent-constructor
 */
abstract class AbstractOperatorContentType extends AbstractWspElement
{
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://www.w3.org/2006/07/ws-policy', 'All'],
        ['http://www.w3.org/2006/07/ws-policy', 'ExactlyOne'],
        ['http://www.w3.org/2006/07/ws-policy', 'Policy'],
        ['http://www.w3.org/2006/07/ws-policy', 'PolicyReference'],
    ];


    /**
     * Initialize a wsp:OperatorContentType
     *
     * @param (\SimpleSAML\WebServices\Policy\XML\wsp_200607\All|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\ExactlyOne|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\Policy|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyReference
     * )[] $operatorContent
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     */
    public function __construct(
        protected array $operatorContent = [],
        array $children = [],
    ) {
        Assert::maxCount($operatorContent, C::UNBOUNDED_LIMIT);
        Assert::maxCount($children, C::UNBOUNDED_LIMIT);
        Assert::allIsInstanceOfAny(
            $operatorContent,
            [All::class, ExactlyOne::class, Policy::class, PolicyReference::class],
            InvalidDOMElementException::class,
        );
        Assert::allIsInstanceOfAny(
            $children,
            [SerializableElementInterface::class],
            InvalidArgumentException::class,
        );

        $this->setElements($children);
    }


    /**
     * @return (\SimpleSAML\XML\Chunk|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\All|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\ExactlyOne|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\Policy|
     *         \SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyReference
     * )[] $operatorContent
     */
    public function getOperatorContent(): array
    {
        return $this->operatorContent;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getOperatorContent())
            && empty($this->getElements());
    }


    /*
     * Convert XML into an wsp:OperatorContentType element
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

        $all = All::getChildrenOfClass($xml);
        $exactlyOne = ExactlyOne::getChildrenOfClass($xml);
        $policy = Policy::getChildrenOfClass($xml);
        $policyReference = PolicyReference::getChildrenOfClass($xml);

        return new static(
            array_merge($all, $exactlyOne, $policy, $policyReference),
            self::getChildElementsFromXML($xml),
        );
    }


    /**
     * Convert this wsp:OperatorContentType to XML.
     *
     * @param \DOMElement|null $parent The element we should add this wsp:OperatorContentType to.
     * @return \DOMElement This wsp:AbstractOperatorContentType element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getOperatorContent() as $n) {
            $n->toXML($e);
        }

        foreach ($this->getElements() as $c) {
            if (!$c->isEmptyElement()) {
                $c->toXML($e);
            }
        }

        return $e;
    }
}
