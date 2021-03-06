<?php

namespace Aliyun\Api\Push\Request\V20160801;

use Aliyun\Core\RpcAcsRequest;

/**
 * Request of ListSummaryApps
 *
 */
class ListSummaryAppsRequest extends RpcAcsRequest
{

    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'Push',
            '2016-08-01',
            'ListSummaryApps'
        );
    }
}
