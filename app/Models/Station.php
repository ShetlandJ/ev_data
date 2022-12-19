<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'stations';

    public function getFullAddressAttribute(): string
    {
        $address = $this->address_sitename;
        $address .= $this->address_streetnumber ? ', ' . $this->address_streetnumber : '';
        $address .= $this->address_street ? ', ' . $this->address_street : '';
        $address .= $this->address_area ? ', ' . $this->address_area : '';
        $address .= $this->address_postcode ? ', ' . $this->address_postcode : '';

        return $address;
    }
}
