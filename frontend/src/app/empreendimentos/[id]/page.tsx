import Link from "next/link";
import { notFound } from "next/navigation";
import { getProperty } from "@/lib/api";

function formatBRL(value: string | null): string | null {
  if (value === null) {
    return null;
  }

  return Number(value).toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
}

export default async function EmpreendimentoDetailPage(
  props: PageProps<"/empreendimentos/[id]">
) {
  const { id } = await props.params;
  const property = await getProperty(id).catch(() => null);

  if (!property) {
    notFound();
  }

  const cover = property.images.find((image) => image.is_cover) ?? property.images[0];
  const address = [
    property.address,
    property.address_number,
    property.neighborhood,
    property.city,
    property.state,
  ]
    .filter(Boolean)
    .join(", ");

  return (
    <div>
      <Link href="/empreendimentos" className="mb-4 inline-block text-sm text-slate-500 hover:underline">
        ← Voltar
      </Link>

      <div className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        {cover?.url ? (
          <img
            src={cover.url}
            alt={cover.alt ?? property.name}
            className="aspect-[16/9] w-full object-cover"
          />
        ) : (
          <div className="flex aspect-[16/9] w-full items-center justify-center bg-slate-100 text-sm text-slate-400">
            Sem imagem
          </div>
        )}

        <div className="p-6">
          <div className="mb-2 flex flex-wrap items-start justify-between gap-2">
            <h1 className="text-xl font-semibold">{property.name}</h1>
            <p className="text-lg font-semibold text-slate-900">
              {formatBRL(property.price) ?? "Sob consulta"}
            </p>
          </div>

          <p className="mb-6 text-sm text-slate-600">
            {property.description ?? "Sem descrição cadastrada."}
          </p>

          {address && <p className="mb-6 text-sm text-slate-500">{address}</p>}

          {property.features.length > 0 && (
            <div className="mb-6">
              <h2 className="mb-2 text-sm font-semibold text-slate-400">Características</h2>
              <ul className="flex flex-wrap gap-2">
                {property.features.map((feature) => (
                  <li
                    key={feature.id}
                    className="rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600"
                  >
                    {feature.icon ? `${feature.icon} ` : ""}
                    {feature.name}
                    {feature.value ? `: ${feature.value}` : ""}
                  </li>
                ))}
              </ul>
            </div>
          )}

          <dl className="grid grid-cols-2 gap-4 text-sm sm:grid-cols-3">
            <div>
              <dt className="text-slate-400">Construtora</dt>
              <dd className="font-medium">{property.construction?.name ?? "-"}</dd>
            </div>
            <div>
              <dt className="text-slate-400">Área</dt>
              <dd className="font-medium">
                {property.area ? `${Number(property.area).toLocaleString("pt-BR")} m²` : "-"}
              </dd>
            </div>
            <div>
              <dt className="text-slate-400">Dormitórios</dt>
              <dd className="font-medium">{property.bedrooms ?? "-"}</dd>
            </div>
            <div>
              <dt className="text-slate-400">Suítes</dt>
              <dd className="font-medium">{property.suites ?? "-"}</dd>
            </div>
            <div>
              <dt className="text-slate-400">Vagas</dt>
              <dd className="font-medium">{property.parking_spaces ?? "-"}</dd>
            </div>
            <div>
              <dt className="text-slate-400">Atualizado em</dt>
              <dd className="font-medium">
                {new Date(property.updated_at).toLocaleDateString("pt-BR")}
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  );
}
