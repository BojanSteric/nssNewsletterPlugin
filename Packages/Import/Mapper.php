<?php


namespace Newsletter\Import;


class Mapper
{
    public $config;


    public function __construct()
    {
        $this->config = MapConfig::$mapConfig;
    }

    public function mapParsedData($parsedData, $nameOfMapElement)
    {
        $data = [];
        $i=0;
        foreach($parsedData as $row)
        {
            foreach($row as $key=>$value)
            {
                $index = array_search($key, $this->config[ $nameOfMapElement ]);
                
                if ( $index || $index === 0)
                {
                    $data[$i][ $this->config['map'][ $index ] ] = $value;
                    if(isset($data['emailStatus'])){
                        $data['emailStatus'] = $this->changeStatusFormat($data['emailStatus']);
                    }
                }
            }
            $i++;
        }
        return $data;
    }

    public function changeStatusFormat($status)
    {
        switch($status){
            case "S":
                return "not confirmed";
            case "C":
                return "confirmed";
            case "U":
                return "unsubscribed";
            case "B":
                return "bounced";
            default:
                return $status;
        }
    }
}