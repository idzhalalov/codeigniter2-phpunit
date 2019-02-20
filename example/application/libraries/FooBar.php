<?php

class FooBar
{
    public function Bar($input = null)
    {
        if (is_null($input)) {
            return 2;
        } else {
            return $input * 2;
        }
    }
}