<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EntryLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organization_id', 'visitor_pass_id', 'scanned_by_user_id',
        'type', 'manual_entry', 'notes', 'scanned_at'
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'manual_entry' => 'boolean',
    ];

    public function pass()
    {
        return $this->belongsTo(VisitorPass::class, 'visitor_pass_id');
    }

    public function guard()
    {
        return $this->belongsTo(User::class, 'scanned_by_user_id');
    }
}