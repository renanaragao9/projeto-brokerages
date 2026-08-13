import Link from "next/link";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { getProperty } from "@/lib/api";
import { coverImage, formatArea, formatBRL, fullAddress, statusLabel, typeLabel } from "@/lib/property";
import { site, whatsappLink } from "@/lib/site";
import { Reveal } from "@/components/reveal";
import { IconArrow, IconShield, IconWhatsApp } from "@/components/icons";

export async function generateMetadata(props: PageProps<"/canopus/[id]">): Promise<Metadata> {
  const { id } = await props.params;
  const property = await getProperty(id).catch(() => null);

  if (!property) {
    return { title: "Empreendimento não encontrado" };
  }

  return {
    title: property.name,
    description: property.description ?? undefined,
  };
}

export default async function EmpreendimentoDetailPage(props: PageProps<"/canopus/[id]">) {
  const { id } = await props.params;
  const property = await getProperty(id).catch(() => null);

  if (!property) {
    notFound();
  }

  const cover = coverImage(property);
  const gallery = property.images.filter((image) => image.id !== cover?.id).slice(0, 6);
  const features = property.features ?? [];
  const address = fullAddress(property);
  const price = formatBRL(property.price);

  const specs = [
    { label: "Área privativa", value: formatArea(property.area) },
    { label: "Área total", value: formatArea(property.total_area) },
    { label: "Dormitórios", value: property.bedrooms !== null ? String(property.bedrooms) : null },
    { label: "Suítes", value: property.suites !== null ? String(property.suites) : null },
    { label: "Banheiros", value: property.bathrooms !== null ? String(property.bathrooms) : null },
    {
      label: "Vagas",
      value: property.parking_spaces !== null ? String(property.parking_spaces) : null,
    },
    { label: "Condomínio", value: formatBRL(property.condominium_fee) },
    { label: "IPTU", value: formatBRL(property.iptu) },
  ].filter((spec): spec is { label: string; value: string } => spec.value !== null);

  const whatsappMessage = `Olá! Tenho interesse no empreendimento ${property.name}${
    property.city ? ` (${property.city})` : ""
  }. Pode me passar mais informações?`;

  return (
    <>
      <section className="relative flex min-h-[70vh] items-end overflow-hidden bg-brand-900">
        {cover?.url && (
          <img
            src={cover.url}
            alt={cover.alt ?? property.name}
            className="absolute inset-0 h-full w-full object-cover"
          />
        )}

        <div className="absolute inset-0 bg-gradient-to-t from-brand-900 via-brand-900/70 to-brand-900/40" />

        <div className="relative mx-auto w-full max-w-7xl px-5 pb-14 pt-36 lg:px-8">
          <Link
            href="/canopus"
            className="mb-6 inline-flex items-center gap-2 text-sm font-medium text-white/70 transition hover:text-accent-300"
          >
            <IconArrow className="h-4 w-4 rotate-180" />
            Voltar aos empreendimentos
          </Link>

          <div className="flex flex-wrap gap-2">
            <span className="rounded-full bg-white/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-brand-700">
              {typeLabel(property)}
            </span>
            <span className="rounded-full bg-accent-500 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
              {statusLabel(property)}
            </span>
          </div>

          <h1 className="mt-4 max-w-3xl text-4xl font-semibold leading-tight tracking-tight text-white sm:text-5xl">
            {property.name}
          </h1>

          {address && <p className="mt-3 max-w-2xl text-sm text-white/70">{address}</p>}
        </div>
      </section>

      <section className="bg-white py-16 lg:py-20">
        <div className="mx-auto grid w-full max-w-7xl gap-12 px-5 lg:grid-cols-[1.4fr_0.6fr] lg:px-8">
          <div>
            <Reveal>
              <h2 className="text-2xl font-light tracking-tight text-brand-800">
                Sobre o <strong className="font-semibold">empreendimento</strong>
              </h2>
              <p className="mt-4 whitespace-pre-line text-base leading-relaxed text-brand-900/65">
                {property.description ?? "Descrição em breve. Fale com um corretor para detalhes."}
              </p>
            </Reveal>

            {specs.length > 0 && (
              <Reveal className="mt-10 grid grid-cols-2 gap-px overflow-hidden rounded-2xl bg-brand-100 sm:grid-cols-3">
                {specs.map((spec) => (
                  <div key={spec.label} className="bg-white p-5">
                    <p className="text-[11px] uppercase tracking-wider text-brand-900/40">
                      {spec.label}
                    </p>
                    <p className="mt-1 text-lg font-semibold text-brand-800">{spec.value}</p>
                  </div>
                ))}
              </Reveal>
            )}

            {features.length > 0 && (
              <Reveal className="mt-12">
                <h2 className="text-2xl font-light tracking-tight text-brand-800">
                  Lazer e <strong className="font-semibold">estrutura</strong>
                </h2>
                <ul className="mt-6 grid gap-3 sm:grid-cols-2">
                  {features.map((feature) => (
                    <li
                      key={feature.id}
                      className="flex items-start gap-3 rounded-xl bg-brand-50/70 px-4 py-3 text-sm text-brand-900/70"
                    >
                      <IconShield className="mt-0.5 h-5 w-5 shrink-0 text-accent-500" />
                      <span>
                        {feature.name}
                        {feature.value ? `: ${feature.value}` : ""}
                      </span>
                    </li>
                  ))}
                </ul>
              </Reveal>
            )}

            {gallery.length > 0 && (
              <Reveal className="mt-12">
                <h2 className="text-2xl font-light tracking-tight text-brand-800">
                  Galeria de <strong className="font-semibold">imagens</strong>
                </h2>
                <div className="mt-6 grid gap-4 sm:grid-cols-2">
                  {gallery.map((image) => (
                    <img
                      key={image.id}
                      src={image.url ?? ""}
                      alt={image.alt ?? property.name}
                      loading="lazy"
                      className="aspect-[4/3] w-full rounded-2xl object-cover"
                    />
                  ))}
                </div>
              </Reveal>
            )}
          </div>

          <aside className="lg:sticky lg:top-28 lg:self-start">
            <div className="rounded-2xl bg-white p-7 shadow-[0_24px_60px_-34px_rgba(0,32,65,0.7)] ring-1 ring-brand-900/8">
              <p className="text-[11px] uppercase tracking-wider text-brand-900/40">
                {price ? "A partir de" : "Condições"}
              </p>
              <p className="mt-1 text-3xl font-semibold text-brand-800">{price ?? "Sob consulta"}</p>

              <p className="mt-4 text-sm leading-relaxed text-brand-900/60">
                Simule seu financiamento e descubra o subsídio disponível para o seu perfil.
              </p>

              <a
                href={whatsappLink(whatsappMessage)}
                target="_blank"
                rel="noopener noreferrer"
                className="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-6 py-4 text-sm font-semibold text-white transition hover:bg-accent-600"
              >
                <IconWhatsApp className="h-5 w-5" />
                Falar com um corretor
              </a>

              <Link
                href="/canopus#contato"
                className="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-full border border-brand-200 px-6 py-4 text-sm font-semibold text-brand-600 transition hover:border-brand-500 hover:bg-brand-50"
              >
                Pedir simulação
              </Link>

              <dl className="mt-7 space-y-3 border-t border-brand-100 pt-6 text-sm">
                <div className="flex justify-between gap-4">
                  <dt className="text-brand-900/45">Construtora</dt>
                  <dd className="font-medium text-brand-800">
                    {property.construction?.name ?? site.name}
                  </dd>
                </div>
                <div className="flex justify-between gap-4">
                  <dt className="text-brand-900/45">Situação</dt>
                  <dd className="font-medium text-brand-800">{statusLabel(property)}</dd>
                </div>
                <div className="flex justify-between gap-4">
                  <dt className="text-brand-900/45">Atualizado em</dt>
                  <dd className="font-medium text-brand-800">
                    {new Date(property.updated_at).toLocaleDateString("pt-BR")}
                  </dd>
                </div>
              </dl>
            </div>
          </aside>
        </div>
      </section>
    </>
  );
}
