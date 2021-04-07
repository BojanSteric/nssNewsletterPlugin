<?php


namespace Newsletter\Import;


class Parser
{
    public static function getHeader($file)
    {
        return array_slice(fgetcsv($file), 0, 10);
    }

    public static function getData($header, $file)
    {
        $data = [];
        for ( $i = 0; $row = fgetcsv( $file ); ++$i)
        {
            $data[] = array_combine( array_values($header), array_values( array_slice($row, 0, 10) ) );
        }
        return $data;
    }
}