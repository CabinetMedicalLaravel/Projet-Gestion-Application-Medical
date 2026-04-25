<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que l'administrateur peut accéder au dashboard admin.
     */
    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Admin'); // Vérifie qu'on voit un mot clé du dashboard admin
    }

    /**
     * Test qu'un patient ne peut pas accéder au dashboard admin.
     */
    public function test_patient_cannot_access_admin_dashboard(): void
    {
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        $response = $this->actingAs($patient)->get('/admin/dashboard');

        // On attend un code 403 (Forbidden) ou redirection si le middleware le gère ainsi
        $response->assertStatus(403);
    }

    /**
     * Test qu'un visiteur non connecté est redirigé vers le login.
     */
    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test de l'accès à la gestion des créneaux pour l'admin.
     */
    public function test_admin_can_access_creneaux_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/creneaux');

        $response->assertStatus(200);
        $response->assertSee('Gestion des Créneaux');
    }
}
