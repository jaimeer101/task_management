<?php

namespace App\Enum;

enum SidebarMenu: string
{
    case DASHBOARD = 'Dashboard';
    case USERS = 'Users';
    case TASKS = 'Tasks';

    public function type(): string
    {
        return match ($this) {
            default => 'link',
        };
    }

    

    public function label(): string
    {
        return $this->value;
    }

    public function href(): string
    {
        return match ($this) {
            self::DASHBOARD => route('dashboard'),
            self::USERS => route('admin.users.index'), // route('admin.users.index')
            self::TASKS => route('task.index'),
        };
    }

    public function route(): string
    {
        return match ($this) {
            self::DASHBOARD => 'dashboard',
            self::USERS => 'admin.users',
            self::TASKS => 'task',
        };
    }

    public function permission(): ?string
    {
        return match ($this) {
            self::DASHBOARD => 'dashboard',
            self::USERS => 'admin.users.index',
            self::TASKS => 'task.index',
            default => null,
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::DASHBOARD => 'bi bi-speedometer',
            self::USERS => 'bi bi-person', 
            self::TASKS => 'bi bi-list-task',
            // self::USERS => 'bi bi-person',
            default => '',
        };
    }
}
