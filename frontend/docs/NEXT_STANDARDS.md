# Padrões de Desenvolvimento — Next.js + Laravel API

## 1. Objetivo

Este documento define os padrões obrigatórios para desenvolvimento do frontend Next.js da equipe.

O objetivo é garantir:

- código previsível;
- arquitetura consistente;
- fácil manutenção;
- baixo acoplamento;
- facilidade para novos desenvolvedores e agentes de IA;
- reutilização de componentes;
- separação clara entre UI, estado, comunicação com API e regras de negócio.

Este documento deve ser seguido por todos os desenvolvedores e agentes de IA utilizados no projeto, incluindo Codex, Claude, Gemini e similares.

---

# 2. Stack padrão

A stack oficial do frontend é:

- Next.js
- TypeScript
- React
- Tailwind CSS
- shadcn/ui
- TanStack Query
- Zustand
- React Hook Form
- Zod
- ESLint
- Prettier

Backend:

- Laravel
- Laravel API
- REST/JSON
- autenticação definida pelo backend

---

# 3. Princípio principal da arquitetura

A aplicação deve separar claramente:

```text
Página
  ↓
Componente
  ↓
Hook
  ↓
Service
  ↓
API
  ↓
Laravel
```

Para estado global:

```text
Componentes
  ↓
Zustand
```

Para dados remotos:

```text
Componentes
  ↓
TanStack Query
  ↓
Service
  ↓
Laravel API
```

Não misturar responsabilidades.

---

# 4. Estrutura de pastas

Estrutura padrão:

```text
frontend/
├── src/
│   ├── app/
│   │   ├── (public)/
│   │   ├── (auth)/
│   │   └── dashboard/
│   │
│   ├── components/
│   │   ├── ui/
│   │   ├── layout/
│   │   ├── forms/
│   │   └── [feature]/
│   │
│   ├── services/
│   │   ├── api.ts
│   │   ├── auth.service.ts
│   │   └── [feature].service.ts
│   │
│   ├── stores/
│   │   ├── auth.store.ts
│   │   └── app.store.ts
│   │
│   ├── hooks/
│   │   └── [feature].hook.ts
│   │
│   ├── types/
│   │   ├── api.ts
│   │   └── [feature].ts
│   │
│   ├── lib/
│   │   ├── utils.ts
│   │   └── constants.ts
│   │
│   └── providers/
│
├── public/
├── package.json
├── tsconfig.json
└── ...
```

---

# 5. App Router

Usar exclusivamente o App Router.

Não utilizar `pages/` para novas funcionalidades.

Exemplo:

```text
src/app/dashboard/users/page.tsx
```

Representa:

```text
/dashboard/users
```

Rotas dinâmicas:

```text
src/app/dashboard/users/[id]/page.tsx
```

Representa:

```text
/dashboard/users/:id
```

---

# 6. Route Groups

Usar Route Groups para organizar áreas sem alterar a URL.

Exemplo:

```text
app/
├── (public)/
│   ├── page.tsx
│   └── pricing/
│       └── page.tsx
│
├── (auth)/
│   ├── login/
│   │   └── page.tsx
│   └── register/
│       └── page.tsx
│
└── dashboard/
    └── page.tsx
```

Os parênteses não fazem parte da URL.

---

# 7. Server Components e Client Components

Server Components são o padrão.

Não adicionar:

```tsx
"use client";
```

sem necessidade.

Usar Client Components somente quando houver necessidade de:

- hooks React;
- estado local;
- Zustand;
- eventos de interação;
- APIs do navegador;
- componentes que exigem execução no cliente;
- TanStack Query.

Exemplo:

```tsx
"use client";

import { useQuery } from "@tanstack/react-query";
```

Não transformar uma página inteira em Client Component apenas porque um componente filho precisa ser client.

Preferir:

```text
Server Component
    ↓
Client Component específico
```

---

# 8. Pages

As páginas devem ser responsáveis principalmente por composição.

