<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy;

/**
 * Class holding constants relevant for WS-Policy.
 *
 * @package simplesamlphp/xml-ws-policy
 */

class Constants extends \SimpleSAML\WebServices\Security\Constants
{
    /**
     * The namespace for WS-Policy protocol.
     */
    public const NS_POLICY_200409 = 'http://schemas.xmlsoap.org/ws/2004/09/policy';

    /**
     * The namespace for WS-Policy 1.5 protocol.
     */
    public const NS_POLICY_200607 = 'http://www.w3.org/2006/07/ws-policy';
}
