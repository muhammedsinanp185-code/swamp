<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class VisitorPass extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'organization_id', 'visitor_id', 'host_user_id', 'qr_uuid',
        'purpose', 'valid_from', 'valid_until', 'type', 'status'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    public function entryLogs()
    {
        return $this->hasMany(EntryLog::class);
    }

    public function getCurrentStatusAttribute()
    {
        if ($this->status === 'canceled') {
            return 'canceled';
        }

        $now = now();

        if ($now->isAfter($this->valid_until)) {
            return 'expired';
        }

        if ($now->isBefore($this->valid_from)) {
            return 'pending';
        }

        return 'active';
    }
}