Evitar colocar lógica complexa de negócio diretamente em:

```text
page.tsx
```

Exemplo ruim:

```tsx
export default function UsersPage() {
  // centenas de linhas
  // chamadas HTTP
  // transformação de dados
  // regras de negócio
  // formulários
  // tabelas
}
```

Preferir:

```tsx
export default function UsersPage() {
  return (
    <UsersPageContent />
  );
}
```

E separar:

```text
components/users/
├── UsersPageContent.tsx
├── UsersTable.tsx
├── UserForm.tsx
└── UserFilters.tsx
```

---

# 9. Services

Toda comunicação com a API deve passar por services.

Nunca espalhar URLs da API pelos componentes.

Errado:

```tsx
fetch("https://api.exemplo.com/users");
```

Dentro de componente.

Correto:

```tsx
usersService.list();
```

Estrutura:

```text
services/
├── api.ts
├── auth.service.ts
├── users.service.ts
├── products.service.ts
└── orders.service.ts
```

---

# 10. API Client

Centralizar a configuração HTTP em:

```text
services/api.ts
```

Responsabilidades:

- base URL;
- headers;
- autenticação;
- tratamento comum de resposta;
- tratamento de erros;
- serialização quando necessário.

Exemplo conceitual:

```ts
export async function api<T>(
  endpoint: string,
  options?: RequestInit,
): Promise<T> {
  // implementação centralizada
}
```

Nenhum componente deve conhecer detalhes de:

- `NEXT_PUBLIC_API_URL`;
- headers padrão;
- configuração HTTP;
- tratamento global de resposta.

---

# 11. Services por domínio

Cada domínio deve possuir seu service.

Exemplo:

```text
services/
├── users.service.ts
├── products.service.ts
├── orders.service.ts
└── auth.service.ts
```

Exemplo:

```ts
export const usersService = {
  list() {},
  find(id: number) {},
  create(data: CreateUserData) {},
  update(id: number, data: UpdateUserData) {},
  delete(id: number) {},
};
```

Os services não devem renderizar componentes.

Os services não devem acessar Zustand diretamente.

Os services devem ser independentes da UI.

---

# 12. TanStack Query

TanStack Query será utilizado para estado remoto.

Exemplos de dados remotos:

- usuários;
- produtos;
- pedidos;
- notificações;
- dashboard;
- relatórios;
- configurações vindas da API.

Não criar uma store Zustand apenas para armazenar uma lista retornada pela API.

Preferir:

```tsx
const { data, isLoading, error } = useQuery({
  queryKey: ["users"],
  queryFn: usersService.list,
});
```

---

# 13. Query Keys

As query keys devem seguir um padrão previsível.

Exemplo:

```text
["users"]
["users", id]
["users", "list", filters]
["products"]
["products", id]
["orders"]
["orders", id]
```

Para funcionalidades maiores, pode-se centralizar as keys:

```ts
export const userKeys = {
  all: ["users"] as const,
  list: (filters?: UserFilters) => ["users", "list", filters] as const,
  detail: (id: number) => ["users", id] as const,
};
```

---

# 14. Mutations

Operações de criação, alteração e exclusão devem usar mutations.

Exemplo:

```tsx
const mutation = useMutation({
  mutationFn: usersService.create,
});
```

Após alterações, invalidar as queries relacionadas.

Exemplo:

```tsx
queryClient.invalidateQueries({
  queryKey: ["users"],
});
```

---

# 15. Zustand

Zustand deve ser utilizado para estado global de aplicação.

Exemplos:

- usuário autenticado quando necessário no cliente;
- sidebar aberta/fechada;
- preferências de UI;
- filtros persistentes de aplicação;
- estado de wizard;
- configurações temporárias do frontend.

Não usar Zustand como substituto do TanStack Query.

Evitar:

```text
users.store.ts
products.store.ts
orders.store.ts
```

quando essas stores existem apenas para armazenar respostas da API.

