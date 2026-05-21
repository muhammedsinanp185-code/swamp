<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Visitor extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['organization_id', 'name', 'phone', 'email', 'photo_url', 'id_proof_url'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function passes()
    {
        return $this->hasMany(VisitorPass::class);
    }
}