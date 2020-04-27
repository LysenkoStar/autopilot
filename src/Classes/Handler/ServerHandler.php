<?php


namespace App\Classes\Handler;


use VK\CallbackApi\Server\VKCallbackApiServerHandler;

class ServerHandler extends VKCallbackApiServerHandler
{
    const SECRET = 'secretKeyGroup';
    const GROUP_ID = 194693819;
    const CONFIRMATION_TOKEN = 'a0a91093';

    function confirmation(int $group_id, ?string $secret)
    {
        if ($secret === static::SECRET && $group_id === static::GROUP_ID) {
            echo static::CONFIRMATION_TOKEN;
        }
    }

    public function messageNew(int $group_id, ?string $secret, array $object) {
        echo 'ok';
    }

}