<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use SimpleSAML\WebServices\Policy\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-ws-policy
 */
abstract class AbstractWspElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_POLICY_200607;

    /** @var string */
    public const NS_PREFIX = 'wsp';

    /** @var string */
    public const SCHEMA = 'resources/schemas/ws-policy-200607.xsd';
}
