<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\Utils;

use DOMNode;
use DOMXPath;
use SimpleSAML\WebServices\Policy\Constants as C;

/**
 * Compilation of utilities for XPath.
 *
 * @package simplesamlphp/xml-ws-policy
 */
class XPath extends \SimpleSAML\XPath\XPath
{
    /*
     * Get a DOMXPath object that can be used to search for WS Security elements.
     *
     * @param \DOMNode $node The document to associate to the DOMXPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \DOMXPath A DOMXPath object ready to use in the given document, with several
     *   ws-related namespaces already registered.
     */
    public static function getXPath(DOMNode $node, bool $autoregister = false): DOMXPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('wsp', C::NS_POLICY_200409);
        $xp->registerNamespace('wsp15', C::NS_POLICY_200607);

        return $xp;
    }
}
