<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Properties\Pages\EditProperty;
use App\Filament\Resources\Properties\RelationManagers\ImagesRelationManager;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ImagesRelationManagerTest extends TestCase
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

        Storage::fake('public');
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

    protected function image(Property $property, array $attributes = []): PropertyImage
    {
        return PropertyImage::create(array_merge([
            'property_id' => $property->id,
            'path' => 'properties/'.$property->id.'/images/fachada.jpg',
        ], $attributes));
    }

    public function test_edit_page_renders_with_image_relation_manager(): void
    {
        $property = $this->property();
        $this->image($property);

        Livewire::test(EditProperty::class, ['record' => $property->getRouteKey()])
            ->assertSuccessful();
    }

    public function test_can_upload_image_with_path_in_property_folder(): void
    {
        $property = $this->property();

        Livewire::test(ImagesRelationManager::class, [
            'ownerRecord' => $property,
            'pageClass' => EditProperty::class,
        ])
            ->callTableAction('create', data: [
                'path' => UploadedFile::fake()->image('fachada.jpg'),
                'alt' => 'Fachada do imóvel',
            ]);

        $image = PropertyImage::first();

        $this->assertNotNull($image);
        Storage::disk('public')->assertExists($image->path);
        $this->assertStringStartsWith('properties/'.$property->id.'/images/', $image->path);

        $this->assertDatabaseHas('property_images', [
            'property_id' => $property->id,
            'alt' => 'Fachada do imóvel',
        ]);
    }

    public function test_cover_only_one_per_property(): void
    {
        $property = $this->property();
        $cover = $this->image($property, ['is_cover' => true]);
        $second = $this->image($property, ['path' => 'properties/1/images/interior.jpg']);

        Livewire::test(ImagesRelationManager::class, [
            'ownerRecord' => $property,
            'pageClass' => EditProperty::class,
        ])
            ->callTableAction('edit', $second->id, [
                'alt' => 'Interior',
                'is_cover' => true,
            ]);

        $this->assertFalse($cover->refresh()->is_cover);
        $this->assertTrue($second->refresh()->is_cover);
    }

    public function test_delete_removes_row_and_file(): void
    {
        $property = $this->property();
        $image = $this->image($property);

        Storage::disk('public')->put($image->path, 'conteudo');

        Livewire::test(ImagesRelationManager::class, [
            'ownerRecord' => $property,
            'pageClass' => EditProperty::class,
        ])
            ->callTableAction('delete', $image->id);

        $this->assertDatabaseMissing('property_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($image->path);
    }
}
