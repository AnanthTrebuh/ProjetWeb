<?php
namespace App\Service;


class reverse
{
    public function reverse_message(string $a): string
    {
        $length = strlen($a);
        $final_list = "";
        for ($i=($length-1); $i >=0 ; $i--)
        {
            $final_list = $final_list . $a[$i];
        }
        return $final_list;
    }
}