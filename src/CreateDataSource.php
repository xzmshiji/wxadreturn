<?php


namespace WechatAdDataReturn;
use WechatAdDataReturn\Helpers;
/**
 * 创建广告数据源。
 * Class CreateDataSource
 * @package WechatAdDataReturn
 */
class CreateDataSource
{
    private $url = "https://api.weixin.qq.com/marketing/user_action_sets/add?version=v1.0&access_token=";
    private $access_token;
    private $name;
    private $description;
    private $wechat_app_id;

    public function __construct($access_token, $wechat_app_id, $name = null, $description = null)
    {

        $this->access_token = $access_token;
        $this->url = $this->url . $access_token;
        $this->wechat_app_id = $wechat_app_id;

        if ($name == null) {
            $this->name = $this->make_name();
        } else {
            $this->name = $name;
        }
        if ($description == null) {
            $this->description = "this is wechat ad data return ";
        } else {
            $this->description = $description;
        }

    }



    /**
     * 创建数据源，生成数据源 ID（user_action_set_id）
     * @return mixed
     *{
        "errcode":0, "
        "errmsg":""
        "data": {
            "user_action_set_id": "<USER_ACTION_SET_ID>"
        }
     * }
     *
     */
    public function run_create()
    {

        $data = json_encode([
            "type" => "WECHAT",
            "name" => $this->name,
            "description" => $this->description,
            "wechat_app_id" => $this->wechat_app_id,
        ]);

        $result = Helpers::https_request($this->url, $data);

        return json_decode($result, true);
    }




    private function make_name()
    {
        return "webuser_action_set_" . date("YmdHis") . substr(md5(microtime()), 6, 10);
    }








}