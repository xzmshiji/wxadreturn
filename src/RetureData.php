<?php


namespace WechatAdDataReturn;
use WechatAdDataReturn\Helpers;

/**
 * 开始数据回传
 * Class RetureData
 * @package WechatAdDataReturn
 */
class RetureData
{

    private $access_token;
    private $user_action_set_id;
    private $wechat_app_id;
    private $api_url;


    public function __construct($access_token, $user_action_set_id, $wechat_app_id)
    {

        $this->access_token = $access_token;
        $this->user_action_set_id = $user_action_set_id;
        $this->wechat_app_id = $wechat_app_id;
        $this->api_url = "https://api.weixin.qq.com/marketing/user_actions/add?version=v1.0&access_token=" . $access_token;

    }


    /**
     * 执行数据回传。
     */
    public function run_return($openid, $claim_type = 1, $action_type = "REGISTER", $source = "Web", $url = "https://e.qq.com", $action_time = null, $product_name = null, $product_id = null)
    {

        $data = [
            "actions" => [
            [
                "user_action_set_id" => $this->user_action_set_id,
                "url" => $url,
                "action_type"=>$action_type,
                "user_id" => [
                    "wechat_app_id" => $this->wechat_app_id,
                    "wechat_openid" => $openid
                ],
                "action_param"=>[
                    "object"=>"",
                    "source"=>$source,
                    "claim_type"=>$claim_type,
                ]
            ]
        ]
        ];

        if($action_time!=null){
            $data["actions"]["action_time"] = $action_time;
        }
        if($product_id!=null){
            $data["actions"]["action_param"]["product_id"] = $product_id;
        }
        if($product_name!=null){
            $data["actions"]["action_param"]["product_name"] = $product_name;
        }

        $requst_data = json_encode($data);

        $result = Helpers::https_request($this->api_url,$requst_data);

        return json_decode($result,true);

    }


}