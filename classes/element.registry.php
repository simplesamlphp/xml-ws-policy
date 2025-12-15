<?php

declare(strict_types=1);

return [
    'http://schemas.xmlsoap.org/ws/2004/09/policy' => [
        'All' => '\SimpleSAML\WebServices\Policy\XML\wsp_200409\All',
        'AppliesTo' => '\SimpleSAML\WebServices\Policy\XML\wsp_200409\AppliesTo',
        'ExactlyOne' => '\SimpleSAML\WebServices\Policy\XML\wsp_200409\ExactlyOne',
        'Policy' => '\SimpleSAML\WebServices\Policy\XML\wsp_200409\Policy',
        'PolicyAttachment' => '\SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyAttachment',
        'PolicyReference' => '\SimpleSAML\WebServices\Policy\XML\wsp_200409\PolicyReference',
    ],
    'http://www.w3.org/2006/07/ws-policy' => [
        'All' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\All',
        'AppliesTo' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\AppliesTo',
        'ExactlyOne' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\ExactlyOne',
        'Policy' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\Policy',
        'PolicyAttachment' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyAttachment',
        'PolicyReference' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\PolicyReference',
        'URI' => '\SimpleSAML\WebServices\Policy\XML\wsp_200607\URI',
    ],
];
