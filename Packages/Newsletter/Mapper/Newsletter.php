<?php


namespace Newsletter\Mapper;

class Newsletter
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
        $this->tableName = NEWSLETTER_TABLE_NAME;
    }

    public function insert(\Newsletter\Model\Newsletter $model): ?int
    {
        $this->db->insert($this->tableName,[
            'newsStatus' => $model->getStatus(),
            'createdAt' => $model->getDateCreated(),
            'scheduledAt' => $model->getDateUpdated(),
            'content' => $model->getContent(),
        ],['%s', '%s', '%s', '%s']);
        return $this->db->insert_id;
    }

    public function update(\Newsletter\Model\Newsletter $model): void
    {
        $this->db->update($this->tableName,
            [
                'newsStatus' => $model->getStatus(),
                'createdAt' => $model->getDateCreated(),
                'scheduledAt' => $model->getDateUpdated(),
                'content' => $model->getContent(),
            ],['newsId' => $model->getId()],['%s', '%s', '%s', '%s']);
    }

    public function delete(int $newsletterId): void
    {
        $sql = "DELETE FROM $this->tableName WHERE `newsId` = $newsletterId";
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

    public function getNewsletterById(int $newsletterId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE `newsId` = $newsletterId;";
        return $this->db->get_results($sql, ARRAY_A)[0];
    }

}