<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'capacity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacity' => 'integer',
    ];

    /**
     * Get the facilities for this room.
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities')
                    ->withPivot(['quantity', 'notes'])
                    ->withTimestamps();
    }

    /**
     * Get formatted facilities list for API response.
     */
    public function getFacilitiesListAttribute()
    {
        return $this->facilities->map(function ($facility) {
            return [
                'id' => $facility->id,
                'name' => $facility->name,
                'icon' => $facility->icon,
                'color' => $facility->color,
                'quantity' => $facility->pivot->quantity,
                'notes' => $facility->pivot->notes,
            ];
        });
    }
}
