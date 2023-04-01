<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Product extends Model
{
    use HasFactory;

    public const PAGINATION_LIMIT = 40;

    protected $fillable = [
        'name',
        'price',
        'count',
    ];

    /**
     * @param QueryBuilder $query
     *
     * @return FilterBuilder|QueryBuilder|Builder
     */
    public function newEloquentBuilder($query): FilterBuilder|QueryBuilder|Builder
    {
        return new FilterBuilder($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Options::class);
    }
}
