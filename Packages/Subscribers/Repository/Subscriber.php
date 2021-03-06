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

    /**
     * @param $data
     * @return int|\Subscriber\Model\Subscriber
     */
    public function create($data)
    {
        if($this->mapper->getSubscriberByEmail($data['email']) === null)
        {
            $subscriber = $this->make($data);
            if ($this->mapper->insert($subscriber)) {
                return $this->getSubscriberByEmail($data['email']);
            }
        }
        return null;
    }

    public function getAll(int $page, int $perPage, $args = []): array
    {
        $items = [];
        $data = $this->mapper->getAll($page, $perPage, $args);
        foreach ($data as $item) {
                $items[] = $this->make($item);
        }
        return $items;
    }

    public function getTotalCount(){
        return $this->mapper->getTotalCount();
    }
	public function getAllAjax(int $page, int $perPage): array
	{
		$data = $this->mapper->getAll($page, $perPage);

		return $data;
	}

    public function getSubscriberById(int $userId) : Model
    {
        return $this->make($this->mapper->getSubscriberById($userId));
    }
    
    public function getSubscriberByEmail(string $email)
    {
        $data = $this->mapper->getSubscriberByEmail($email);
        if (!$data) {
            return null;
        }
        return $this->make($data);
    }

    public function update($data)
    {
        $this->mapper->update($this->make($data));
    }
    
    public function delete(int $userId)
    {
        $this->mapper->delete($userId);
    }

    public function getForSending(int $newsletterId, int $page, int $perPage)
    {
        $users = [];
        foreach ($this->mapper->getForSending($newsletterId, $page, $perPage) as $userData) {
            $users[] = $this->make($userData);
        }
        return $users;
    }
    
    private function make($data): Model
    {
        $userId = null;
        $wpUserId = null;
        $email = null;
        $emailStatus = null;
        $actionLink = '';
//        $actionLink = password_hash($data['email'], PASSWORD_BCRYPT, ["cost" => 8]);
        $firstName = '';
        $lastName = '';
        $createdAt = null;
        $updatedAt = null;
        $activeSince = null;

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
        if (isset($data['actionLink'])) {
            $actionLink = $data['actionLink'];
        }
        if (isset($data['activeSince'])) {
            $activeSince = $data['activeSince'];
        }
        
        return new Model($userId, $wpUserId, $email, $emailStatus, $actionLink, $firstName, $lastName, $createdAt, $updatedAt, $activeSince);
    }

    public function confirmUser(Model $user)
    {
        $user->setActiveSince(date("Y-m-d H:i:s"));
        $user->setEmailStatus(Model::STATUS_CONFIRMED);
        $this->mapper->update($user);
    }

    public function getUserBy($field, $value)
    {
        $result = $this->mapper->getUserBy($field, $value);
        if ($result){
            return $this->make($result);
        }
        return null;
    }

    public function unsubscribeUser(Model $user)
    {
       $this->mapper->unsubscribe($user);
    }

}