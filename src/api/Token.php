<?php

namespace chuangcache\sdk\api;

class Token extends BaseAPI
{
    private static $token;
    private static $expire;

    /**
     * 返回token
     */
    public function getToken() {
        if (!empty(self::$token) && self::$expire > time()) {
            return self::$token;
        }

        $configJson = file_get_contents(getcwd() . '/config.json');
        $send_data = json_decode($configJson, JSON_UNESCAPED_SLASHES);

        $url = self::$API_URL . '/OAuth/authorize';

        $return = self::httpPost($url, $send_data);
        if ($return['status'] == 1 && !empty($return['data'])) {
            self::$token = $return['data']['access_token'];
            self::$expire = $return['data']['expires_in'];
            return self::$token;
        }
        return '';
    }
}