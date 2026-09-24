<?php

namespace App\Support;

use App\Enum\SidebarMenu;
use App\Models\User;

class MenuBuilder
{
    /**
     * Create a new class instance.
     */
    public static function buildFor(?User $user): array
    {
        if (!$user) {
            return [];
        }

        $menu = [];
        $pendingHeader = null;
        $isAdmin = $user->hasRole('admin');
        foreach (SidebarMenu::cases() as $item) {
            if ($item->type() === 'header') {
                $pendingHeader = ['type' => 'header', 'name' => $item->label()];
                continue;
            }

            $permission = $item->permission();
            // dump($permission);
            // dump($user->getAllPermissions()->pluck('name'));
            // dump($user->can($permission));
            // Check if user has access to this link
            if ($isAdmin || !$permission || $user->can($permission)) {
                // Attach pending header only when a valid link follows it
                if ($pendingHeader) {
                    $menu[] = $pendingHeader;
                    $pendingHeader = null;
                }

                $menu[] = [
                    'type' => 'link',
                    'name' => $item->label(),
                    'href' => $item->href(),
                    'route' => $item->route(),
                    'icon' => $item->icon(),
                ];
            }
        }

        return $menu;
    }
}
