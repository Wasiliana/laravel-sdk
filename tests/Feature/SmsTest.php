<?php

namespace Wasiliana\LaravelSdk\Tests\Feature;

use Tests\TestCase;
use Wasiliana\LaravelSdk\Facades\Sms;

class SmsTest extends TestCase
{
    public function testSend()
    {
        $response = Sms::recipients('254723384144')
            ->message('This cold...Mayoooo!!!')
            ->prefix('test')
            ->send();
        // $response = Sms::send(['254723384144'],'Testing', 'test');

        $this->assertSame($response, ['status' => 'success', 'data' => 'Successfully Dispatched the sms to process'], $strict = false);
    }
}
