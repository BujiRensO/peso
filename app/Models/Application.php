<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'scholarship_id',
        'status',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    /**
     * Get the user that made the application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job listing for the application.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }

    /**
     * Get the scholarship for the application.
     */
    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }
}
