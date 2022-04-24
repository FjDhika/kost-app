<?php

namespace App\Api\Modules\Availability\Model;

use App\Api\Modules\Kost\Model\Kost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kost_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "is_available" => "boolean",
    ];

    /**
     * Get the users that owns the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the owner of kost that owns the question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owners(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * Get the kosts that owns the question
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kosts(): BelongsTo
    {
        return $this->belongsTo(Kost::class, 'kost_id', 'id');
    }
}
