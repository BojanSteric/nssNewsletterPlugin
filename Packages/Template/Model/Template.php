<?php


namespace Newsletter\Template\Model;


/**
 * Class Template
 * @package Newsletter\Template\Model
 */
class Template
{
    /**
     * @var string
     */
    private $name;

    /**
     * Serialized array of data
     * @var string
     */
    private $data;

    /**
     * @var mixed|null
     */
    private $id;

    /**
     * @var mixed|null
     */
    private $createdAt;

    /**
     * @var mixed|null
     */
    private $updatedAt;
    /**
     * @var int
     */
    private $newsletterId;

    /**
     * Template constructor.
     * @param string $name
     * @param string $data
     * @param int $newsletterId
     * @param int|null $id
     * @param string $createdAt
     * @param string $updatedAt
     */

    public function __construct(string $name, string $data, int $newsletterId, int $id = null, string $createdAt = null,string $updatedAt = null)
    {
        $this->name = $name;
        $this->data = $data;
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->newsletterId = $newsletterId;
    }

    /**
     * @return int
     */
    public function getNewsletterId(): int
    {
        return $this->newsletterId;
    }
    /**
     * @return string
     */
    public function getName() :string
    {
        return str_replace('.php','', $this->name);
    }

    /**
     * Serialized array of data
     * @return string
     */
    public function getData() :string
    {
        return $this->data;
    }

    /**
     * @return int|null
     */
    public function getId() :int
    {
        return (int)$this->id;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}