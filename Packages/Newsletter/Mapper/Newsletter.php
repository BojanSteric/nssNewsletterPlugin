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

    public function insert(\Newsletter\Model\Newsletter $model)
    {
        if ($this->db->insert($this->tableName, [
            'newsStatus' => $model->getStatus(),
            'createdAt' => $model->getDateCreated(),
            'scheduledAt' => $model->getDateScheduled(),
            'title' => $model->getTitle(),
            'content' => $model->getContent(),
            'templateName' => $model->getTemplateName(),
            'products' => $model->getProducts(),
        ], ['%s', '%s', '%s', '%s', '%s', '%s', '%s'])) {
            return $this->db->insert_id;
        }
        throw new \Exception('Snimanje nije bilo uspešno!!!');
    }

    public function update(\Newsletter\Model\Newsletter $model)
    {
        if ($this->db->update($this->tableName,
            [
                'newsStatus' => $model->getStatus(),
                'createdAt' => $model->getDateCreated(),
                'scheduledAt' => $model->getDateScheduled(),
                'title' => $model->getTitle(),
                'content' => $model->getContent(),
                'templateName' => $model->getTemplateName(),
                'products' => $model->getProducts(),
            ], ['newsId' => $model->getId()], ['%s', '%s', '%s', '%s', '%s', '%s', '%s'])) {
            return $model->getId();
        }
        throw new \Exception('Snimanje nije bilo uspešno!!!');
    }

    public function delete(int $newsletterId)
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

    public function searchForNewsletter($searchText)
    {
        $searchQuery = "";
        if ($searchText != '') {
            $searchQuery = " and (newsStatus like '%" . $searchText . "%' or title like '%" . $searchText . "%' or templateName like '%" . $searchText . "%' )";
        }
        $sql = "SELECT * FROM $this->tableName WHERE 1 $searchQuery;";
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function updateStatusNewsletter($status, $newsId)
    {
        $sql = "UPDATE $this->tableName SET newsStatus='$status' WHERE newsId='$newsId'";
        $this->db->query($sql);
        return $sql;
    }

    public function getNewsletterByStatus($status)
    {
        $sql = "SELECT * FROM $this->tableName WHERE newsStatus = '$status';";
        return $this->db->get_results($sql, ARRAY_A)[0];
    }
}