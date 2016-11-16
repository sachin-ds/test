<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $clientsArr;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "Server started";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        foreach ($this->clients as $client) {
            echo $client->resourceId."\n";
        }
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $messageArr = json_decode($msg);
        
        if($messageArr->type == 'join'){
            $this->clientsArr[$from->resourceId] = $messageArr->name;
            $messageArr->users = $this->clientsArr;            
        }
        foreach ($this->clients as $client) {
            //if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            //}
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        foreach ($this->clients as $client) {
            $client->send(json_encode(array('uID'=>$conn->resourceId, 'type'=>'left', 'name'=>'Test')));
        }
        $this->clients->detach($conn);
        unset($this->clientsArr[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}