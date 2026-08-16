import Image from "next/image";
import { getProperties } from "@/lib/api";
import { coverImage } from "@/lib/property";
import { site, whatsappLink } from "@/lib/site";
import { PropertyExplorer } from "@/components/property-explorer";
import { SimulationForm } from "@/components/simulation-form";
import { Reveal } from "@/components/reveal";
import {
  IconArrow,
  IconBank,
  IconBuilding,
  IconCrane,
  IconDocument,
  IconKey,
  IconMail,
  IconPhone,
  IconPin,
  IconPool,
  IconShield,
  IconWhatsApp,
  IconWrench,
} from "@/components/icons";

const BENEFITS = [
  {
    Icon: IconKey,
    title: "Minha Casa Minha Vida",
    text: "Apartamentos dentro do programa, com juros reduzidos e subsídio do governo na entrada.",
  },
  {
    Icon: IconBank,
    title: "Melhores condições de financiamento",
    text: "Parceria com a Caixa Econômica Federal para garantir as taxas mais competitivas do mercado.",
  },
  {
    Icon: IconShield,
    title: "Padrão de qualidade",
    text: "Projetos com lazer completo, acabamento entregue e assistência técnica após as chaves.",
  },
  {
    Icon: IconPin,
    title: "Localização estratégica",
    text: "Bairros em expansão, perto de comércio, escolas e dos principais acessos da cidade.",
  },
];

