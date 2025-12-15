<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Policy\XML\wsp_200409;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Policy\Constants as C;
use SimpleSAML\WebServices\Policy\XML\wsp_200409\AbstractWspElement;
use SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyReference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyReferenceTest
 *
 * @package simplesamlphp/xml-ws-policy
 */
#[Group('wsp')]
#[CoversClass(PolicyReference::class)]
#[CoversClass(AbstractWspElement::class)]
final class PolicyReferenceTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PolicyReference::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp/200409/PolicyReference.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an PolicyReference from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));

        $pr = new PolicyReference(
            AnyURIValue::fromString('urn:x-simplesamlphp:phpunit'),
            Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
            AnyURIValue::fromString('http://schemas.xmlsoap.org/ws/2004/09/policy/Sha1Exc'),
            [$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($pr),
        );
    }
}
