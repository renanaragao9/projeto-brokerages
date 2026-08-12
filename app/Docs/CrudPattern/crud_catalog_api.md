# Guia de API de Catálogo — Exemplo: Sports

Este documento descreve o processo para expor um endpoint de API somente leitura (index) para catálogos,
usando **Sports** como exemplo. Seguir este padrão para qualquer tabela de catálogo.

---

## Estrutura de arquivos

```
Controllers/Api/V1/Catalog/{Name}Controller.php    # index (único método)
Requests/Api/V1/Catalog/Index{Name}Request.php      # validação de query params
Resources/Api/V1/Catalog/{Name}Resource.php         # serialização JSON
Services/Catalog/Index{Name}Service.php             # QueryBuilder Spatie
routes/api.php                                      # Route::apiResource->only(['index'])
tests/Feature/API/Catalog/{Name}ControllerTest.php  # testes
```

---

## 1. Request (validação)

Valida os query params aceitos pelo Spatie QueryBuilder.

```php
// app/Http/Requests/Api/V1/Catalog/IndexSportRequest.php

<?php

namespace App\Http\Requests\Api\V1\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class IndexSportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filter.name' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string', 'in:name,created_at,-name,-created_at'],
            'include' => ['nullable', 'string', 'in:positions'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
```

### Campos padrão

| Campo | Descrição |
|-------|-----------|
| `filter.{campo}` | Filtro do Spatie. Adicionar uma entrada para cada `AllowedFilter` do service. |
| `sort` | Lista com `in:` contendo cada campo e sua versão com prefixo `-` (descendente). |
| `include` | Relações permitidas via `allowedIncludes`. |
| `per_page` | Limite de paginação (1-100). |

---

## 2. Service (QueryBuilder)

Usa Spatie QueryBuilder com filtros, ordenação, includes e paginação.

```php
// app/Services/Catalog/IndexSportService.php

<?php

namespace App\Services\Catalog;

use App\Http\Requests\Api\V1\Catalog\IndexSportRequest;
use App\Models\Sport;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class IndexSportService
{
    public function run(IndexSportRequest $indexSportRequest): QueryBuilder
    {
        return QueryBuilder::for(Sport::class)
            ->allowedFilters(
                AllowedFilter::partial('name'),
            )
            ->allowedSorts(
                'name',
                'created_at',
            )
            ->allowedIncludes(
                'positions',
            )
            ->defaultSort('name');
    }
}
```

### Atenção — Spatie v7+

Os métodos `allowedFilters`, `allowedSorts` e `allowedIncludes` usam **variadic arguments**, não arrays:

```php
// Correto (v7+)
->allowedFilters(
    AllowedFilter::partial('name'),
)

// Errado (v2-)
->allowedFilters([
    AllowedFilter::partial('name'),
])
```

---

## 3. Resource (serialização)

```php
// app/Http/Resources/Api/V1/Catalog/SportResource.php

<?php

namespace App\Http\Resources\Api\V1\Catalog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'positions' => PositionResource::collection($this->whenLoaded('positions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
```

Regras:
- Campos diretos: `$this->campo`
- Relações: `$this->whenLoaded('relation')` com resource aninhado
- Datas: retornar como string (a serialização automática do Laravel já formata)

---

## 4. Controller

Apenas o método `index`. Recebe a request validada e o service, retorna paginação via `JsonResource::collection()`.

```php
// app/Http/Controllers/Api/V1/Catalog/SportController.php

<?php

namespace App\Http\Controllers\Api\V1\Catalog;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\Catalog\IndexSportRequest;
use App\Http\Resources\Api\V1\Catalog\SportResource;
use App\Models\Sport;
use App\Services\Catalog\IndexSportService;
use Illuminate\Http\JsonResponse;

class SportController extends BaseController
{
    public function index(
        IndexSportRequest $indexSportRequest,
        IndexSportService $indexSportService
    ): JsonResponse {
        $this->authorize('viewAny', Sport::class);

        return $this->successResponse(
            data: SportResource::collection(
                $indexSportService->run($indexSportRequest)->paginate()
            ),
            message: 'Esportes listados com sucesso.'
        );
    }
}
```

A paginação é feita com `->paginate()` do Eloquent Builder (herdado pelo Spatie QueryBuilder).
O `successResponse` do `BaseController` encapsula com o envelope padrão:

```json
{
    "status": "success",
    "message": "Esportes listados com sucesso.",
    "data": {
        "data": [ ... ],
        "links": { ... },
        "meta": { ... }
    }
}
```

---

## 5. Rota

Em `routes/api.php`, dentro do grupo autenticado:

