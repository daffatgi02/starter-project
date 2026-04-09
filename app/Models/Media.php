<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'collection',
        'disk',
        'path',
        'filename',
        'mime_type',
        'size',
        'user_id',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): ?string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
