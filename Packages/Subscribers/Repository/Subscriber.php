<?php


namespace Subscriber\Repository;

use Subscriber\Mapper\Subscriber as Mapper;
use Subscriber\Model\Subscriber as Model;

class Subscriber
{
    /**
     * @var Mapper
     */
    private $mapper;

     /**
     * ProductDiscount constructor.
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function create($data): ?int
    {
        return $this->mapper->insert($this->make($data));
    }

    public function getAll(int $page, int $perPage): array
    {
        $items = [];
        $data = $this->mapper->getAll($page, $perPage);
        foreach ($data as $item) {
                $items[] = $this->make($item);
        }
        return $items;
    }

    public function getNewsletterById(int $userId) : Model
    {
        return $this->make($this->mapper->getSubscriberById($userId));
    }

    public function update($data): void
    {
        $this->mapper->update($this->make($data));
    }
    
    public function delete(int $userId): void
    {
        $this->mapper->delete($userId);
    }
    
    private function make($data): Model
    {
        $userId = null;
        $wpUserId = null;
        $email = null;
        $emailStatus = null;
        $firstName = null;
        $lastName = null;
        $createdAt = null;
        $updatedAt = null;

        if (isset($data['userId'])){
            $userId = $data['userId'];
        }
        if (isset($data['wpUserId'])) {
            $wpUserId = $data['wpUserId'];
        }
        if (isset($data['email'])) {
            $email = $data['email'];
        }
        if (isset($data['emailStatus'])) {
            $emailStatus = $data['emailStatus'];
        }
        if (isset($data['firstName'])) {
            $firstName = $data['firstName'];
        }
        if (isset($data['lastName'])) {
            $lastName = $data['lastName'];
        }
        if (isset($data['createdAt'])) {
            $createdAt = $data['createdAt'];
        }
        if (isset($data['updatedAt'])) {
            $updatedAt = $data['updatedAt'];
        }
        
        return new Model($userId, $wpUserId, $email, $emailStatus, $firstName, $lastName, $createdAt, $updatedAt);
    }
    
}