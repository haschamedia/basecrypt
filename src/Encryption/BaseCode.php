<?php

namespace BaseCrypt\Encryption;

abstract class BaseCode
{
    protected function chiper(): string
    {
        return config('basecrypt.chiper');
    }

    protected function isValidJson(string $data): bool
    {
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    abstract protected function encrypt(string $data, string $key): string;
    abstract protected function decrypt(string $data, string $key): string;
}