<?php

namespace App\Api\Modules\Kost\Model;

use App\Api\Modules\Auth\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function PHPUnit\Framework\isNull;

class Kost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'price',
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
        "price" => "integer",
    ];

    /**
     * Get the users that owns the Kost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Scope a query to filter kost name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterName($query, string $name)
    {
        return $query->where('name', 'LIKE', "%" . $name . "%");
    }

    /**
     * Scope a query to filter kost location.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterLocation($query, string $location)
    {
        $location = strtolower($location);
        return $query->where('location', 'LIKE', "%" . $location . "%");
    }

    /**
     * Scope a query to filter kost price.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterPrice($query, $min_price = null, $max_price = null)
    {
        if (!is_null($min_price)) {
            $query = $query->where('price', '>', $min_price);
        }

        if (!is_null($max_price)) {
            $query = $query->where('price', '<', $max_price);
        }

        return $query;
    }

    /**
     * Scope a query to order by price.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByProperty($query, $order_by, $dir)
    {
        if (is_null($order_by)) {
            $order_by = 'price';
        }

        if (is_null($dir)) {
            $dir = 'asc';
        }
        return $query->orderBy($order_by, $dir);
    }
}
