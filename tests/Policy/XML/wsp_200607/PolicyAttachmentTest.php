<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Policy\XML\wsp_200607;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Policy\Constants as C;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Address;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\EndpointReference;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\AbstractWspElement;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\AppliesTo;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\ExactlyOne;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\Policy;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyAttachment;
use SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyReference;
use SimpleSAML\WebServices\Security\XML\wsse\Security;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyAttachmentTest
 *
 * @package simplesamlphp/xml-ws-policy
 */
#[Group('wsp')]
#[CoversClass(PolicyAttachment::class)]
#[CoversClass(AbstractWspElement::class)]
final class PolicyAttachmentTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = PolicyAttachment::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsp/200607/PolicyAttachment.xml',
        );
    }


    // test marshalling


    /**
     * Test that creating an PolicyAttachment from scratch works.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr4', StringValue::fromString('testval4'));
        $attr5 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr5', StringValue::fromString('testval5'));

        $some = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $other = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Other</ssp:Chunk>',
        )->documentElement);

        $sec = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Security</ssp:Chunk>',
        )->documentElement);

        $appliesTo = new AppliesTo(
            [
                new EndpointReference(
                    Address::fromString('http://www.fabrikam123.example.com/acct'),
                ),
            ],
            [$attr2],
        );

        $policy = new Policy([new ExactlyOne([])], [$other], AnyURIValue::fromString('phpunit'), [$attr3]);

        $policyReference = new PolicyReference(
            AnyURIValue::fromString('urn:x-simplesamlphp:phpunit'),
            Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
            AnyURIValue::fromString('http://schemas.xmlsoap.org/ws/2004/09/policy/Sha1Exc'),
            [],
            [$attr4],
        );

        $security = new Security([$sec], [$attr5]);

        $policyAttachment = new PolicyAttachment($appliesTo, [$policy, $policyReference], [$security, $some], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($policyAttachment),
        );
    }
}