---

# 16. Hooks

Hooks encapsulam comportamento reutilizável.

Exemplo:

```text
hooks/
├── useAuth.ts
├── useUsers.ts
└── useProducts.ts
```

Um hook pode combinar:

```text
service
+
TanStack Query
+
regras de UI
```

Exemplo:

```ts
export function useUsers() {
  return useQuery({
    queryKey: ["users"],
    queryFn: usersService.list,
  });
}
```

O componente pode então utilizar:

```tsx
const { data, isLoading } = useUsers();
```

---

# 17. Componentes

Componentes devem ter responsabilidade única.

Evitar componentes gigantes.

Errado:

```text
Dashboard.tsx
```

com:

- tabela;
- modal;
- formulário;
- filtros;
- paginação;
- chamadas API;
- regras de negócio.

Preferir:

```text
components/dashboard/
├── DashboardHeader.tsx
├── DashboardStats.tsx
├── DashboardChart.tsx
└── DashboardActivity.tsx
```

---

# 18. Componentes UI

Componentes genéricos ficam em:

```text
components/ui/
```

Exemplos:

```text
button.tsx
input.tsx
dialog.tsx
dropdown-menu.tsx
table.tsx
badge.tsx
card.tsx
```

Usar shadcn/ui como base.

Não duplicar componentes UI sem necessidade.

Antes de criar um novo componente, verificar se já existe um componente reutilizável.

---

# 19. Componentes de domínio

Componentes específicos de uma funcionalidade devem ficar dentro do domínio.

Exemplo:

```text
components/users/
├── UserTable.tsx
├── UserForm.tsx
├── UserFilters.tsx
└── UserStatusBadge.tsx
```

Não colocar tudo em:

```text
components/
```

sem organização.

---

# 20. Formulários

Usar:

- React Hook Form;
- Zod.

Estrutura:

```text
components/users/UserForm.tsx
```

Validação:

```text
schemas/
```

Quando houver muitos schemas, criar:

```text
schemas/
├── user.schema.ts
├── product.schema.ts
└── auth.schema.ts
```

Exemplo:

```ts
const schema = z.object({
  name: z.string().min(1),
  email: z.string().email(),
});
```

---

# 21. Types

Tipos devem ser centralizados quando forem compartilhados.

Exemplo:

```text
types/
├── user.ts
├── product.ts
├── order.ts
└── api.ts
```

Exemplo:

```ts
export interface User {
  id: number;
  name: string;
  email: string;
}
```

Não duplicar a mesma interface em vários arquivos.

---

# 22. API Types

Tipos relacionados à API devem refletir o contrato do backend.

Exemplo:

```ts
interface ApiResponse<T> {
  data: T;
  message?: string;
}

interface ApiError {
  message: string;
  errors?: Record<string, string[]>;
}
```

Se o backend alterar o contrato, atualizar os tipos correspondentes.

---

# 23. Autenticação

A autenticação é responsabilidade do backend Laravel.

O frontend não deve implementar regras de autenticação paralelas.

O frontend deve:

- enviar credenciais;
- manter o estado necessário;
- tratar sessão/token conforme o mecanismo adotado;
- proteger rotas;
- tratar 401/403;
- redirecionar quando necessário.

Nunca armazenar dados sensíveis desnecessariamente no `localStorage`.

---

# 24. Middleware

Usar middleware para regras de acesso que precisam ocorrer antes da página.

Exemplo:

```text
src/middleware.ts
```

Responsabilidades possíveis:

- verificar autenticação;
- redirecionar usuário não autenticado;
- proteger áreas privadas;
- regras simples de acesso.

Não colocar regras complexas de negócio no middleware.

---

# 25. Variáveis de ambiente

Variáveis públicas:

```text
NEXT_PUBLIC_*
```

somente quando realmente precisam ser expostas ao navegador.

Exemplo:

```env
NEXT_PUBLIC_API_URL=https://api.exemplo.com
```

