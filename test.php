<?php
// 2. When JSON serialized, each "ts" (unix timestamp) should be converted to a standard timestamp in form "YYYY-MM-DD HH:MM:SS" and should be converted to Eastern Timezone (GMT-4)
date_default_timezone_set('America/New_York');

// 1. Parse a data source, in this case chat messages and related users
$string = file_get_contents("data/users.json");
$array = json_decode($string, true);
$stringm = file_get_contents("data/messages.json");
$arraym = json_decode($stringm, true);

$users = Array();
foreach ($array as $row){
$users[] = new User($row['id'], $row['username'], $row['password']);
}

$messages = Array();
foreach ($arraym as $row){
$messages[] = new Message($row['id'], $row['chatid'], strip_tags($row['message']), $row['userid'], $row['ts']);
}

// 2. Create a class to convert the records into PHP objects
class Message {
    public $id, $chatid, $message, $userid, $ts;
    public function __construct($id, $chatid, $message, $userid, $ts){
        $this->id = $id;
        $this->chatid = $chatid;
        $this->message  = $message;
        $this->userid = $userid;
        $this->ts  = $ts;
    }

    public function getMessage(){
        // 2. When JSON serialized, each "ts" (unix timestamp) should be converted to a standard timestamp in form "YYYY-MM-DD HH:MM:SS" and should be converted to Eastern Timezone (GMT-4)
        // 4. When JSON serialized, the corresponding user object should be serialized and included as well
        return Array('id' => $this->id,'chatid' => $this->chatid,'message' => $this->message,'userid' => $this->userid,'name' => getUserFromId($this->userid), 'ts' => date('Y M d H:i:s',$this->ts));
    }
}

// 3. Create a Class to convert user records to PHP objects for use in #2
class User {
    public $id, $name, $password;
    public function __construct($id, $name, $password){
        $this->id = $id;
        $this->name = $name;
        $this->password  = $password;
    }
    // 1. Make sure not to echo or json encode any sensitive data to the front end
    public function getUser(){
        return $this->name;
    }
}

// 3. There should be a method to return the corresponding user based on "userid"
function getUserFromId($id){
    global $users;
    $key = array_search($id, array_column($users, 'id'));
    // 1. Each Message object should be JSON Serializable
    return $users[$key]->getUser();
}

function getMsgFromId($id){
    global $messages;
    $key = array_search($id, array_column($messages, 'id'));
    // 1. Each Message object should be JSON Serializable
    return $messages[$key]->getMessage();
}

function getChatFromId($id){
    global $messages;
    $keys = array_keys(array_column($messages, 'chatid'), $id);
    $chats = Array();
    foreach($keys as $key){
        $chats[] = $messages[$key]->getMessage();
    }
    // 3. Create a way to query by "chatid" parameter to produce a filtered collection of chat message objects in order by "ts" (unix timestamp)
    usort($chats, function($a, $b) {
        return ($a['ts'] < $b['ts']) ? -1 : 1;
    });
    // 1. Each Message object should be JSON Serializable
    return $chats;
}

?>