<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Parcel extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'organization_id', 'recipient_user_id', 'recipient_name',
        'courier_name', 'tracking_number', 'photo_url', 'status',
        'arrived_at'
    ];

    protected $casts = [
        'arrived_at' => 'datetime',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}