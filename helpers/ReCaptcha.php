<?php
class ReCaptcha
{
    /**
     * Constant holding the API url.
     */
    const HOST = 'https://www.google.com/recaptcha/api/siteverify';
    const SECRET = '6LfzXyUTAAAAALt9vjpRBOJFW0cH6vPmhuKPZjBM';

    public function check($code)
    {
        if (empty($code)) {
            return false;
        }

        $q = http_build_query(array(
            'secret' => self::SECRET,
            'response' => $code,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ));

        $response = '';
        if (function_exists('curl_version')) {
            $ch = curl_init(self::HOST . '?' . $q);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch,CURLOPT_TIMEOUT, 1);
            $response = curl_exec($ch);
        } else {
            $response = file_get_contents(self::HOST . '?' . $q);
        }

        if (empty($response) || is_null($response)) {
            return false;
        }

        $json = json_decode($response);
        return $json->success;
    }
}