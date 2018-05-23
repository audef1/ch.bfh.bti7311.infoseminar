<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 23.05.2018
 * Time: 19:57
 */

include_once("STUNClient.php");

error_reporting(E_ERROR);

$client = new STUNClient();
$client->setServerAddr("stun.stunprotocol.org");
$client->createSocket();

echo "---------<br/>";
echo "<strong>NAT TYPE: </strong>" . $client->natType2String($client->getNatType()) ."<br/>";
echo "---------<br/>";
echo "<strong>SOURCE ADDRESS: </strong>" . $client->getLocalIP() .":" .$client->getLocalPort() . "<br/>";
echo "<strong>MAPPED ADDRESS: </strong>" . $client->getMappedAddr() . "<br/>";
echo "---------<br/>";