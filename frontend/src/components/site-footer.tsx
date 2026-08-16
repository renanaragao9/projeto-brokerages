import Image from "next/image";
import Link from "next/link";
import { site } from "@/lib/site";
import {
  IconFacebook,
  IconInstagram,
  IconMail,
  IconPhone,
  IconPin,
  IconYoutube,
} from "@/components/icons";

export function SiteFooter() {
  const year = new Date().getFullYear();

  return (
    <footer className="bg-brand-900 text-white/70">
      <div className="mx-auto grid w-full max-w-7xl gap-12 px-5 py-16 lg:grid-cols-4 lg:px-8">
        <div className="lg:col-span-2">
          <Link href="/canopus" className="mb-5 inline-flex items-center gap-3">
            <Image
              src="/logo/canopus/canopus-logo.png"
              alt={site.name}
              width={40}
              height={40}
              className="h-10 w-10 rounded-xl object-contain"
            />
            <span className="leading-tight text-white">
              <span className="block text-lg font-semibold tracking-tight">{site.shortName}</span>
              <span className="block text-[10px] uppercase tracking-[0.28em] text-white/50">
                Construções
              </span>
            </span>
          </Link>

          <p className="max-w-md text-sm leading-relaxed">
            Empreendimentos residenciais com lazer completo, localização estratégica e as melhores
            condições de financiamento do mercado.
          </p>

          <div className="mt-6 flex gap-3">
            {[
              { href: site.social.instagram, label: "Instagram", Icon: IconInstagram },
              { href: site.social.facebook, label: "Facebook", Icon: IconFacebook },
              { href: site.social.youtube, label: "YouTube", Icon: IconYoutube },
            ].map(({ href, label, Icon }) => (
              <a
                key={label}
                href={href}
                target="_blank"
                rel="noopener noreferrer"
                aria-label={label}
                className="grid h-10 w-10 place-items-center rounded-full border border-white/15 text-white/80 transition hover:border-accent-500 hover:bg-accent-500 hover:text-white"
              >
                <Icon className="h-5 w-5" />
              </a>
            ))}
          </div>
        </div>

        <div>
          <h3 className="mb-4 text-xs font-semibold uppercase tracking-[0.2em] text-white">
            Navegação
          </h3>
          <ul className="space-y-3 text-sm">
            {site.nav.map((item) => (
              <li key={item.href}>
                <a href={item.href} className="transition hover:text-accent-300">
                  {item.label}
                </a>
              </li>
            ))}
          </ul>
        </div>

        <div>
          <h3 className="mb-4 text-xs font-semibold uppercase tracking-[0.2em] text-white">
            Contato
          </h3>
          <ul className="space-y-4 text-sm">
            <li className="flex gap-3">
              <IconPhone className="mt-0.5 h-4 w-4 shrink-0 text-accent-400" />
              <a href={`tel:+${site.whatsapp}`} className="transition hover:text-accent-300">
                {site.phoneLabel}
              </a>
            </li>
            <li className="flex gap-3">
              <IconMail className="mt-0.5 h-4 w-4 shrink-0 text-accent-400" />
              <a href={`mailto:${site.email}`} className="transition hover:text-accent-300">
                {site.email}
              </a>
            </li>
            <li className="flex gap-3">
              <IconPin className="mt-0.5 h-4 w-4 shrink-0 text-accent-400" />
              <span>{site.addressLine}</span>
            </li>
          </ul>
        </div>
      </div>

      <div className="border-t border-white/10">
        <div className="mx-auto flex w-full max-w-7xl flex-col gap-2 px-5 py-6 text-xs sm:flex-row sm:items-center sm:justify-between lg:px-8">
          <p>
            © {year} {site.name}. Todos os direitos reservados. {site.creci}
          </p>
          <p>
            Imagens meramente ilustrativas. Valores e condições sujeitos a alteração sem aviso
            prévio.
          </p>
        </div>
      </div>
    </footer>
  );
}