Segredos nunca devem utilizar:

```env
NEXT_PUBLIC_*
```

Exemplo incorreto:

```env
NEXT_PUBLIC_API_SECRET=...
```

---

# 26. Tratamento de erros

Não ignorar erros silenciosamente.

Evitar:

```ts
try {
  ...
} catch {
}
```

Usar tratamento consistente.

A interface deve apresentar estados:

```text
loading
success
empty
error
```

Uma tela que consulta API deve considerar os quatro estados.

---

# 27. Loading

Usar os recursos do Next quando apropriado:

```text
loading.tsx
```

Para componentes client, utilizar os estados fornecidos pelo TanStack Query ou estado local.

Evitar vários loaders diferentes para a mesma situação sem necessidade.

---

# 28. Empty States

Toda listagem deve considerar o estado vazio.

Exemplo:

```text
Usuários

Nenhum usuário encontrado.

[Adicionar usuário]
```

Não confundir:

```text
loading
```

com:

```text
empty
```

---

# 29. Nomenclatura

Arquivos de componentes:

```text
UserTable.tsx
UserForm.tsx
DashboardHeader.tsx
```

Services:

```text
users.service.ts
auth.service.ts
```

Stores:

```text
auth.store.ts
app.store.ts
```

Hooks:

```text
useAuth.ts
useUsers.ts
```

Types:

```text
user.ts
api.ts
```

Variáveis e funções:

```ts
camelCase
```

Componentes:

```ts
PascalCase
```

Constantes:

```ts
UPPER_SNAKE_CASE
```

---

# 30. Imports

Preferir alias:

```ts
import { Button } from "@/components/ui/button";
import { usersService } from "@/services/users.service";
```

Evitar:

```ts
import { Button } from "../../../../components/ui/button";
```

---

# 31. Regras de dependência

A direção recomendada é:

```text
app
 ↓
components
 ↓
hooks
 ↓
services
 ↓
api
```

Tipos podem ser utilizados por todas as camadas.

Evitar dependências inversas.

Exemplo:

```text
service → component
```

é proibido.

O service não deve conhecer a UI.

---

# 32. Regras para agentes de IA

Codex, Claude, Gemini e qualquer outro agente de IA devem:

1. Ler este arquivo antes de modificar o frontend.
2. Respeitar a estrutura existente.
3. Não criar novas bibliotecas sem necessidade.
4. Não criar uma nova abstração se já existir uma equivalente.
5. Procurar componentes existentes antes de criar novos.
6. Não mover arquivos sem necessidade.
7. Não alterar arquitetura global para resolver um problema local.
8. Não criar stores para dados que pertencem ao TanStack Query.
9. Não fazer chamadas HTTP diretamente em componentes quando existir service.
10. Não duplicar tipos existentes.
11. Não adicionar `"use client"` sem necessidade.
12. Não instalar dependências sem justificar a necessidade.
13. Manter TypeScript estrito.
14. Não desabilitar ESLint/TypeScript para esconder erros.
15. Executar lint/typecheck/testes relevantes após alterações.

---

# 33. Regra para novas funcionalidades

Antes de implementar uma feature, seguir:

```text
1. Identificar o domínio
        ↓
2. Verificar componentes existentes
        ↓
3. Verificar services existentes
        ↓
4. Verificar hooks existentes
        ↓
5. Verificar stores existentes
        ↓
6. Criar somente o necessário
```

Exemplo para usuários:

```text
components/users/
services/users.service.ts
hooks/useUsers.ts
types/user.ts
```

Não criar arquivos genéricos sem necessidade.

---

# 34. Regra para novas dependências

Antes de instalar um pacote:

1. verificar se o Next/React já possui solução;
2. verificar se uma dependência existente resolve;
3. verificar se shadcn/ui já fornece o componente;
4. avaliar tamanho e manutenção da biblioteca;
5. justificar a instalação.

