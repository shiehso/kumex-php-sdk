<?php
include '../vendor/autoload.php';

use KuMEX\SDK\Auth;
use KuMEX\SDK\KuMEXApi;
use KuMEX\SDK\PrivateApi\WebSocketFeed;
use Ratchet\Client\WebSocket;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;

// Set the base uri, default "https://api.kumex.com" for production environment.
// KuMEXApi::setBaseUri('https://api.kumex.com');

$auth = null;
// Need to pass the Auth parameter when subscribing to a private channel($api->subscribePrivateChannel()).
// $auth = new Auth('key', 'secret', 'passphrase');
$api = new WebSocketFeed($auth);

// Use a custom event loop instance if you like
//$loop = Factory::create();
//$loop->addPeriodicTimer(1, function () {
//    var_dump(date('Y-m-d H:i:s'));
//});
//$api->setLoop($loop);

$query    = ['connectId' => uniqid('', true)];
$channels = [
    ['topic' => '/contractMarket/ticker:XBTUSDM'], // Subscribe multiple channels
    ['topic' => '/contractMarket/ticker:XBTUSDTM'],
];

$api->subscribePublicChannels($query, $channels, function (array $message, WebSocket $ws, LoopInterface $loop) use ($api) {
    var_dump($message);

    // Unsubscribe the channel
    // $ws->send(json_encode($api->createUnsubscribeMessage('/market/ticker:ETH-BTC')));

    // Stop loop
    // $loop->stop();
}, function ($code, $reason) {
    echo "OnClose: {$code} {$reason}\n";
});