<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public const TYPES = ['Full-Time', 'Contract', 'Remote', 'Hybrid'];

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'companyId',
        'viewCount',
        'categoryId',
    ];

    protected function casts(): array
    {
        return [
            'salary' => 'decimal:2',
            'deleted_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'categoryId', 'id');
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'jobVacancyId', 'id');
    }
}
