<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\Boolean;

class Project extends Model
{
    use HasFactory;
    use RecordActivity;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addTask($data)
    {
        $this->tasks()->create($data);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function members() :BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }

    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function hasOwner(User $user): bool
    {
        return $user->id === $this->user_id;
    }
}
