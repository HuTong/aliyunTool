<?php

namespace Aliyun\Api\Push\Request\V20160801;

use Aliyun\Core\RpcAcsRequest;

/**
 * Request of QueryPushStatByMsg
 *
 * @method string getMessageId()
 * @method string getAppKey()
 */
class QueryPushStatByMsgRequest extends RpcAcsRequest
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
            'QueryPushStatByMsg'
        );
    }

    /**
     * @param string $messageId
     *
     * @return $this
     */
    public function setMessageId($messageId)
    {
        $this->requestParameters['MessageId'] = $messageId;
        $this->queryParameters['MessageId'] = $messageId;

        return $this;
    }

    /**
     * @param string $appKey
     *
     * @return $this
     */
    public function setAppKey($appKey)
    {
        $this->requestParameters['AppKey'] = $appKey;
        $this->queryParameters['AppKey'] = $appKey;

        return $this;
    }
}
