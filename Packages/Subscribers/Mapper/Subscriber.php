<?php


namespace Subscriber\Mapper;

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

    public function insert(\Subscriber\Model\Subscriber $model): ?int
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

    public function update(\Subscriber\Model\Subscriber $model): void
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

    public function delete(int $subscriberId): void
    {
        $sql = "DELETE FROM $this->tableName WHERE `userId` = $subscriberId";
        $this->db->query($sql);
    }

    public function getAll(int $page, int $perPage)
    {
        $limit = $perPage;
        $offset = 0;
        if ($page !== 1) {
            $offset = $page * $limit;
        }
        $sql = "SELECT * FROM $this->tableName LIMIT $limit OFFSET $offset;";
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
        return $this->db->get_results($sql, ARRAY_A)[0];
    }

    public function getForSending(int $newsletterId, int $page, int $perPage)
    {
        $limit = $perPage;
        $offset = 0;
        if ($page !== 1) {
            $offset = $page * $limit;
        }
        $logTable = NEWSLETTER_LOG_TABLE_NAME;
        $sql = "SELECT * FROM $this->tableName WHERE emailStatus = 'confirmed' AND userId NOT IN (
            SELECT userId FROM {$logTable} WHERE newsletterId = {$newsletterId}
        ) LIMIT $limit OFFSET $offset;";

        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getAllActive()
    {
        $sql = "SELECT * FROM $this->tableName WHERE 'activeSince' IS NOT NULL;";
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getUserBy($field, $value)
    {
        $sql = "SELECT * FROM $this->tableName WHERE `{$field}` = '{$value}'";
        return $this->db->get_results($sql, ARRAY_A)[0];
    }

    public function confirm($user)
    {
        $this->update($user);
    }

    public function unsubscribe(\Subscriber\Model\Subscriber $user)
    {
        $this->update($user);
    }

}