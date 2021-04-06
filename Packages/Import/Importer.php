<?php


namespace Newsletter\Import;


class Importer
{
    private $repository;
 
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function importData($data)
    {
        foreach($data as $element)
        {
            $this->repository->create(\Subscriber\Service\PostFormatter::formatDataNewsForm($element));
        }
    }

}