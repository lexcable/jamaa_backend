<?php

namespace App\Traits;

use AfricasTalking\SDK\AfricasTalking;

trait AfricastalkingTrait
{
    protected $sms;

    public function initAfricastalking()
    {
        $username = config('africastalking.username');
        $apiKey   = config('africastalking.api_key');

        $AT = new AfricasTalking($username, $apiKey);

        $this->sms = $AT->sms();
    }

    public function sendSms($to, $message)
    {
        $this->initAfricastalking();

        return $this->sms->send([
            'to'      => $to,
            'message' => $message
        ]);
    }
}
