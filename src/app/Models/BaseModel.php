<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    use HasFactory;

    const STATUS_ENABLE = 'enable';
    const STATUS_DISABLE = 'disable';
    const STATUS_DELETED = 'deleted';

    public function scopeActive(Builder $query): void
    {
        $query->where('status', $this::STATUS_ENABLE);
    }

    public function scopeNotDelete(Builder $query): void
    {
        $query->whereNotIn('status', [$this::STATUS_DELETED]);
    }
}