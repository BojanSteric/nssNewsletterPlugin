<?php


namespace Newsletter\Import;


class MapConfig
{
    public static $mapConfig = array(
            'map' => [
                
                'email',
                'emailStatus',
                'firstName',
                'lastName',
                'createdAt',
            ],
            'nss'=>[
                
                'Email',
                'Status',
                'Name',
                'Surname',
                'Date',
            ],
        );
}