<?php

namespace BaseCrypt\Encryption;

use BaseCrypt\Encryption\BaseCode;

class BaseCrypt extends BaseCode
{
    private static self $crypt;

    private function __construct()
    {}

    public static function code(
        string|array $data,
        string $key,
        string $mode = 'encrypt'
    ): string|array|null
    {
        if(!isset(self::$crypt)){
            self::$crypt = new self();
        }

        $instance = self::$crypt;

        if(is_string($data)){
            $data = (string) $data;
        }
        elseif(is_array($data)){
            $data = json_encode($data);
        }
        else{
            $data = null;
        }

        if($mode === 'encrypt'){
            $return = $instance->encrypt($data, $key);
            return (string) $return;
        }
        elseif($mode === 'decrypt'){
            $return = $instance->decrypt($data, $key);
            $jsonValidate = function ($d) use ($instance){
                if($instance->isValidJson($d)){
                    return (array) json_decode($d, true);
                }
                return (string) $d;
            };
            return $jsonValidate($return);
        }
        else{
            throw new \Exception("Invalid data type result. #code", [
                'mode' => $mode
            ]);
        }

        return null;
    }

    protected function encrypt(string $data, string $key): string
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->chiper()));
        $encrypted = openssl_encrypt($data, $this->chiper(), $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    protected function decrypt(string $data, string $key): string
    {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, $this->chiper(), $key, 0, $iv);
    }

    private function __clone()
    {}

    public function __wakeup() {
        throw new \Exception("Cannot deserialize a basecrypt. #__wakeup");
    }
}