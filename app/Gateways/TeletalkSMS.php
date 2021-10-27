<?php

namespace App\Gateways;

use Illuminate\Http\Request;
use Khbd\LaravelSmsBD\Interfaces\SMSInterface;

class TeletalkSMS implements SMSInterface
{
    /**
     * @var array
     */
    protected $settings;

    /**
     * @var bool
     */
    protected $is_success;

    /**
     * @var mixed
     */
    protected $message_id;

    /**
     * @var object
     */
    public $data;


    /**
     * @param $settings
     * @throws \Exception
     */
    public function __construct($settings)
    {
        // initiate settings (username, api_key, etc)

        $this->settings = (object)$settings;
    }

    /**
     * @param $recipient
     * @param $message
     * @param null $params
     * @return object
     */
    public function send(string $recipient, string $message, $params = null)
    {
        // implement the send sms method

        $this->is_success = ''; // define what determines success from the response
        $this->message_id = ''; // reference the message id here. auto generate if not available
        $arr = [
            'is_success' => '',
            'message_id' => ''
            // e.t.c
        ]; // the rest of data that is returned

        $this->data = (object)$arr;

        return $this;
    }

    /**
     * initialize the is_success parameter
     * @return bool
     */
    public function is_successful(): bool
    {
        return $this->is_success;
    }

    /**
     * assign the message ID as received on the response,auto generate if not available
     * @return mixed
     */
    public function getMessageID()
    {
        return $this->message_id;
    }

    /**
     * auto generate if not available
     */
    public function getBalance(): float
    {
        // implement the get balance method
    }


    /**
     * @param Request $request
     * @return object
     */
    public function getDeliveryReports(Request $request)
    {
        // implement the processing of delivery reports here. POST/PUSH implementation encouraged

        $data = [
            'status' => '',//delivery report status (e.g DeliveredToTerminal,Success,Failed)
            'message_id' => '' //the message id for purpose of matching
            // e.t.c
        ]; // the rest of data that is returned

        return (object)$data;
    }
}