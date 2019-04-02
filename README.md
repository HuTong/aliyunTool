# aliyunTool
阿里云 移动推送和短信接口整合

```
$params = [
    'accessKeyId' => '******',
    'accessKeySecret' => '******',
    'type' => 1,//1通知、2消息
    'client' => 1,//1安卓、2Ios
    'appKey' => '25******20',
    'device' => '25******20',
    'title' => '订单支付成功',
    'body' => '您的订单801201****7618619已支付成功，等等卖家发货',
    'ext' => ['action'=>'orders_pack_paid','id'=>201],
    'env' => 'PRODUCT',
    'activit' => '',
];

(new \app\behavior\Cps())->pushApp($params);


$params = [
	'accessKeyId' => '******',
    'accessKeySecret' => '******',
    'sign' => '签名',
    'mobile' => '153****1283',
    'template' => '模板ID',
    'val' => ['code'=>'123456'],
];

(new \app\behavior\Sms())->pushSms($params);

```
