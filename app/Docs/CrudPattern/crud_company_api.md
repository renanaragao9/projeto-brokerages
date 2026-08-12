# Guia de CRUD API Company — Exemplo: Products

Este documento descreve o padrão para criar CRUDs em `Controllers/Api/V1/Company`,
seguindo a arquitetura usada no projeto.

---

## Estrutura de arquivos

```
Controllers/Api/V1/Company/Company{Name}Controller.php
Requests/Api/V1/Company/{Name}/CompanyIndex{Name}Request.php
Requests/Api/V1/Company/{Name}/CompanyStore{Name}Request.php
Requests/Api/V1/Company/{Name}/CompanyUpdate{Name}Request.php
Resources/Api/V1/Company/{Name}/Company{Name}Resource.php
Services/Company/{Names}/CompanyIndex{Name}Service.php
Services/Company/{Names}/CompanyShow{Name}Service.php
Services/Company/{Names}/CompanyStore{Name}Service.php
Services/Company/{Names}/CompanyUpdate{Name}Service.php
Services/Company/{Names}/CompanyDestroy{Name}Service.php
routes/api.php
```

Exemplo implementado no projeto:

- Product

---

## 1. Controller

O controller deve ser fino:

- `authorize(...)`
- recebe Request + Service por injeção
- retorna `successResponse(...)` / `errorResponse(...)`

Sem regra de negócio no controller.

### Exemplo de rotas do CRUD

- `index`
- `show`
- `store`
- `update`
- `destroy`

---

## 2. Requests

Separar requests por ação:

- `CompanyIndex{Name}Request`
- `CompanyStore{Name}Request`
- `CompanyUpdate{Name}Request`

### Index (Query params)

Validar:

- `filter.*`
- `sort`
- `include`
- `per_page` (1 a 100)

---

## 3. Service de Index (Spatie QueryBuilder)

Seguir o mesmo padrão dos catálogos:

- `allowedFilters(...)`
- `allowedSorts(...)`
- `allowedIncludes(...)`
- `defaultSort(...)`
- `paginate($request->integer('per_page', 15))`

---

## 4. Services de escrita

- `Store`: cria registro
- `Update`: atualiza registro
- `Destroy`: remove (soft delete quando aplicável)

Validações de domínio devem ficar nos services.

---

## 5. Resource

Responsável pela serialização de saída:

- campos principais
- ids de relacionamento
- relações com `whenLoaded(...)`
- datas (`created_at`, `updated_at`)

---

## 6. Tenancy (regra para Company API)

Nos CRUDs de Company API, a empresa deve vir do contexto atual:

- resolver empresa por `TenantContext::current()->companyId()`
- não confiar em `company_id` enviado no payload

Trait utilitária usada no projeto:

- `Services/Concerns/ResolvesTenantCompanyId.php`

---

## 7. Rota

Registrar no `routes/api.php` (grupo autenticado de `v1`):

```php
Route::apiResource('company/products', CompanyProductController::class);
```

---

## 8. Checklist

1. Criar Controller em `Api/V1/Company`
2. Criar Requests (`Index`, `Store`, `Update`)
3. Criar Resource
4. Criar Services (`Index`, `Show`, `Store`, `Update`, `Destroy`)
5. Aplicar tenancy no service
6. Registrar rota
7. Validar policy
8. Criar teste de feature em `tests/Feature/API/Company`

---

## 9. Teste de API (obrigatório)

Todo CRUD de Company deve ter teste de integração da API em:

- `tests/Feature/API/Company/Company{Name}ControllerCrudTest.php`

### Fluxo mínimo esperado

1. autenticar usuário com token
2. criar registro (`POST`)
3. listar registros (`GET index`)
4. buscar registro por id (`GET show`)
5. atualizar registro (`PUT/PATCH`)
6. remover registro (`DELETE`)
7. validar `soft delete` quando aplicável

### Regra de tenancy no teste

Além do CRUD básico, incluir cenário de isolamento:

- usuário da empresa A não deve ver/acessar dados da empresa B
- validar ao menos `index`, `show`, `update` e `delete`
- reaproveitar helpers do trait `tests/Feature/Support/AssertsTenantIsolation.php`

### Comando sugerido

```bash
./vendor/bin/phpunit --configuration phpunit.xml tests/Feature/API/Company/Company{Name}ControllerCrudTest.php
```

---

## 10. Template base (copiar e adaptar)

Use este template como base para qualquer novo CRUD em Company API.

```text
Entidade: {Name}

1) Controller
- app/Http/Controllers/Api/V1/Company/Company{Name}Controller.php

2) Requests
- app/Http/Requests/Api/V1/Company/{Name}/CompanyIndex{Name}Request.php
- app/Http/Requests/Api/V1/Company/{Name}/CompanyStore{Name}Request.php
- app/Http/Requests/Api/V1/Company/{Name}/CompanyUpdate{Name}Request.php

3) Resource
- app/Http/Resources/Api/V1/Company/{Name}/Company{Name}Resource.php

4) Services
- app/Services/Company/{Names}/CompanyIndex{Name}Service.php
- app/Services/Company/{Names}/CompanyShow{Name}Service.php
- app/Services/Company/{Names}/CompanyStore{Name}Service.php
- app/Services/Company/{Names}/CompanyUpdate{Name}Service.php
- app/Services/Company/{Names}/CompanyDestroy{Name}Service.php

5) Rota
- Route::apiResource('company/{kebab-plural}', Company{Name}Controller::class);

6) Teste
- tests/Feature/API/Company/Company{Name}ControllerCrudTest.php
	- use Tests\Feature\Support\AssertsTenantIsolation;
	- cenário CRUD completo
	- cenário de isolamento entre tenants
```

### Regra de uso do template

- Sempre começar por este template.
- Sempre manter tenancy no service (`TenantContext` / `ResolvesTenantCompanyId`).
- Sempre incluir teste de isolamento entre empresas.
- Sempre usar o trait `tests/Feature/Support/AssertsTenantIsolation.php` para evitar duplicação de asserções.
- Sempre seguir nomenclatura e pastas exatamente como descrito acima.

Se houver exceção de arquitetura, documentar no PR a justificativa técnica.
