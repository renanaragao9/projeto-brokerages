import Image from "next/image";
import { getProperties } from "@/lib/api";
import { coverImage } from "@/lib/property";
import { mateusSite } from "@/lib/site-mateus";
import { whatsappLink } from "@/lib/site";
import { PropertyExplorer } from "@/components/property-explorer";
import { SimulationForm } from "@/components/simulation-form";
import { Reveal } from "@/components/reveal";
import { HeroVideoBackground } from "@/components/hero-video-background";
import {
  IconArrow,
  IconBank,
  IconBuilding,
  IconDocument,
  IconKey,
  IconMail,
  IconPhone,
  IconPin,
  IconPool,
  IconShield,
  IconWhatsApp,
} from "@/components/icons";

const BENEFITS = [
  {
    Icon: IconKey,
    title: "Aluguel sem burocracia",
    text: "Documentação, contrato e entrega das chaves em um processo simples e rápido.",
  },
  {
    Icon: IconBank,
    title: "Garantia flexível",
    text: "Fiador, caução ou seguro fiança: você escolhe a opção que melhor se encaixa no seu perfil.",
  },
  {
    Icon: IconShield,
    title: "Padrão de qualidade",
    text: "Imóveis vistoriados, com laudo de entrega e assistência durante todo o contrato.",
  },
  {
    Icon: IconPin,
    title: "Localização estratégica",
    text: "Bairros em expansão, perto de comércio, escolas e dos principais acessos da cidade.",
  },
];

const HERO_VIDEOS = [
  "/movies/mateus/13543877-uhd_3840_2160_24fps.mp4",
  "/movies/mateus/17251490-uhd_2560_1440_25fps.mp4",
];

