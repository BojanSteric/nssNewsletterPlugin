<?php


namespace Subscriber\Mapper;

use Subscriber\Model\Subscriber as Model;

class Subscriber
{
    /**
     * @var \wpdb
     */
    private $db;
    /**
     * @var string
     */
    private $tableName;

     /**
     * Newsletter constructor.
     */
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->tableName = SUBSCRIBER_TABLE_NAME;
    }

    public function insert(Model $model)
    {
        $this->db->insert($this->tableName,[
            'wpUserId' => $model->getWpUserId(),
            'email' => $model->getEmail(),
            'emailStatus' => $model->getEmailStatus(),
            'actionLink' => $model->getActionLink(),
            'firstName' => $model->getFirstName(),
            'lastName' => $model->getLastName(),
            'createdAt' => $model->getDateCreated(),
            'updatedAt' => $model->getDateUpdated(),
            'activeSince' => $model->getActiveSince(),
        ],['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']);
        return $this->db->insert_id;
    }

    public function update(Model $model)
    {
        $this->db->update($this->tableName,
            [
                'wpUserId' => $model->getWpUserId(),
                'email' => $model->getEmail(),
                'emailStatus' => $model->getEmailStatus(),
                'actionLink' => $model->getActionLink(),
                'firstName' => $model->getFirstName(),
                'lastName' => $model->getLastName(),
                'createdAt' => $model->getDateCreated(),
                'updatedAt' => $model->getDateUpdated(),
                'activeSince' => $model->getActiveSince(),
            ],['userId' => $model->getId()],['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']);
    }

    public function delete(int $subscriberId)
    {
        $sql = "DELETE FROM $this->tableName WHERE `userId` = $subscriberId";
        $this->db->query($sql);
    }

    public function getAll(int $page, int $perPage, $args = [])
    {
        $limit = $perPage;
        $offset = ($page -1) * $limit;
        $sql = "SELECT * FROM $this->tableName";
        if (count($args) !== 0) {
            foreach ($args as $arg) {
                if (isset($arg['search'])){
                    $i = 0;
                    foreach ($arg['search'] as $name => $value) {
                        if ($i === 0) {
                            $sql.= " WHERE `{$name}` LIKE '%{$value}%'";
                        } else {
                            $sql.= " AND `{$name}` LIKE '%{$value}%'";
                        }
                        $i++;
                    }
                }
                if (isset($arg['order'])){
                    foreach ($arg['order'] as $name => $value) {
                        if ($name === 'orderNumber') {
                           continue;
                        }
                        $sql.= " ORDER BY `{$name}` {$value}";
                    }
                } else {
                    $sql.= " ORDER BY `createdAt` DESC";
                }
            }
        } else {
            $sql.= " ORDER BY `createdAt` DESC";
        }

        $sql .= " LIMIT $limit OFFSET $offset;";
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getSubscriberById(int $subscriberId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE `userId` = $subscriberId;";
        return $this->db->get_results($sql, ARRAY_A)[0];
    }

    public function getSubscriberByEmail(string $email)
    {
        $sql = "SELECT * FROM $this->tableName WHERE `email` = '$email';";
        $result = $this->db->get_results($sql, ARRAY_A);
        if(count($result) > 0) {
            return $result[0];
        }

        return null;
    }

    public function getForSending(int $newsletterId, int $page, int $perPage)
    {
        $limit = $perPage;
        $offset = 0;
        if ($page !== 1) {
            $offset = $page * $limit;
        }
        $logTable = NEWSLETTER_LOG_TABLE_NAME;
        $status = Model::STATUS_CONFIRMED;
        $sql = "SELECT * FROM $this->tableName WHERE emailStatus = {$status} AND userId NOT IN (
            SELECT userId FROM {$logTable} WHERE newsletterId = {$newsletterId}
        ) LIMIT $limit OFFSET $offset;";

        return $this->db->get_results($sql, ARRAY_A);
    }

//    public function getAllActive()
//    {
//        $sql = "SELECT * FROM $this->tableName WHERE 'activeSince' IS NOT NULL;";
//        return $this->db->get_results($sql, ARRAY_A);
//    }

    public function getUserBy($field, $value)
    {
        $sql = "SELECT * FROM $this->tableName WHERE `{$field}` = '{$value}'";
        $result = $this->db->get_results($sql, ARRAY_A);
        if (count($result) > 0) {
            return $result[0];
        }
        return $result;
    }

    public function unsubscribe(\Subscriber\Model\Subscriber $user)
    {
        $this->update($user);
    }

    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) FROM $this->tableName";
        return $this->db->get_results($sql, ARRAY_N)[0];
    }

}