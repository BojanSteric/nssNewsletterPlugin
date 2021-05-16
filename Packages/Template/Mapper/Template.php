<?php


namespace Newsletter\Template\Mapper;


use Newsletter\Template\Model\Template as Model;

class Template
{
    /**
     * @var \wpdb
     */
    private $db;
    /**
     * @var string
     */
    private $tableName;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->tableName = NEWSLETTER_TEMPLATES_TABLE;
    }

    public function insert(Model $template)
    {

        $this->db->insert(NEWSLETTER_TEMPLATES_TABLE,
            [
                'name' => $template->getName(),
                'data' => $template->getData(),
                'newsletterId' => $template->getNewsletterId()
            ]);
    }

    public function update(Model $template)
    {
        $this->db->update(NEWSLETTER_TEMPLATES_TABLE,
            [
                'name' => $template->getName(),
                'data' => $template->getData(),
                'newsletterId' => $template->getNewsletterId()
            ],['templateId' => $template->getId()]);
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE `templateId` = {$id}";
        $this->db->get_results($sql,ARRAY_A)[0];
    }

    public function getByName(string $templateName)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE `name` = {$templateName}";
        $this->db->get_results($sql,ARRAY_A)[0];
    }

    public function getByNewsletterId($newsletterId)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE `newsletterId` = {$newsletterId}";
        return $this->db->get_results($sql,ARRAY_A)[0];
    }
}