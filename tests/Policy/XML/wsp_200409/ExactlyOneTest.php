<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Policy\XML\wsp_200409;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Policy\XML\wsp_200409\AbstractOperatorContentType;
use SimpleSAML\WebServices\Policy\XML\wsp_200409\AbstractWspElement;
use SimpleSAML\WebServices\Policy\XML\wsp_200409\All;
use SimpleSAML\WebServices\Policy\XML\wsp_200409\ExactlyOne;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WebServices\Policy\XML\wsp_200409\ExactlyOneTest
 *
 * @package simplesamlphp/xml-ws-policy
 */
#[Group('wsp')]
#[CoversClass(ExactlyOne::class)]
#[CoversClass(AbstractOperatorContentType::class)]
#[CoversClass(AbstractWspElement::class)]
final class ExactlyOneTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ExactlyOne::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp/200409/ExactlyOne.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an ExactlyOne from scratch works.
     */
    public function testMarshalling(): void
    {
        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $exactlyOne = new ExactlyOne([new All()], [$chunk]);

        $this->assertFalse($exactlyOne->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($exactlyOne),
        );
    }


    /**
     * Test that creating an empty ExactlyOne from scratch works.
     */
    public function testMarshallingEmpty(): void
    {
        $oc = new ExactlyOne([]);
        $this->assertTrue($oc->isEmptyElement());
    }


    // test unmarshalling


    /**
     * Test that creating an ExactlyOne from XML succeeds.
     */
    public function testUnmarshallingEmptyElement(): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromString(
            '<wsp:ExactlyOne xmlns:wsp="http://schemas.xmlsoap.org/ws/2004/09/policy" />',
        );

        $oc = ExactlyOne::fromXML($xmlRepresentation->documentElement);
        $this->assertTrue($oc->isEmptyElement());
    }
}
