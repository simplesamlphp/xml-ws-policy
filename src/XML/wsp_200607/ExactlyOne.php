<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Policy\XML\wsp_200607;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the ExactlyOne element
 *
 * @package simplesamlphp/xml-ws-policy
 */
final class ExactlyOne extends AbstractOperatorContentType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
