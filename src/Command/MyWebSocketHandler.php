<?php

namespace Household\Command;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MyWebSocketHandler implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Клиент подключился
        $this->clients->attach($conn);
        echo "Новое соединение!\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        foreach ($this->clients as $client) {
            $client->send('privet ot beka');
        }
        if ($data['type'] === 'updateEmail') {
            // Here you would update the email in your database
            $userId = $data['userIdentifier'];
            $newEmail = $data['newEmail'];

            // Assuming you have a function to update the email in the database
            $this->updateUserEmail($userId, $newEmail);

            // Prepare the response
            $response = json_encode([
                'type' => 'emailUpdated',
                'userIdentifier' => $userId,
                'newEmail' => $newEmail
            ]);

            // Send the update to all connected clients
            foreach ($this->clients as $client) {
                $client->send($response);
            }
        }
    }

    private function updateUserEmail($userId, $newEmail) {
        // Implement the logic to update the user's email in your database
        // This is just a placeholder function
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Клиент отключился
        $this->clients->detach($conn);
        echo "Соединение закрыто!\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        // Обработка ошибок
        echo "Ошибка: {$e->getMessage()}\n";
        $conn->close();
    }
}
