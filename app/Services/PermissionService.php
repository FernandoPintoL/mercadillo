<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionService
{
    public static function getPermissions($rutaVisita)
    {
        $user = Auth::user();
        return [
            'crear' => $user->can('create', $rutaVisita),
            'editar' => $user->can('edit', $rutaVisita),
            'eliminar' => $user->can('delete', $rutaVisita),
        ];
    }
}