export default async function CanopusLandingPage() {
  const properties = (await getProperties(site.name).catch(() => null)) ?? [];

  const hero =
    properties.find((property) => property.is_featured) ?? properties[0];
  const heroImage = hero ? coverImage(hero) : undefined;
  const gallery = properties
    .map((property) => coverImage(property)?.url)
    .filter((url): url is string => Boolean(url));

  const cities = new Set(
    properties.map((property) => property.city).filter(Boolean),
  );
  const yearsInMarket = new Date().getFullYear() - site.foundedYear;

  const stats = [
    { value: String(properties.length), label: "Empreendimentos" },
    { value: String(cities.size), label: "Cidades atendidas" },
    { value: `${yearsInMarket}+`, label: "Anos de mercado" },
  ];

  return (
    <>
      {/* ---------- Hero ---------- */}
      <section className="relative flex min-h-screen items-end overflow-hidden bg-brand-900">
        {heroImage?.url && (
          <Image
            src={heroImage.url}
            alt={heroImage.alt ?? hero?.name ?? site.name}
            fill
            priority
            sizes="100vw"
            className="animate-ken-burns object-cover"
          />
        )}

        <div className="absolute inset-0 bg-linear-to-r from-brand-900 via-brand-900/80 to-brand-900/25" />
        <div className="absolute inset-0 bg-linear-to-t from-brand-900 via-transparent to-brand-900/60" />

        <div className="relative mx-auto w-full max-w-7xl px-5 pb-14 pt-36 lg:px-8 lg:pb-20">
          <div className="max-w-2xl">
            <p className="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/5 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-300 backdrop-blur">
              Construtora e incorporadora
            </p>

            <h1 className="text-4xl font-semibold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-6xl">
              O futuro que você merece,
              <span className="block text-accent-400">pronto para morar.</span>
            </h1>

            <p className="mt-6 max-w-xl text-base leading-relaxed text-white/75 sm:text-lg">
              Condomínios com lazer completo, localização estratégica e as
              melhores condições de financiamento do mercado. Encontre o seu
              apartamento e fale hoje com um corretor.
            </p>

            <div className="mt-9 flex flex-col gap-3 sm:flex-row">
              <a
                href="#empreendimentos"
                className="inline-flex items-center justify-center gap-2 rounded-full bg-accent-500 px-8 py-4 text-sm font-semibold text-white transition hover:bg-accent-600"
              >
                <IconBuilding className="h-4 w-4" />
                Ver empreendimentos
                <IconArrow className="h-4 w-4" />
              </a>

              <a
                href={whatsappLink(
                  `Olá! Vim pelo site da ${site.name} e quero falar com um corretor.`,
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
        id="empreendimentos"
        className="scroll-mt-24 bg-brand-50/60 py-24 lg:py-28"
      >
        <div className="mx-auto w-full max-w-7xl px-5 lg:px-8">
          <Reveal className="mb-10 max-w-2xl">
            <p className="mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-600">
              Nossos empreendimentos
            </p>
            <h2 className="text-3xl font-light leading-tight tracking-tight text-brand-800 sm:text-4xl">
              Encontre <strong className="font-semibold">seu imóvel</strong>
            </h2>
            <p className="mt-4 text-base leading-relaxed text-brand-900/60">
              Use os filtros para ver os condomínios disponíveis por cidade,
              tipo e número de quartos.
            </p>
          </Reveal>

          {properties.length === 0 ? (
            <div className="rounded-2xl border border-dashed border-brand-200 bg-white px-6 py-16 text-center">
              <p className="text-base font-semibold text-brand-800">
                Nenhum empreendimento disponível no momento.
              </p>
              <p className="mt-2 text-sm text-brand-900/55">
                Fale com um corretor para saber sobre os próximos lançamentos.
              </p>
            </div>
          ) : (
            <PropertyExplorer properties={properties} />
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
              Com a {site.shortName}{" "}
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

      {/* ---------- Sobre ---------- */}
      <section id="sobre" className="scroll-mt-24 bg-white py-24 lg:py-28">
        <div className="mx-auto grid w-full max-w-7xl items-center gap-14 px-5 lg:grid-cols-2 lg:px-8">
          <Reveal className="order-2 lg:order-1">
            <p className="mb-3 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-600">
              A construtora
            </p>
            <h2 className="text-3xl font-light leading-tight tracking-tight text-brand-800 sm:text-4xl">
              Por que escolher a{" "}
              <strong className="font-semibold">{site.shortName}</strong>
            </h2>

            <p className="mt-6 text-base leading-relaxed text-brand-900/65">
              Há {yearsInMarket} anos entregando condomínios residenciais
              planejados para quem quer morar bem sem abrir mão do orçamento.
              Cada projeto nasce da mesma ideia: unir lazer completo, boa
              localização e um processo de compra simples do começo ao fim.
            </p>

            <p className="mt-4 text-base leading-relaxed text-brand-900/65">
              Nossa equipe acompanha você em todas as etapas — da escolha da
              planta à aprovação do financiamento — para que a única surpresa
              seja a data da mudança.
            </p>

            <ul className="mt-8 grid gap-4 sm:grid-cols-2">
              {[
                { Icon: IconPool, text: "Lazer completo em todos os condomínios" },
                { Icon: IconDocument, text: "Documentação e financiamento assistidos" },
                { Icon: IconCrane, text: "Obras acompanhadas de perto" },
                { Icon: IconWrench, text: "Assistência técnica após a entrega" },
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

          <Reveal
            className="order-1 grid grid-cols-2 gap-4 lg:order-2"
            delay={120}
          >
            {gallery.slice(0, 4).map((url, index) => (
              <div
                key={url}
                className={`relative w-full overflow-hidden rounded-2xl ${
                  index % 3 === 0 ? "aspect-3/4" : "aspect-square"
                } ${index === 1 ? "mt-8" : ""} ${index === 3 ? "mt-8" : ""}`}
              >
                <Image
                  src={url}
                  alt={`${site.name} — empreendimento ${index + 1}`}
                  fill
                  loading="lazy"
                  sizes="(min-width: 1024px) 25vw, 50vw"
                  className="object-cover"
                />
              </div>
            ))}
          </Reveal>
        </div>
      </section>

      {/* ---------- Contato ---------- */}
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
              Peça uma simulação{" "}
              <strong className="block font-semibold text-accent-400">
                para os nossos corretores
              </strong>
            </h2>

            <p className="mt-6 max-w-md text-base leading-relaxed text-white/65">
              Informe seus dados e um corretor entra em contato para calcular
              subsídio, entrada e parcela do seu apartamento.
            </p>

            <ul className="mt-10 space-y-5 text-sm">
              <li className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/15 text-accent-400">
                  <IconPhone className="h-5 w-5" />
                </span>
                <a
                  href={`tel:+${site.whatsapp}`}
                  className="transition hover:text-accent-300"
                >
                  {site.phoneLabel}
                </a>
              </li>
              <li className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/15 text-accent-400">
                  <IconMail className="h-5 w-5" />
                </span>
                <a
                  href={`mailto:${site.email}`}
                  className="transition hover:text-accent-300"
                >
                  {site.email}
                </a>
              </li>
              <li className="flex items-center gap-4">
                <span className="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-white/15 text-accent-400">
                  <IconPin className="h-5 w-5" />
                </span>
                <span className="text-white/70">{site.addressLine}</span>
              </li>
            </ul>
          </Reveal>

          <Reveal
            delay={120}
            className="rounded-2xl border border-white/10 bg-white/4 p-7 backdrop-blur sm:p-9"
          >
            <SimulationForm properties={properties} />
          </Reveal>
        </div>
      </section>
    </>
  );
}
