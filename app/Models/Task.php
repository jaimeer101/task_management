<?php

namespace App\Models;

use App\Enum\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'title', 'description', 'task_status', 'status', 'remarks'];
    protected static function booted()
    {
        static::creating(function ($task) {     // or whatever flag you use
            $task->created_by =  Auth::id();
        });

        static::updating(function ($task) {     // or whatever flag you use
            $task->updated_by =  Auth::id();
        });

        static::deleting(function ($task) {
            $task->status = 'deleted';       // or whatever flag you use
            $task->deleted_by =  Auth::id(); // current user ID
            $task->saveQuietly();
        });
    }
    protected $casts = [
        'task_status' => TaskStatus::class,
    ];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilterAndSort(Builder $query, array $filters, User $user): Builder
    {
        // 1. Role-based isolation (Admin sees all, regular user sees own)
        if (! $user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        } 
        $query->with('user');
        // 2. Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 3. Dynamic Sorting
        $sortBy = $filters['sort_by'] ?? 'id';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        
        return $query->orderBy($sortBy, $sortDirection);
    }
}
