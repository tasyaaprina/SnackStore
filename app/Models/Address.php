<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'province',
        'street',
        'city',
        'state',
        'zip',
    ];

    public function orders(): MorphToMany
    {
        return $this->morphedByMany(Order::class, 'addressable');
    }
}