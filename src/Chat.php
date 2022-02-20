<?php 


namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . "/Classes/DB.php";
require dirname(__DIR__) . "/Classes/Chat/User.php";
require dirname(__DIR__) . "/Classes/Chat/Message.php";

class Chat implements MessageComponentInterface{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        $user = new \User;

        $user->setUserToken($queryarray['token']);
        $user->setUserConnectionId($conn->resourceId);
        $user->updateUserConnectionId();

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $data = json_decode($msg, true);
        $message = new \Message;
        $message->setUserToId($data['receiver_user_id']);
        $message->setUserFromId($data['current_user_id']);
        $message->setMessage($data['msg']);
        $timestamp = date('Y-m-d h:i:s');
        $message->setTimeStamp($timestamp);
        $message->sendMessage();

        $user = new \User;
        $user->setUserID($data['current_user_id']);
        $from_user_data = $user->getUserData();
        $from_username = $from_user_data[0]['user_username'];
        $from_profile_picture = $from_user_data[0]['user_profile'];


        $user->setUserID($data['receiver_user_id']);
        $receiver_user_data = $user->getUserData();

        $data['datetime'] = $timestamp;

        $data['user_profile'] = $from_profile_picture;

        $to_connection_id = $receiver_user_data[0]['user_connection_id'];

        foreach ($this->clients as $client) {
            if ($from == $client) {
                // The sender is not the receiver, send to each client connected
                $data['from']  = 'Me';
            }
            else{
                $data['from'] = $from_username;
            }
            if($client->resourceId == $to_connection_id || $from == $client){
                $client->send(json_encode($data));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}



?>