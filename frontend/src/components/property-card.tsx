import Image from "next/image";
import Link from "next/link";
import type { Property } from "@/lib/api";
import {
  constructionPhaseLabel,
  coverImage,
  formatArea,
  formatBRL,
  shortLocation,
  statusLabel,
  typeLabel,
} from "@/lib/property";
import {
  IconArea,
  IconArrow,
  IconBed,
  IconCar,
  IconPin,
  IconShower,
} from "@/components/icons";

export function PropertyCard({
  property,
  basePath = "/canopus",
  dealType = "sale",
}: {
  property: Property;
  basePath?: string;
  dealType?: "sale" | "rental";
}) {
  const cover = coverImage(property);
  const location = shortLocation(property);
  const area = formatArea(property.area);
  const price = formatBRL(property.price);

  const phase = constructionPhaseLabel(property);

  const specs = [
    area ? { Icon: IconArea, label: area } : null,
    property.bedrooms !== null
      ? { Icon: IconBed, label: `${property.bedrooms} quartos` }
      : null,
    property.suites
      ? { Icon: IconShower, label: `${property.suites} suítes` }
      : null,
    property.parking_spaces !== null
      ? { Icon: IconCar, label: `${property.parking_spaces} vagas` }
      : null,
  ].filter(
    (spec): spec is { Icon: typeof IconArea; label: string } => spec !== null,
  );

  return (
    <Link
      href={`${basePath}/${property.id}`}
      className="group flex w-full flex-col overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_-8px_rgba(0,32,65,0.25)] ring-1 ring-brand-900/8 transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_50px_-20px_rgba(0,32,65,0.45)]"
    >
      <div className="relative aspect-4/3 overflow-hidden bg-brand-100">
        {cover?.url ? (
          <Image
            src={cover.url}
            alt={cover.alt ?? property.name}
            fill
            loading="lazy"
            sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw"
            className="object-cover transition duration-700 group-hover:scale-105"
          />
        ) : (
          <div className="grid h-full w-full place-items-center text-sm text-brand-400">
            Sem imagem
          </div>
        )}

        <div className="absolute inset-x-0 bottom-0 h-24 bg-linear-to-t from-brand-900/70 to-transparent" />

        <div className="absolute left-4 top-4 flex flex-wrap gap-2">
          <span className="rounded-full bg-white/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-brand-700">
            {typeLabel(property)}
          </span>
          <span className="rounded-full bg-accent-500 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
            {statusLabel(property)}
          </span>
          {phase && (
            <span className="rounded-full bg-brand-700/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
              {phase}
            </span>
          )}
        </div>

        {property.is_featured && (
          <span className="absolute right-4 top-4 rounded-full bg-brand-800/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
            Destaque
          </span>
        )}

        {location && (
          <p className="absolute inset-x-4 bottom-3 flex items-center gap-1.5 text-xs font-medium text-white">
            <IconPin className="h-4 w-4 shrink-0" />
            <span className="truncate">{location}</span>
          </p>
        )}
      </div>

      <div className="flex flex-1 flex-col p-6">
        <h3 className="text-lg font-semibold leading-snug text-brand-800 transition group-hover:text-accent-600">
          {property.name}
        </h3>

        {property.description && (
          <p className="mt-2 line-clamp-2 text-sm leading-relaxed text-brand-900/55">
            {property.description}
          </p>
        )}

        {specs.length > 0 && (
          <ul className="mt-5 flex flex-wrap gap-x-5 gap-y-2 border-t border-brand-100 pt-4 text-xs font-medium text-brand-900/65">
            {specs.map(({ Icon, label }) => (
              <li key={label} className="flex items-center gap-1.5">
                <Icon className="h-4 w-4 text-accent-500" />
                {label}
              </li>
            ))}
          </ul>
        )}

        <div className="mt-auto flex items-end justify-between gap-3 pt-6">
          <div>
            <p className="text-[11px] uppercase tracking-wider text-brand-900/40">
              {price ? (dealType === "rental" ? "Aluguel a partir de" : "A partir de") : "Condições"}
            </p>
            <p className="text-base font-semibold text-brand-800">
              {price ?? "Sob consulta"}
            </p>
          </div>

          <span className="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-600 transition group-hover:bg-accent-500 group-hover:text-white">
            Saiba mais
            <IconArrow className="h-4 w-4 transition group-hover:translate-x-0.5" />
          </span>
        </div>
      </div>
    </Link>
  );
}
