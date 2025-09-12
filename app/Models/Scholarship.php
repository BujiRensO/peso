<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'provider_id',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Get the provider that owns the scholarship.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * Get the applications for the scholarship.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'scholarship_id');
    }
}