```php
use App\Http\Controllers\Api\V1\Catalog\SportController;

Route::middleware(['auth:sanctum', EnsureCompanyIsActive::class])->group(function () {
    // ...
    Route::apiResource('sports', SportController::class)->only(['index']);
});
```

Sempre usar `->only(['index'])` — são endpoints somente leitura para as companies.

---

## 6. Teste

```php
// tests/Feature/API/Catalog/SportControllerTest.php

<?php

namespace Tests\Feature\API\Catalog;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Sport;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);

        $this->company = Company::create([
            'name' => 'Empresa Teste',
            'slug' => 'empresa-teste',
            'status' => 'active',
        ]);

        $role = Role::create([
            'company_id' => $this->company->id,
            'name' => 'Admin',
        ]);

        $role->permissions()->sync(Permission::pluck('id'));

        $this->user = User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@teste.com',
            'password' => '12345678',
            'status' => 'active',
            'company_id' => $this->company->id,
            'role_id' => $role->id,
        ]);
    }

    protected function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->user->createToken('test')->plainTextToken,
        ];
    }

    protected function seedSports(): void
    {
        Sport::create(['name' => 'Futebol']);
        Sport::create(['name' => 'Basquete']);
        Sport::create(['name' => 'Vôlei']);
    }

    public function test_index_returns_sports(): void
    {
        $this->seedSports();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/sports');

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Basquete'])
            ->assertJsonFragment(['name' => 'Futebol'])
            ->assertJsonFragment(['name' => 'Vôlei']);
    }

    public function test_index_requires_authentication(): void
    {
        $this->getJson('/api/v1/sports')
            ->assertUnauthorized();
    }

    public function test_index_can_filter_by_name(): void
    {
        $this->seedSports();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/sports?filter[name]=Fut');

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Futebol'])
            ->assertJsonMissing(['name' => 'Basquete']);
    }

    public function test_index_can_sort_descending(): void
    {
        $this->seedSports();

        $response = $this->withHeaders($this->authHeaders())
            ->getJson('/api/v1/sports?sort=-name');

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Vôlei'])
            ->assertJsonFragment(['name' => 'Futebol'])
            ->assertJsonFragment(['name' => 'Basquete']);
    }
}
```

### Estrutura do setUp

1. `$this->seed(PermissionSeeder::class)` — essencial, sem permissões o policy retorna 403.
2. Criar `Company` ativa.
3. Criar `Role` vinculada à company.
4. Sincronizar **todas** as permissões no role (`Permission::pluck('id')`).
5. Criar `User` vinculado à company e role (sem `is_super_admin`).

### Testes obrigatórios

| Teste | Verifica |
|-------|----------|
| `test_index_returns_sports` | Endpoint retorna dados paginados |
| `test_index_requires_authentication` | 401 sem token |
| `test_index_can_filter_by_name` | Filtro `filter[name]` funciona |
| `test_index_can_sort_descending` | Ordenação `sort=-name` funciona |

### Asserções

Use `assertJsonFragment` e `assertJsonMissing` para verificar a presença/ausência de dados na resposta paginada.
Evite `assertJsonPath` com caminhos aninhados (`data.data.0.name`) — a estrutura do paginador pode variar.

---

## Checklist — Ordem de criação

| # | Passo | Arquivo |
|---|-------|---------|
| 1 | Request | `app/Http/Requests/Api/V1/Catalog/Index{Name}Request.php` |
| 2 | Service | `app/Services/Catalog/Index{Name}Service.php` |
| 3 | Resource | `app/Http/Resources/Api/V1/Catalog/{Name}Resource.php` |
| 4 | Controller | `app/Http/Controllers/Api/V1/Catalog/{Name}Controller.php` |
| 5 | Rota | `routes/api.php` — `Route::apiResource(...)->only(['index'])` |
| 6 | Teste | `tests/Feature/API/Catalog/{Name}ControllerTest.php` |

---

## Convenções

| Item | Convenção |
|------|----------|
| Namespace Controller | `App\Http\Controllers\Api\V1\Catalog` |
| Namespace Request | `App\Http\Requests\Api\V1\Catalog` |
| Namespace Resource | `App\Http\Resources\Api\V1\Catalog` |
| Namespace Service | `App\Services\Catalog` |
| Nome da rota | `snake_plural` (ex: `sports`, `payment-forms`) |
| ResourceCode na Policy | `snake_singular` (ex: `sport`) |
| Formato de filtro | `filter[campo]=valor` |
| Formato de sort | `sort=campo` ou `sort=-campo` (desc) |
| Formato de include | `include=relation` |
| Permissão necessária | `{resourceCode}.view` (ex: `sport.view`) |