Não instalar bibliotecas apenas porque são populares.

---

# 35. Regra de UI

Prioridade:

```text
1. shadcn/ui
2. componentes existentes do projeto
3. Tailwind
4. novo componente específico
5. nova biblioteca somente quando realmente necessário
```

Não misturar vários frameworks visuais sem decisão arquitetural.

---

# 36. Regra de estado

Antes de criar uma store, perguntar:

> Esse dado é estado da aplicação ou é dado remoto da API?

Se for:

```text
API
```

usar:

```text
TanStack Query
```

Se for:

```text
estado global da aplicação
```

considerar:

```text
Zustand
```

Se for usado somente dentro de um componente:

```text
useState
```

---

# 37. Regra de reutilização

Antes de criar:

```text
UserModal.tsx
```

procurar:

```text
Dialog
Modal
Form
```

existentes.

Antes de criar:

```text
DataTable
```

verificar se já existe uma implementação padrão.

O objetivo é construir uma base de componentes reutilizável.

---

# 38. Regra para páginas

Uma página deve preferencialmente:

- montar a estrutura;
- buscar dados quando apropriado;
- delegar UI para componentes;
- delegar comunicação API para services/hooks;
- manter pouca lógica.

Exemplo:

```tsx
export default function UsersPage() {
  return (
    <PageContainer>
      <PageHeader />
      <UsersTable />
    </PageContainer>
  );
}
```

---

# 39. Regra para Services

Services devem conter operações de API.

Exemplo:

```ts
export const productsService = {
  list,
  find,
  create,
  update,
  delete,
};
```

Não colocar:

```text
JSX
React hooks
Zustand
navegação
Toast
modal
```

dentro de services.

---

# 40. Regra para Hooks

Hooks podem coordenar:

```text
TanStack Query
Service
estado de UI
```

Mas não devem virar arquivos gigantes.

Se uma regra de negócio for complexa, extrair para uma função ou módulo específico.

---

# 41. Regra de commits

Preferir commits pequenos e objetivos.

Exemplos:

```text
feat: add users listing
feat: add user creation form
fix: handle expired authentication
refactor: extract user service
style: improve dashboard spacing
chore: update dependencies
```

---

# 42. Antes de finalizar uma tarefa

Todo desenvolvedor ou agente deve verificar:

```text
[ ] Segui a arquitetura existente
[ ] Reutilizei componentes existentes
[ ] Não dupliquei código
[ ] Não criei store desnecessária
[ ] API está em service
[ ] Dados remotos usam TanStack Query quando apropriado
[ ] Formulários usam React Hook Form + Zod
[ ] Tipos estão centralizados
[ ] Não adicionei "use client" sem necessidade
[ ] Não expus secrets
[ ] ESLint passa
[ ] TypeScript passa
[ ] Testes relevantes passam
```

---

# 43. Regra mais importante

Quando houver dúvida entre criar algo novo ou reutilizar algo existente:

> **Primeiro procurar. Depois reutilizar. Somente então criar.**

Quando houver dúvida arquitetural:

> **Manter a solução mais simples que respeite a separação entre UI, estado, API e regras de negócio.**

A arquitetura deve ser consistente, não complexa.

---

# 44. Resumo visual

```text
                        NEXT.JS
                           │
                    ┌──────┴──────┐
                    │             │
                 Server         Client
                Components    Components
                    │             │
                    │        ┌────┴────┐
                    │        │         │
                    │     Zustand   TanStack
                    │                 Query
                    │                    │
                    └────────┬───────────┘
                             │
                           Hooks
                             │
                          Services
                             │
                           api.ts
                             │
                             ▼
                       LARAVEL API
                             │
                             ▼
                       DATABASE / REDIS
```

## Stack oficial resumida

```text
Next.js
TypeScript
Tailwind CSS
shadcn/ui
TanStack Query
Zustand
React Hook Form
Zod
ESLint
Prettier
        ↓
Laravel API
```
