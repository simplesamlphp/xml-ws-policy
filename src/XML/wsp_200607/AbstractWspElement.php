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
    public const string NS = C::NS_POLICY_200607;

    public const string NS_PREFIX = 'wsp';

    public const string SCHEMA = 'resources/schemas/ws-policy-200607.xsd';
}
