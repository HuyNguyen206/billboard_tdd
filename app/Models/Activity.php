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
        'changes_log' => 'array'
    ];

    /**
     * Get the parent commentable model (post or video).
     */
    public function subject()
    {
        return $this->morphTo();
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

    public function getDescriptionExtendAttribute()
    {
        $userName = $this->user->name;
        if (Str::contains($this->description, 'updated')) {
            if ($this->changes_log && count($this->changes_log['after']) === 1) {
               return sprintf('%s updated %s of the %s', $userName, key($this->changes_log['after']), Str::lower(class_basename($this->subject)));
            }
        }
        return "$userName {$this->description}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
