<?php

namespace App\Traits;


trait Logo {


    public function getGetLogoAttribute()
    {
        if($this->logo)
        return url("storage/$this->logo");
    }

}
