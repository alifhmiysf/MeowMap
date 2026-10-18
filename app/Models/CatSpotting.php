<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CatSpotting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'description',
        'latitude',
        'longitude',
        'photo_path',
        'report_type',
        'district',
        'status',
    ];

    protected $appends = [
        'photo_url',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->photo_path);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
