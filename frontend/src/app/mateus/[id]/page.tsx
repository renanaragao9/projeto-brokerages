import Image from "next/image";
import Link from "next/link";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { getProperty } from "@/lib/api";
import {
  constructionPhaseLabel,
  coverImage,
  formatArea,
  formatBRL,
  fullAddress,
  statusLabel,
  typeLabel,
} from "@/lib/property";
import { mateusSite } from "@/lib/site-mateus";
import { whatsappLink } from "@/lib/site";
import { FloorPlanViewer } from "@/components/floor-plan-viewer";
import { PropertyMap } from "@/components/property-map";
import { Reveal } from "@/components/reveal";
import {
  IconArea,
  IconArrow,
  IconBank,
  IconBath,
  IconBed,
  IconCar,
  IconCoin,
  IconDocument,
  IconShield,
  IconShower,
  IconWhatsApp,
} from "@/components/icons";

export async function generateMetadata(props: PageProps<"/mateus/[id]">): Promise<Metadata> {
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

export default async function EmpreendimentoDetailPage(props: PageProps<"/mateus/[id]">) {
  const { id } = await props.params;
  const property = await getProperty(id).catch(() => null);

  if (!property) {
    notFound();
  }

  const cover = coverImage(property);
  const gallery = property.images.filter((image) => image.id !== cover?.id).slice(0, 6);
  const features = property.features ?? [];
  const banks = property.banks ?? [];
  const notices = property.notices ?? [];
  const floorPlans = property.floor_plans ?? [];
  const address = fullAddress(property);
  const price = formatBRL(property.price);

  const specs = [
    { Icon: IconArea, label: "Área privativa", value: formatArea(property.area) },
    { Icon: IconArea, label: "Área total", value: formatArea(property.total_area) },
    {
      Icon: IconBed,
      label: "Dormitórios",
      value: property.bedrooms !== null ? String(property.bedrooms) : null,
    },
    {
      Icon: IconShower,
      label: "Suítes",
      value: property.suites !== null ? String(property.suites) : null,
    },
    {
      Icon: IconBath,
      label: "Banheiros",
      value: property.bathrooms !== null ? String(property.bathrooms) : null,
    },
    {
      Icon: IconCar,
      label: "Vagas",
      value: property.parking_spaces !== null ? String(property.parking_spaces) : null,
    },
    { Icon: IconCoin, label: "Condomínio", value: formatBRL(property.condominium_fee) },
    { Icon: IconDocument, label: "IPTU", value: formatBRL(property.iptu) },
  ].filter(
    (spec): spec is { Icon: typeof IconArea; label: string; value: string } =>
      spec.value !== null,
  );

  const whatsappMessage = `Olá! Tenho interesse em alugar o imóvel ${property.name}${
    property.city ? ` (${property.city})` : ""
  }. Pode me passar mais informações?`;

  return (
    <>
      <section className="relative flex min-h-[42vh] items-end overflow-hidden bg-brand-900">
        {cover?.url && (
          <Image
            src={cover.url}
            alt={cover.alt ?? property.name}
            fill
            priority
            sizes="100vw"
            className="object-cover"
          />
        )}

        <div className="absolute inset-0 bg-linear-to-t from-brand-900 via-brand-900/70 to-brand-900/40" />

        <div className="relative mx-auto w-full max-w-7xl px-5 pb-14 pt-36 lg:px-8">
          <Link
            href="/mateus"
            className="mb-6 inline-flex items-center gap-2 text-sm font-medium text-white/70 transition hover:text-accent-300"
          >
            <IconArrow className="h-4 w-4 rotate-180" />
            Voltar aos imóveis
          </Link>

          <div className="flex flex-wrap gap-2">
            <span className="rounded-full bg-white/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-brand-700">
              {typeLabel(property)}
            </span>
            <span className="rounded-full bg-accent-500 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
              {statusLabel(property)}
            </span>
            {constructionPhaseLabel(property) && (
              <span className="rounded-full bg-brand-700/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
                {constructionPhaseLabel(property)}
              </span>
            )}
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
                Sobre o <strong className="font-semibold">imóvel</strong>
              </h2>
              <p className="mt-4 whitespace-pre-line text-base leading-relaxed text-brand-900/65">
                {property.description ?? "Descrição em breve. Fale com um corretor para detalhes."}
              </p>
            </Reveal>

            {specs.length > 0 && (
              <Reveal className="mt-10 grid grid-cols-2 overflow-hidden rounded-2xl border border-brand-100 bg-white sm:grid-cols-3">
                {specs.map(({ Icon, label, value }) => (
                  <div
                    key={label}
                    className="flex items-start gap-3 border-b border-r border-brand-100 p-5 nth-[2n]:border-r-0 sm:nth-[2n]:border-r sm:nth-[3n]:border-r-0"
                  >
                    <Icon className="mt-0.5 h-5 w-5 shrink-0 text-accent-500" />
                    <div>
                      <p className="text-[11px] uppercase tracking-wider text-brand-900/40">
                        {label}
                      </p>
                      <p className="mt-1 text-lg font-semibold text-brand-800">{value}</p>
                    </div>
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
                    <div
                      key={image.id}
                      className="relative aspect-4/3 w-full overflow-hidden rounded-2xl"
                    >
                      <Image
                        src={image.url ?? ""}
                        alt={image.alt ?? property.name}
                        fill
                        loading="lazy"
                        sizes="(min-width: 1024px) 33vw, 50vw"
                        className="object-cover"
                      />
                    </div>
                  ))}
                </div>
              </Reveal>
            )}

            {floorPlans.length > 0 && (
              <Reveal className="mt-12">
                <h2 className="text-2xl font-light tracking-tight text-brand-800">
                  Plantas e <strong className="font-semibold">tour virtual</strong>
                </h2>
                <p className="mt-2 text-sm leading-relaxed text-brand-900/60">
                  Navegue pelas plantas do imóvel e explore o espaço em 3D.
                </p>
                <div className="mt-6">
                  <FloorPlanViewer floorPlans={floorPlans} />
                </div>
              </Reveal>
            )}

            {banks.length > 0 && (
              <Reveal className="mt-12">
                <h2 className="text-2xl font-light tracking-tight text-brand-800">
                  Bancos <strong className="font-semibold">parceiros</strong>
                </h2>
                <p className="mt-2 text-sm leading-relaxed text-brand-900/60">
                  Simule seu financiamento direto com quem oferece as melhores condições para este
                  imóvel.
                </p>
                <div className="mt-6 grid gap-4 sm:grid-cols-2">
                  {banks.map((bank) => (
                    <div
                      key={bank.id}
                      className="flex h-full flex-col rounded-2xl border border-brand-100 bg-white p-5"
                    >
                      <div className="flex items-start gap-4">
                        {bank.logo_url ? (
                          <div className="relative h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-brand-50">
                            <Image
                              src={bank.logo_url}
                              alt={bank.name}
                              fill
                              sizes="48px"
                              className="object-contain p-1.5"
                            />
                          </div>
                        ) : (
                          <span className="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-brand-50 text-brand-500">
                            <IconBank className="h-6 w-6" />
                          </span>
                        )}

                        <div className="min-w-0">
                          <p className="font-semibold text-brand-800">{bank.name}</p>
                          {bank.description && (
                            <p className="mt-1 text-sm leading-relaxed text-brand-900/60">
                              {bank.description}
                            </p>
                          )}
                        </div>
                      </div>

                      {bank.instructions && (
                        <details className="mt-3 pl-16 text-sm text-brand-900/60">
                          <summary className="cursor-pointer font-medium text-brand-700 hover:text-brand-800">
                            Como simular
                          </summary>
                          <p className="mt-2 whitespace-pre-line leading-relaxed">
                            {bank.instructions}
                          </p>
                        </details>
                      )}

                      {bank.link_simulation && (
                        <a
                          href={bank.link_simulation}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="mt-auto inline-flex w-fit items-center gap-1.5 self-start pl-16 pt-3 text-sm font-semibold text-accent-600 transition hover:text-accent-700"
                        >
                          Simular financiamento
                          <IconArrow className="h-4 w-4" />
                        </a>
                      )}
                    </div>
                  ))}
                </div>
              </Reveal>
            )}

            {notices.length > 0 && (
              <Reveal className="mt-12">
                <h2 className="text-2xl font-light tracking-tight text-brand-800">
                  Atualizações <strong className="font-semibold">deste empreendimento</strong>
                </h2>
                <p className="mt-2 text-sm leading-relaxed text-brand-900/60">
                  Notícias e novidades relacionadas a este imóvel.
                </p>
                <div className="mt-6 grid gap-4 sm:grid-cols-2">
                  {notices.map((notice) => (
                    <Link
                      key={notice.id}
                      href={`/mateus/noticias/${notice.slug}`}
                      className="group flex gap-4 rounded-2xl border border-brand-100 bg-white p-4 transition hover:border-accent-500/40 hover:bg-brand-50/60"
                    >
                      {notice.image_url && (
                        <div className="relative h-16 w-20 shrink-0 overflow-hidden rounded-xl bg-brand-100">
                          <Image
                            src={notice.image_url}
                            alt={notice.title}
                            fill
                            sizes="80px"
                            className="object-cover"
                          />
                        </div>
                      )}
                      <div className="min-w-0">
                        {notice.published_at && (
                          <p className="text-xs font-medium uppercase tracking-wide text-brand-900/40">
                            {new Date(notice.published_at).toLocaleDateString("pt-BR")}
                          </p>
                        )}
                        <p className="mt-1 truncate font-semibold text-brand-800 transition group-hover:text-accent-600">
                          {notice.title}
                        </p>
                        {notice.excerpt && (
                          <p className="mt-1 line-clamp-2 text-sm leading-relaxed text-brand-900/55">
                            {notice.excerpt}
                          </p>
                        )}
                      </div>
                    </Link>
                  ))}
                </div>
              </Reveal>
            )}
          </div>

          <aside className="lg:sticky lg:top-28 lg:self-start">
            <div className="rounded-2xl bg-white p-7 shadow-[0_24px_60px_-34px_rgba(0,32,65,0.7)] ring-1 ring-brand-900/8">
              <p className="text-[11px] uppercase tracking-wider text-brand-900/40">
                {price ? "Aluguel a partir de" : "Condições"}
              </p>
              <p className="mt-1 text-3xl font-semibold text-emerald-600">{price ?? "Sob consulta"}</p>

              <p className="mt-4 text-sm leading-relaxed text-brand-900/60">
                Fale com a gente e agende uma visita para conhecer o imóvel.
              </p>

              <a
                href={whatsappLink(whatsappMessage, mateusSite)}
                target="_blank"
                rel="noopener noreferrer"
                className="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-6 py-4 text-sm font-semibold text-white transition hover:bg-accent-600"
              >
                <IconWhatsApp className="h-5 w-5" />
                Falar com um corretor
              </a>

              <Link
                href="/mateus#contato"
                className="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-full border border-brand-200 px-6 py-4 text-sm font-semibold text-brand-600 transition hover:border-brand-500 hover:bg-brand-50"
              >
                Agendar visita
              </Link>

              <dl className="mt-7 space-y-3 border-t border-brand-100 pt-6 text-sm">
                <div className="flex justify-between gap-4">
                  <dt className="text-brand-900/45">Imobiliária</dt>
                  <dd className="font-medium text-brand-800">
                    {property.construction?.name ?? mateusSite.name}
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

      {(address || property.city) && (
        <section className="bg-white py-16 lg:py-20">
          <div className="mx-auto w-full max-w-7xl px-5 lg:px-8">
            <Reveal>
              <h2 className="text-2xl font-light tracking-tight text-brand-800">
                Onde <strong className="font-semibold">fica</strong>
              </h2>
              {address && (
                <p className="mt-2 text-sm leading-relaxed text-brand-900/60">{address}</p>
              )}
              <PropertyMap
                className="mt-6"
                address={property.address}
                addressNumber={property.address_number}
                neighborhood={property.neighborhood}
                city={property.city}
                state={property.state}
                latitude={property.latitude}
                longitude={property.longitude}
              />
            </Reveal>
          </div>
        </section>
      )}
    </>
  );
}
