<?php


namespace Newsletter\Import;


class Parser
{
    public static function getHeader($file)
    {
        return fgetcsv($file);
    }

    public static function getData($header, $file)
    {
        $data = [];
        for ( $i = 0; $row = fgetcsv( $file ); ++$i)
        {
            $data[] = array_combine( array_values($header), array_values($row) );
        }
        return $data;
    }

}