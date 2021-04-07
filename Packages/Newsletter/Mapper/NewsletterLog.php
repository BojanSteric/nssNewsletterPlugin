<?php


namespace Newsletter\Mapper;

class NewsletterLog
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
        $this->tableName = NEWSLETTER_LOG_TABLE_NAME;
    }

    public function insert($userId, $createdAt, $newsletterId)
    {
        $this->db->insert($this->tableName,[
            'userId' => $userId,
            'createdAt' => $createdAt,
            'newsletterId' => $newsletterId,
        ],['%s', '%s', '%s']);
        return $this->db->insert_id;
    }

}