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
            'firstName' => $model->getFirstName(),
            'lastName' => $model->getLastName(),
            'created_at' => $model->getDateCreated(),
            'updatedAt' => $model->getDateUpdated(),
        ],['%d', '%s', '%s', '%s', '%s', '%s', '%s']);
        return $this->db->insert_id;
    }

    public function update(\Subscriber\Model\Subscriber $model): void
    {
        $this->db->update($this->tableName,
            [
                'wpUserId' => $model->getWpUserId(),
                'email' => $model->getEmail(),
                'emailStatus' => $model->getEmailStatus(),
                'firstName' => $model->getFirstName(),
                'lastName' => $model->getLastName(),
                'created_at' => $model->getDateCreated(),
                'updatedAt' => $model->getDateUpdated(),
            ],['userId' => $model->getId()],['%d', '%s', '%s', '%s', '%s', '%s', '%s']);
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

}