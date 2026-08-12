<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Properties\Pages\EditProperty;
use App\Filament\Resources\Properties\RelationManagers\FeaturesRelationManager;
use App\Models\Feature;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FeaturesRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@teste.com',
            'password' => bcrypt('password'),
            'is_super_admin' => true,
        ]));
    }

    protected function property(): Property
    {
        return Property::create([
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);
    }

    protected function feature(): Feature
    {
        return Feature::create([
            'name' => 'Swimming Pool',
            'slug' => 'swimming-pool',
        ]);
    }

    public function test_edit_page_renders_with_relation_manager(): void
    {
        $property = $this->property();

        Livewire::test(EditProperty::class, ['record' => $property->getRouteKey()])
            ->assertSuccessful();
    }

    public function test_can_attach_feature_with_value(): void
    {
        $property = $this->property();
        $feature = $this->feature();

        Livewire::test(FeaturesRelationManager::class, [
            'ownerRecord' => $property,
            'pageClass' => EditProperty::class,
        ])
            ->callTableAction('create', data: [
                'id' => [$feature->id],
                'value' => '2',
            ]);

        $this->assertDatabaseHas('property_features', [
            'property_id' => $property->id,
            'feature_id' => $feature->id,
            'value' => '2',
        ]);
    }

    public function test_can_detach_feature(): void
    {
        $property = $this->property();
        $property->features()->attach($this->feature()->id, ['value' => '2']);
        $feature = $property->features->first();

        Livewire::test(FeaturesRelationManager::class, [
            'ownerRecord' => $property,
            'pageClass' => EditProperty::class,
        ])
            ->callTableAction('delete', $feature->id);

        $this->assertDatabaseMissing('property_features', [
            'property_id' => $property->id,
            'feature_id' => $feature->id,
        ]);
    }
}
