<?php

namespace BrandStudio\Sms;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Facades\Log;

class SmsService
{

    protected $config;
    protected $httpClient;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new httpClient();
    }

    public function send(string $phone, string $text, array $params = [])
    {
        if (!config('sms.enabled')) {
            Log::info("Prevented sms to {$phone}. Text: ${text}");
            return;
        }

        $promise = $this->httpClient->requestAsync('GET', $this->config['base_url'], [
            'query' => array_merge($params, [
                'login'     => $this->config['login'],
                'phones'    => $phone,
                'mes'       => $text,
                'from'      => $this->config['from'],
                'psw'       => $this->config['psw'],
                'time'      => $this->config['time'],
            ]),
        ]);
        $promise->then(
            function (ResponseInterface $res) use ($phone) {
                Log::info("Sms sent to {$phone} with status: {$res->getStatusCode()}");
            },
            function (RequestException $e) use($phone) {
                Log::error("Sms sending error! Phone: {$phone} {$e->getMessage()}");
            }
        );
        $promise->wait();
    }

}
