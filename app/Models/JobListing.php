<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'employer_id',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    /**
     * Get the employer that owns the job listing.
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get the applications for the job listing.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}