export default async function MateusLandingPage() {
  const properties = (await getProperties(mateusSite.name).catch(() => null)) ?? [];

  const gallery = properties
    .map((property) => coverImage(property)?.url)
    .filter((url): url is string => Boolean(url));

  const cities = new Set(properties.map((property) => property.city).filter(Boolean));
  const yearsInMarket = new Date().getFullYear() - mateusSite.foundedYear;

  const stats = [
    { value: String(properties.length), label: "Imóveis" },
    { value: String(cities.size), label: "Cidades atendidas" },
    { value: `${yearsInMarket}+`, label: "Anos de mercado" },
  ];

  return (
    <>
      <section className="relative flex min-h-screen items-end overflow-hidden bg-brand-900">
        <HeroVideoBackground videos={HERO_VIDEOS} poster="/logo/mateus/mateus-capa.jpeg" />

        <div className="absolute inset-0 bg-linear-to-r from-brand-900 via-brand-900/80 to-brand-900/25" />
        <div className="absolute inset-0 bg-linear-to-t from-brand-900 via-transparent to-brand-900/60" />

        <div className="relative mx-auto w-full max-w-7xl px-5 pb-14 pt-36 lg:px-8 lg:pb-20">
          <div className="max-w-2xl">
            <p className="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/5 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-300 backdrop-blur">
              Aluguel de imóveis
            </p>

            <h1 className="text-4xl font-semibold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
              O lar ideal,
              <span className="block text-accent-400">pronto para você alugar.</span>
            </h1>

            <p className="mt-6 max-w-xl text-base leading-relaxed text-white/75 sm:text-lg">
              Imóveis com lazer completo, localização estratégica e contratos
              flexíveis de aluguel. Encontre o seu e fale hoje com um corretor.
            </p>

            <div className="mt-9 flex flex-col gap-3 sm:flex-row">
              <a
                href="#imoveis"
                className="inline-flex items-center justify-center gap-2 rounded-full bg-accent-500 px-8 py-4 text-sm font-semibold text-white transition hover:bg-accent-600"
              >
                <IconBuilding className="h-4 w-4" />
                Ver imóveis
                <IconArrow className="h-4 w-4" />
              </a>

              <a
                href={whatsappLink(
                  `Olá! Vim pelo site da ${mateusSite.name} e quero falar com um corretor.`,
                  mateusSite,
                )}
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center justify-center gap-2 rounded-full border border-white/25 px-8 py-4 text-sm font-semibold text-white backdrop-blur transition hover:border-white hover:bg-white/10"
              >
                <IconWhatsApp className="h-4 w-4" />
                Falar com corretor
              </a>
            </div>
          </div>

          <dl className="mt-16 grid grid-cols-2 gap-x-6 gap-y-8 border-t border-white/15 pt-8 lg:grid-cols-4">
            {stats.map((stat) => (
              <div key={stat.label}>
                <dt className="text-xs uppercase tracking-[0.16em] text-white/50">
                  {stat.label}
                </dt>
                <dd className="mt-1 text-3xl font-semibold text-white lg:text-4xl">
                  {stat.value}
                </dd>
              </div>
            ))}
          </dl>
        </div>
      </section>

      <section
        id="imoveis"
        className="scroll-mt-24 bg-brand-50/60 py-24 lg:py-28"
      >
        <div className="mx-auto w-full max-w-7xl px-5 lg:px-8">
          <Reveal className="mb-10 max-w-2xl">
            <p className="mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-600">
              Nossos imóveis
            </p>
            <h2 className="text-3xl font-light leading-tight tracking-tight text-brand-800 sm:text-4xl">
              Encontre <strong className="font-semibold">seu imóvel</strong>
            </h2>
            <p className="mt-4 text-base leading-relaxed text-brand-900/60">
              Use os filtros para ver os imóveis disponíveis para alugar por
              cidade, tipo e número de quartos.
            </p>
          </Reveal>

          {properties.length === 0 ? (
            <div className="rounded-2xl border border-dashed border-brand-200 bg-white px-6 py-16 text-center">
              <p className="text-base font-semibold text-brand-800">
                Nenhum imóvel disponível no momento.
              </p>
              <p className="mt-2 text-sm text-brand-900/55">
                Fale com um corretor para saber sobre os próximos imóveis disponíveis.
              </p>
            </div>
          ) : (
            <PropertyExplorer
              properties={properties}
              basePath="/mateus"
              dealType={mateusSite.dealType}
            />
          )}
        </div>
      </section>

      <section
        id="vantagens"
        className="scroll-mt-24 bg-brand-800 py-24 text-white lg:py-28"
      >
        <div className="mx-auto w-full max-w-7xl px-5 lg:px-8">
          <Reveal className="mb-14 max-w-2xl">
            <p className="mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-400">
              Vantagens
            </p>
            <h2 className="text-3xl font-light leading-tight tracking-tight sm:text-4xl">
              Com a {mateusSite.shortName}{" "}
              <strong className="font-semibold text-accent-400">
                tudo fica mais fácil
              </strong>
            </h2>
          </Reveal>

          <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {BENEFITS.map(({ Icon, title, text }, index) => (
              <Reveal
                key={title}
                delay={index * 80}
                className="rounded-2xl border border-white/10 bg-white/5 p-7 transition hover:border-accent-500/60 hover:bg-white/10"
              >
                <span className="mb-6 grid h-12 w-12 place-items-center rounded-xl bg-accent-500 text-white">
                  <Icon className="h-6 w-6" />
                </span>
                <h3 className="mb-2 text-lg font-semibold">{title}</h3>
                <p className="text-sm leading-relaxed text-white/65">{text}</p>
              </Reveal>
            ))}
          </div>
        </div>
      </section>

      <section id="sobre" className="scroll-mt-24 bg-white py-24 lg:py-28">
        <div className="mx-auto grid w-full max-w-7xl items-center gap-14 px-5 lg:grid-cols-2 lg:px-8">
          <Reveal className="order-2 lg:order-1">
            <p className="mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-600">
              A imobiliária
            </p>
            <h2 className="text-3xl font-light leading-tight tracking-tight text-brand-800 sm:text-4xl">
              Por que escolher a{" "}
              <strong className="font-semibold">{mateusSite.shortName}</strong>
            </h2>

            <p className="mt-6 text-base leading-relaxed text-brand-900/65">
              Há {yearsInMarket} anos ajudando você a encontrar o imóvel ideal
              para alugar, planejado para quem quer morar bem sem abrir mão do
              orçamento. Cada contrato nasce da mesma ideia: unir lazer
              completo, boa localização e um processo de aluguel simples do
              começo ao fim.
            </p>

            <p className="mt-4 text-base leading-relaxed text-brand-900/65">
              Nossa equipe acompanha você em todas as etapas — da escolha do
              imóvel à assinatura do contrato — para que a única surpresa
              seja a data da mudança.
            </p>

            <ul className="mt-8 grid gap-4 sm:grid-cols-2">
              {[
                { Icon: IconPool, text: "Lazer completo nos melhores condomínios" },
                { Icon: IconDocument, text: "Documentação e contrato assistidos" },
                { Icon: IconPin, text: "Atendimento personalizado" },
                { Icon: IconShield, text: "Segurança jurídica em todas as etapas" },
              ].map(({ Icon, text }) => (
                <li
                  key={text}
                  className="flex items-start gap-3 text-sm text-brand-900/70"
                >
                  <Icon className="mt-0.5 h-5 w-5 shrink-0 text-accent-500" />
                  {text}
                </li>
              ))}
            </ul>

            <a
              href="#contato"
              className="mt-10 inline-flex items-center gap-2 rounded-full bg-brand-500 px-8 py-4 text-sm font-semibold text-white transition hover:bg-brand-600"
            >
              Agende uma visita
              <IconArrow className="h-4 w-4" />
            </a>
          </Reveal>

          <Reveal className="order-1 lg:order-2" delay={120}>
            {gallery.length > 0 ? (
              <div className="grid grid-cols-2 gap-4">
                {gallery.slice(0, 4).map((url, index) => (
                  <div
                    key={url}
                    className={`relative w-full overflow-hidden rounded-2xl ${
                      index % 3 === 0 ? "aspect-3/4" : "aspect-square"
                    } ${index === 1 ? "mt-8" : ""} ${index === 3 ? "mt-8" : ""}`}
                  >
                    <Image
                      src={url}
                      alt={`${mateusSite.name} — imóvel ${index + 1}`}
                      fill
                      loading="lazy"
                      sizes="(min-width: 1024px) 25vw, 50vw"
                      className="object-cover"
                    />
                  </div>
                ))}
              </div>
            ) : (
              <div className="relative aspect-[3512/1184] w-full overflow-hidden rounded-2xl shadow-[0_24px_60px_-34px_rgba(0,0,0,0.5)]">
                <Image
                  src="/logo/mateus/mateus-capa.jpeg"
                  alt={mateusSite.name}
                  fill
                  loading="lazy"
                  sizes="(min-width: 1024px) 40vw, 100vw"
                  className="object-cover"
                />
              </div>
            )}
          </Reveal>
        </div>
      </section>

      <section
        id="contato"
        className="scroll-mt-24 bg-brand-900 py-24 text-white lg:py-28"
      >
        <div className="mx-auto grid w-full max-w-7xl gap-14 px-5 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
          <Reveal>
            <p className="mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-400">
              Contato
            </p>
            <h2 className="text-3xl font-light leading-tight tracking-tight sm:text-4xl">
              Quer alugar?{" "}
              <strong className="block font-semibold text-accent-400">
                Fale com os nossos corretores
              </strong>
            </h2>

            <p className="mt-6 max-w-md text-base leading-relaxed text-white/65">
              Informe seus dados e um corretor entra em contato para agendar
              uma visita e fechar seu contrato de aluguel.
            </p>

            <ul className="mt-10 space-y-5 text-sm">
              <li className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/15 text-accent-400">
                  <IconPhone className="h-5 w-5" />
                </span>
                <a
                  href={`tel:+${mateusSite.whatsapp}`}
                  className="transition hover:text-accent-300"
                >
                  {mateusSite.phoneLabel}
                </a>
              </li>
              <li className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/15 text-accent-400">
                  <IconMail className="h-5 w-5" />
                </span>
                <a
                  href={`mailto:${mateusSite.email}`}
                  className="transition hover:text-accent-300"
                >
                  {mateusSite.email}
                </a>
              </li>
              <li className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/15 text-accent-400">
                  <IconPin className="h-5 w-5" />
                </span>
                <span className="text-white/70">{mateusSite.addressLine}</span>
              </li>
            </ul>
          </Reveal>

          <Reveal
            delay={120}
            className="rounded-2xl border border-white/10 bg-white/4 p-7 backdrop-blur sm:p-9"
          >
            <SimulationForm properties={properties} config={mateusSite} />
          </Reveal>
        </div>
      </section>
    </>
  );
}