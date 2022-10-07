<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function invitedProjects()
    {
        return $this->belongsToMany(Project::class, 'project_members');
    }

    public function accessibleProjectsQuery()
    {
        $projectsQuery = $this->projects()->select('projects.*');
        $invitedProjectsQuery = $this->invitedProjects()->select('projects.*');
        $projectsQuery->union($invitedProjectsQuery);

        return $projectsQuery;
    }

    public function avatar()
    {
        $hashEmail = md5($this->email);

        return "https://www.gravatar.com/avatar/$hashEmail?s=200&d={$this->getDefaultAvatar()}";
    }

    private function getDefaultAvatar():string
    {
        $number = is_numeric($check = strtolower($this->email[0])) ? ord($check) - 21 : ord($check) - 96;
        return "s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-$number.png?ssl=1";
    }
}
