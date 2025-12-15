<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the All element
 *
 * @package simplesamlphp/xml-ws-policy
 */
final class All extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
