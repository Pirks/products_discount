<?php

namespace App\Traits;

use Carbon\Carbon;

trait ModelDateAttribute
{
    /**
     * Set date attribute if date is valid or set to null.
     * 
     * @param string $attribute
     * @param string $date
     * @return void
     */
    protected function setDateProperty($attribute, $date)
    {
        $data = null;
        try {
            if ($date instanceof Carbon) {
                $data = $date;
            } else {
                $data = Carbon::createFromFormat('Y-m-d', $date);
            }
        } catch (\Exception $e) {
            
        }
        $this->attributes[$attribute] = $data;
    }

}
