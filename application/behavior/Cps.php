<?php
namespace app\behavior;

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Push\Request\V20160801 as Push;

class Cps
{
    public function pushApp(array $params)
    {
        $type = isset($params['type']) ? $params['type'] : ''; //1通知、2消息
        $client = isset($params['client']) ? $params['client'] : ''; //1安卓、2Ios
        $appKey = isset($params['appKey']) ? $params['appKey'] : '';
        $device = isset($params['device']) ? $params['device'] : '';
        $title = isset($params['title']) ? $params['title'] : '';
        $body = isset($params['body']) ? $params['body'] : '';
        $ext = isset($params['ext']) ? $params['ext'] : '';
        $offline = isset($params['offline']) ? $params['offline'] : true;
        $env = isset($params['env']) ? $params['env'] : 'DEV';
        $activity = isset($params['activit']) ? $params['activit'] : '';

        $title = $title ?:'推送消息';
        $body  = $body ?:'您有一条新的消息,请注意查收';
        $paras = empty($ext) ? '' : json_encode(['ext'=>json_encode($ext)]);

        Config::load();
        $profile = DefaultProfile::getProfile('cn-hangzhou', $params['accessKeyId'], $params['accessKeySecret']);
        $acsClient = new DefaultAcsClient($profile);

        $request = new Push\PushRequest();
        $request->setAppKey($appKey);
        $request->setTarget("DEVICE");
        $request->setTargetValue($device);
        $request->setDeviceType('ALL');
        $request->setPushType($type == 1 ? 'NOTICE':'MESSAGE');

        if($client == 2)
        {
            $request->setiOSApnsEnv($env); // DEV|PRODUCT
        }else{
            $request->setAndroidNotificationChannel('1');
        }
        $request->setTitle($title);
        if($paras && ($type == 1))
        {
            if($client == 2)
            {
                $request->setiOSExtParameters($paras);
            }else{
                $request->setAndroidExtParameters($paras);
                if($activity)
                {
                    $request->setAndroidPopupTitle($title);
                    $request->setAndroidPopupBody($body);
                    $request->setAndroidPopupActivity($activity);
                }
            }
        }
        $request->setBody($type == 1 ? $body:$paras);
        $request->setStoreOffline($offline);

        try{
            $acsResponse = $acsClient->getAcsResponse($request);
            $requestId = $acsResponse->MessageId ?? 0;
        }catch (\Exception $e) {
            $requestId = 0;
        }

        return empty($requestId) ? false:true;
    }
}