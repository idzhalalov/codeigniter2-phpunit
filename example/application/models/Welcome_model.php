<?php

class Welcome_model extends CI_Model
{
    public function get_data()
    {
        $results = array();
        for($i = 0; $i < rand(1, 10); $i++) {
            $results[] = $i;
        }

        return $results;
    }
}