"use client";

import { useMemo, useState } from "react";
import type { Property } from "@/lib/api";
import { TYPE_LABELS } from "@/lib/property";
import { PropertyCard } from "@/components/property-card";
import { Reveal } from "@/components/reveal";

type Filters = {
  city: string;
  type: string;
  bedrooms: string;
};

const EMPTY: Filters = { city: "", type: "", bedrooms: "" };

function uniqueSorted(values: (string | null)[]): string[] {
  return [...new Set(values.filter((value): value is string => Boolean(value)))].sort((a, b) =>
    a.localeCompare(b, "pt-BR")
  );
}

export function PropertyExplorer({ properties }: { properties: Property[] }) {
  const [filters, setFilters] = useState<Filters>(EMPTY);

  const cities = useMemo(() => uniqueSorted(properties.map((item) => item.city)), [properties]);

  const types = useMemo(
    () =>
      uniqueSorted(properties.map((item) => item.type)).map((type) => ({
        value: type,
        label: TYPE_LABELS[type] ?? type,
      })),
    [properties]
  );

  const bedroomOptions = useMemo(
    () =>
      [...new Set(properties.map((item) => item.bedrooms).filter((value): value is number => value !== null))].sort(
        (a, b) => a - b
      ),
    [properties]
  );

  const filtered = useMemo(
    () =>
      properties.filter((property) => {
        if (filters.city && property.city !== filters.city) {
          return false;
        }

        if (filters.type && property.type !== filters.type) {
          return false;
        }

        if (filters.bedrooms && (property.bedrooms ?? 0) < Number(filters.bedrooms)) {
          return false;
        }

        return true;
      }),
    [properties, filters]
  );

  const hasFilters = filters.city !== "" || filters.type !== "" || filters.bedrooms !== "";

  const selectClass =
    "w-full appearance-none rounded-xl border border-brand-100 bg-white px-4 py-3.5 text-sm font-medium text-brand-800 outline-none transition focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20";

  return (
    <div>
      <Reveal className="rounded-2xl bg-white p-5 shadow-[0_18px_50px_-30px_rgba(0,32,65,0.6)] ring-1 ring-brand-900/8 sm:p-6">
        <div className="grid gap-4 md:grid-cols-[1fr_1fr_1fr_auto]">
          <label className="block">
            <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-brand-900/45">
              Cidade
            </span>
            <select
              value={filters.city}
              onChange={(event) => setFilters((prev) => ({ ...prev, city: event.target.value }))}
              className={selectClass}
            >
              <option value="">Todas as cidades</option>
              {cities.map((city) => (
                <option key={city} value={city}>
                  {city}
                </option>
              ))}
            </select>
          </label>

          <label className="block">
            <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-brand-900/45">
              Tipo
            </span>
            <select
              value={filters.type}
              onChange={(event) => setFilters((prev) => ({ ...prev, type: event.target.value }))}
              className={selectClass}
            >
              <option value="">Todos os tipos</option>
              {types.map((type) => (
                <option key={type.value} value={type.value}>
                  {type.label}
                </option>
              ))}
            </select>
          </label>

          <label className="block">
            <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-brand-900/45">
              Quartos
            </span>
            <select
              value={filters.bedrooms}
              onChange={(event) => setFilters((prev) => ({ ...prev, bedrooms: event.target.value }))}
              className={selectClass}
            >
              <option value="">Indiferente</option>
              {bedroomOptions.map((value) => (
                <option key={value} value={value}>
                  {value}+ quartos
                </option>
              ))}
            </select>
          </label>

          <div className="flex items-end">
            <button
              type="button"
              onClick={() => setFilters(EMPTY)}
              disabled={!hasFilters}
              className="h-[50px] w-full rounded-xl bg-brand-500 px-6 text-sm font-semibold text-white transition hover:bg-brand-600 disabled:cursor-not-allowed disabled:bg-brand-100 disabled:text-brand-900/35 md:w-auto"
            >
              Limpar filtros
            </button>
          </div>
        </div>
      </Reveal>

      <p className="mt-6 text-sm text-brand-900/55">
        <strong className="font-semibold text-brand-800">{filtered.length}</strong>{" "}
        {filtered.length === 1 ? "empreendimento encontrado" : "empreendimentos encontrados"}
      </p>

      {filtered.length === 0 ? (
        <div className="mt-6 rounded-2xl border border-dashed border-brand-200 bg-white/60 px-6 py-16 text-center">
          <p className="text-base font-semibold text-brand-800">
            Nenhum empreendimento com esses filtros.
          </p>
          <p className="mt-2 text-sm text-brand-900/55">
            Ajuste a busca ou fale com um corretor para conhecer as próximas oportunidades.
          </p>
        </div>
      ) : (
        <div className="mt-6 grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
          {filtered.map((property, index) => (
            <Reveal key={property.id} delay={Math.min(index, 5) * 70} className="flex">
              <PropertyCard property={property} />
            </Reveal>
          ))}
        </div>
      )}
    </div>
  );
}
