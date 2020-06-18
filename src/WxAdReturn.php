<?php


namespace WechatAdDataReturn;

use WechatAdDataReturn\RetureData;
use WechatAdDataReturn\CreateDataSource;

/**
 * 广告回传入口。
 * Class WxAdReturn
 * @package WechatAdDataReturn
 */
class WxAdReturn
{


    private $access_token;
    private $appid;
    private $openid;


    /**
     * 初始化类。
     * WxAdReturn constructor.
     * @param $access_token
     * @param $appid            投放关注类广告时推广账号对应的 appid（调用 API 时，必须填写投放账号对应信息，
     * 目前仅支持自身投放账号的关注粉丝归因；）
     * @param $openid
     */
    public function __construct($access_token, $appid, $openid)
    {
        $this->access_token = $access_token;
        $this->appid = $appid;
        $this->openid = $openid;
    }




    /**
     * 创建数据源
     * @param $type         用户行为源类型，请填入『WECHAT』类型
     * @param $name         用户行为源名称,必填，如果不填写，系统自动生成
     * @param $description  用户行为源描述，字段长度最小 1 字节，长度最大 128 字节
     * return array errcode=>"错误码，errmsg=>"错误提示，data['user_action_set_id']=>数据源 ID
     */
    public function CreateDataSourceID($type = "WECHAT", $name = null, $description = null)
    {

        $obj = new CreateDataSource($this->access_token, $this->appid, $name, $description);
        return $obj->run_create();

    }


    /**
     * 执行数据回传
     * @param $user_action_set_id       用于标识数据归属权 (CreateDataSourceID方法中返回)
     * @param string $action_type       预定义的行为类型，目前只支持 COMPLETE_ORDER（ 下单）、RESERVATION（表单预约）以及 REGISTER（注册）
     * @param string $source            转化数据发生的渠道 1)Biz，代表公众号内各种服务或网页 2)Web，代表非公众号的其他渠道
     * @param int $claim_type           0）按点击行为归因  1）按关注行为归因
     * @param string $url               转化行为发生页面的 URL
     * @param null $action_time         行为发生时，客户端的时间点。广告平台使用的是 GMT+8 的时间，容错范围是前后 10 秒，UNIX 时间，单位为秒，如果不填将使用服务端时间填写
     * @param null $product_name        转化对象的名称
     * @param null $product_id          转化对象的 ID，可自定义
     * @return array                    返回数组｛"errcode":0," errmsg ":""}
     */
    public function RunAdDataReture($user_action_set_id, $action_type = "REGISTER", $source = "Biz", $claim_type = 2, $url = "https://e.qq.com", $action_time = null, $product_name = null, $product_id = null)
    {

        $obj = new RetureData($this->access_token, $user_action_set_id, $this->appid);
        return $obj->run_return($this->openid, $claim_type, $action_type, $source, $url, $action_time, $product_name, $product_id);

    }



}