<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Policy\XML\wsp_200607;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Policy\Constants as C;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\AbstractOperatorContentType;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\AbstractWspElement;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\ExactlyOne;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\Policy;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyTest
 *
 * @package simplesamlphp/xml-ws-policy
 */
#[Group('wsp')]
#[CoversClass(Policy::class)]
#[CoversClass(AbstractOperatorContentType::class)]
#[CoversClass(AbstractWspElement::class)]
final class PolicyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Policy::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp/200607/Policy.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an Policy from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $policy = new Policy([new ExactlyOne([])], [$chunk], AnyURIValue::fromString('phpunit'), [$attr]);

        $this->assertFalse($policy->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($policy),
        );
    }


    /**
     * Test that creating an empty Policy from scratch works.
     */
    public function testMarshallingEmpty(): void
    {
        $policy = new Policy();
        $this->assertTrue($policy->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test that creating an empty Policy from XML succeeds.
     */
    public function testUnmarshallingEmptyElement(): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromString(
            '<wsp:Policy xmlns:wsp="http://www.w3.org/2006/07/ws-policy" />',
        );

        $policy = Policy::fromXML($xmlRepresentation->documentElement);
        $this->assertTrue($policy->isEmptyElement());
    }
}
