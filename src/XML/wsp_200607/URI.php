<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the URI element
 *
 * @package simplesamlphp/xml-ws-policy
 */
final class URI extends AbstractURI implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
