import Link from "next/link";
import { getProperties } from "@/lib/api";

function formatBRL(value: string | null): string | null {
  if (value === null) {
    return null;
  }

  return Number(value).toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
}

export default async function EmpreendimentosPage() {
  const properties = await getProperties().catch(() => null);

  if (properties === null) {
    return (
      <p className="rounded-md bg-red-50 px-3 py-2 text-sm text-red-600">
        Não foi possível carregar os empreendimentos.
      </p>
    );
  }

  if (properties.length === 0) {
    return <p className="text-sm text-slate-500">Nenhum empreendimento disponível no momento.</p>;
  }

  return (
    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      {properties.map((property) => {
        const cover = property.images.find((image) => image.is_cover) ?? property.images[0];

        return (
          <Link
            key={property.id}
            href={`/empreendimentos/${property.id}`}
            className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-400 hover:shadow-md"
          >
            {cover?.url ? (
              <img
                src={cover.url}
                alt={cover.alt ?? property.name}
                className="aspect-[3/2] w-full object-cover"
              />
            ) : (
              <div className="flex aspect-[3/2] w-full items-center justify-center bg-slate-100 text-sm text-slate-400">
                Sem imagem
              </div>
            )}

            <div className="p-5">
              <div className="mb-1 flex items-start justify-between gap-2">
                <h2 className="font-semibold">{property.name}</h2>
                {property.is_featured && (
                  <span className="shrink-0 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">
                    Destaque
                  </span>
                )}
              </div>

              {(property.city || property.state) && (
                <p className="mb-2 text-xs text-slate-400">
                  {[property.city, property.state].filter(Boolean).join(", ")}
                </p>
              )}

              <p className="mb-3 line-clamp-2 text-sm text-slate-500">
                {property.description ?? "Sem descrição."}
              </p>

              <p className="font-medium text-slate-900">{formatBRL(property.price) ?? "Sob consulta"}</p>
            </div>
          </Link>
        );
      })}
    </div>
  );
}
