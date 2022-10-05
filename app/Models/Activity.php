<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    protected $casts = [
        'changes' => 'array'
    ];

    /**
     * Get the parent commentable model (post or video).
     */
    public function subject()
    {
        return $this->morphTo();
    }

    public function activityDes(): Attribute
    {
        return Attribute::make(
            get: fn () => "You {$this->description}"
        );
    }

    public function getDesDetailAttribute()
    {
        $objectType = $this->subject instanceof Project ? 'project' : 'task';
        return Str::limit($objectType === 'project' ? $this->subject->title : $this->subject->body, 10);
    }

    public function getAtDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
