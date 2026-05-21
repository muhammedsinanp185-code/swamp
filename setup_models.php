<?php

$dir = __DIR__ . '/app/Models/';
$models = [
    'Organization' => <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Organization extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['name', 'type', 'branding_settings', 'is_active'];

    protected $casts = [
        'branding_settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
PHP,
    'User' => <<<'PHP'
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasUuids, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
PHP,
    'Visitor' => <<<'PHP'
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
PHP,
    'VisitorPass' => <<<'PHP'
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
}
PHP,
    'EntryLog' => <<<'PHP'
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
PHP,
    'Vehicle' => <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = ['organization_id', 'user_id', 'vehicle_number', 'type', 'is_frequent'];

    protected $casts = [
        'is_frequent' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
PHP,
    'Parcel' => <<<'PHP'
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
        'organization_id', 'recipient_user_id', 'courier_name',
        'tracking_number', 'photo_url', 'status'
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}
PHP,
    'Worker' => <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Worker extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'organization_id', 'name', 'type', 'shift_start', 'shift_end', 'photo_url'
    ];
}
PHP,
    'Subscription' => <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subscription extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'organization_id', 'plan_name', 'stripe_id', 'status', 'trial_ends_at', 'ends_at'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
PHP,
];

foreach ($models as $name => $content) {
    file_put_contents($dir . $name . '.php', $content);
    echo "Updated $name\n";
}

echo "Done.\n";
