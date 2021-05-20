<?php


namespace Newsletter\Template\Repository;


use Composer\Installers\TheliaInstaller;
use Newsletter\Template\Mapper\Template as Mapper;
use Newsletter\Template\Model\Template as Model;
use PHPMailer\PHPMailer\Exception;

class Template
{
    /**
     * @var Mapper
     */
    private $mapper;

    /**
     * Template constructor.
     */
    public function __construct()
    {
        $this->mapper = new Mapper();
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        try {
            $this->mapper->insert($this->make($data));
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function update(array $data)
    {
        try {
            $this->mapper->update($this->make($data));
        } catch (Exception $e){
            echo $e->getMessage();
        }

    }

    /**
     * @param array $data
     * @return Model
     */
    private function make(array $data) : Model
    {
        return new Model($data['name'], $data['data'], $data['newsletterId'],$data['templateId'] ?? null);
    }

    public function getTemplateByNewsletterId(int $newsletterId): Model
    {
        $data = $this->mapper->getByNewsletterId($newsletterId);
        return $this->make($data);
    }


}