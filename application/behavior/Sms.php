<?php
namespace app\behavior;

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

class Sms
{
    // 统一发送短信接口
    public function pushSms(array $params)
    {
        Config::load();
        $profile = DefaultProfile::getProfile('cn-hangzhou', $params['accessKeyId'], $params['accessKeySecret']);
        DefaultProfile::addEndpoint('cn-hangzhou', 'cn-hangzhou', 'Dysmsapi', 'dysmsapi.aliyuncs.com');

        $acsClient = new DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        $request->setPhoneNumbers($params['mobile']);
        $request->setSignName($params['sign']);
        $request->setTemplateCode($params['template']);

        $val = $params['val'] ?? '';
        if($val)
        {
            $smsVal = json_encode($val, JSON_UNESCAPED_UNICODE);
            $request->setTemplateParam($smsVal);
        }

        try{
            $acsResponse = $acsClient->getAcsResponse($request);
            $requestId = $acsResponse->RequestId ?? 0;
            $message = $acsResponse->Message ?? '';
        }catch (\Exception $e){
            $requestId = 0;
            $message = $e->getMessage();
        }

        $data = [
            'mobile' => $params['mobile'],
            'content' => $val ? json_encode($val):'',
            'state' => $requestId,
            'result' => $message,
        ];

        // TODO 存储短信发送记录

        return true;
    }
}