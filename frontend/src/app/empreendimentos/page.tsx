import Link from "next/link";
import { getPrograms } from "@/lib/api";

export default async function EmpreendimentosPage() {
  const programs = await getPrograms().catch(() => null);

  if (programs === null) {
    return (
      <p className="rounded-md bg-red-50 px-3 py-2 text-sm text-red-600">
        Não foi possível carregar os empreendimentos.
      </p>
    );
  }

  if (programs.length === 0) {
    return <p className="text-sm text-slate-500">Nenhum empreendimento disponível no momento.</p>;
  }

  return (
    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      {programs.map((program) => (
        <Link
          key={program.id}
          href={`/empreendimentos/${program.id}`}
          className="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-slate-400 hover:shadow-md"
        >
          <h2 className="mb-2 font-semibold">{program.name}</h2>
          <p className="mb-3 line-clamp-2 text-sm text-slate-500">
            {program.description ?? "Sem descrição."}
          </p>
          <p className="text-xs text-slate-400">
            {program.properties_count ?? 0} imóvel(is) vinculado(s)
          </p>
        </Link>
      ))}
    </div>
  );
}
