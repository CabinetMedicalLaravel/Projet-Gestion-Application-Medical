<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Creneau;
use App\Services\SlotGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlotGeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SlotGeneratorService();
    }

    /**
     * Test que si aucun créneau n'est configuré, on utilise les défauts.
     */
    public function test_it_returns_default_slots_if_no_config_exists(): void
    {
        $doctor = User::factory()->create(['role' => 'medecin']);
        
        $slots = $this->service->generate($doctor->id, '2026-04-27'); // Un lundi

        $this->assertNotEmpty($slots);
        $this->assertEquals('08:00', $slots[0]);
    }

    /**
     * Test la génération de créneaux personnalisés.
     */
    public function test_it_generates_custom_slots_based_on_config(): void
    {
        $doctor = User::factory()->create(['role' => 'medecin']);
        
        // Config: Lundi (1), 09:00 - 10:00, Durée 20 min
        Creneau::create([
            'medecin_id' => $doctor->id,
            'jour_semaine' => 1,
            'heure_debut' => '09:00',
            'heure_fin' => '10:00',
            'duree' => 20,
            'est_actif' => true
        ]);

        $slots = $this->service->generate($doctor->id, '2026-04-27'); // C'est un lundi

        // On attend: 09:00, 09:20, 09:40
        $this->assertCount(3, $slots);
        $this->assertEquals(['09:00', '09:20', '09:40'], $slots);
    }

    /**
     * Test que si c'est configuré mais fermé ce jour là, ça retourne vide.
     */
    public function test_it_returns_empty_if_doctor_is_closed_on_that_day(): void
    {
        $doctor = User::factory()->create(['role' => 'medecin']);
        
        // Config seulement pour le Lundi
        Creneau::create([
            'medecin_id' => $doctor->id,
            'jour_semaine' => 1,
            'heure_debut' => '09:00',
            'heure_fin' => '10:00',
            'duree' => 30,
            'est_actif' => true
        ]);

        // On teste un Mardi (2026-04-28)
        $slots = $this->service->generate($doctor->id, '2026-04-28');

        $this->assertEmpty($slots);
    }
}
