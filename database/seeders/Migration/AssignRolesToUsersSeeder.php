<?php

namespace Database\Seeders\Migration;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRolesToUsersSeeder extends Seeder
{
    public function run(): void
    {
        // IDs der Benutzer, die die Rolle "Admin" erhalten sollen
        $adminUserIds = [1, 5, 80]; // Passen Sie diese IDs an Ihre Anforderungen an

        // Hole die Rollen aus der Datenbank
        $adminRole = Role::where('name', 'Admin')->first();
        $memberRole = Role::where('name', 'Member')->first();

        if (!$adminRole || !$memberRole) {
            $this->command->error('Die Rollen "Admin" oder "Member" existieren nicht. Bitte überprüfen Sie die Rollen.');
            return;
        }

        // Alle Benutzer durchgehen
        User::query()->each(function (User $user) use ($adminUserIds, $adminRole, $memberRole) {
            if (in_array($user->id, $adminUserIds)) {
                // Rolle "Admin" zuweisen
                $user->syncRoles([$adminRole]);
            } else {
                // Rolle "Member" zuweisen
                $user->syncRoles([$memberRole]);
            }
        });
    }
}
