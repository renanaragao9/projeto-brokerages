import Link from "next/link";
import { notFound } from "next/navigation";
import { getProgram } from "@/lib/api";

export default async function EmpreendimentoDetailPage(
  props: PageProps<"/empreendimentos/[id]">
) {
  const { id } = await props.params;
  const program = await getProgram(id).catch(() => null);

  if (!program) {
    notFound();
  }

  return (
    <div>
      <Link href="/empreendimentos" className="mb-4 inline-block text-sm text-slate-500 hover:underline">
        ← Voltar
      </Link>

      <div className="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 className="mb-4 text-xl font-semibold">{program.name}</h1>

        <p className="mb-6 text-sm text-slate-600">
          {program.description ?? "Sem descrição cadastrada."}
        </p>

        <dl className="grid grid-cols-2 gap-4 text-sm sm:grid-cols-3">
          <div>
            <dt className="text-slate-400">Slug</dt>
            <dd className="font-medium">{program.slug}</dd>
          </div>
          <div>
            <dt className="text-slate-400">Imóveis vinculados</dt>
            <dd className="font-medium">{program.properties_count ?? 0}</dd>
          </div>
          <div>
            <dt className="text-slate-400">Atualizado em</dt>
            <dd className="font-medium">
              {new Date(program.updated_at).toLocaleDateString("pt-BR")}
            </dd>
          </div>
        </dl>
      </div>
    </div>
  );
}
