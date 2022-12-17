<?php

namespace App\Models;

use App\Models\StatusChange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Resources\Json\JsonResource;

class StationConnector extends Model
{
    protected $table = 'station_connectors';

    public function station(): HasOne
    {
        return $this->hasOne(Station::class, 'id', 'station_id');
    }

    public function statusChanges(): HasMany
    {
        return $this->hasMany(StatusChange::class);
    }
}
