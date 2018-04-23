<?php

    include_once("STUNClient.php");

    error_reporting(E_ERROR);

    $client = new STUNClient();
    $client->setServerAddr("stun.stunprotocol.org");
    $client->createSocket();

    print("NAT TYPE:" . $client->natType2String($client->getNatType()) ."\n");
    print("MAPPED ADDRESS:" . $client->getMappedAddr() . "\n");
