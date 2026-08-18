import Image from "next/image";
import Link from "next/link";
import type { Metadata } from "next";
import { getNotices } from "@/lib/api";
import { mateusSite } from "@/lib/site-mateus";
import { Reveal } from "@/components/reveal";
import { IconArrow, IconNewspaper } from "@/components/icons";

export const metadata: Metadata = {
  title: "Notícias",
  description: `Últimas notícias e novidades da ${mateusSite.name}.`,
};

export default async function NoticiasPage() {
  const notices = await getNotices().catch(() => []);
  const heroImage = notices.find((notice) => notice.image_url)?.image_url;

  return (
    <>
      <section className="relative flex min-h-[46vh] items-end overflow-hidden bg-brand-900">
        {heroImage && (
          <Image
            src={heroImage}
            alt=""
            fill
            priority
            sizes="100vw"
            className="object-cover"
          />
        )}

        <div className="absolute inset-0 bg-linear-to-t from-brand-900 via-brand-900/75 to-brand-900/40" />

        <div className="relative mx-auto w-full max-w-5xl px-5 pb-14 pt-36 lg:px-8 lg:pb-16">
          <p className="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/5 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.22em] text-accent-300 backdrop-blur">
            Notícias
          </p>

          <h1 className="max-w-xl text-3xl font-semibold leading-tight tracking-tight text-white sm:text-4xl">
            Fique por dentro <span className="text-accent-400">das novidades</span>
          </h1>

          <p className="mt-4 max-w-lg text-base leading-relaxed text-white/70">
            Novos imóveis, conquistas e bastidores da {mateusSite.shortName} contados como um jornal, em
            um só lugar.
          </p>
        </div>
      </section>

      <section className="bg-brand-50/60 py-24 lg:py-28">
        <div className="mx-auto w-full max-w-5xl px-5 lg:px-8">
          {notices.length === 0 ? (
            <div className="rounded-2xl border border-dashed border-brand-200 bg-white px-6 py-16 text-center">
              <p className="text-base font-semibold text-brand-800">
                Nenhuma notícia publicada no momento.
              </p>
              <p className="mt-2 text-sm text-brand-900/55">
                Volte em breve para acompanhar as novidades da {mateusSite.shortName}.
              </p>
            </div>
          ) : (
            <div className="grid gap-6 sm:grid-cols-2">
              {notices.map((notice, index) => (
                <Reveal key={notice.id} delay={index * 60}>
                  <Link
                    href={`/mateus/noticias/${notice.slug}`}
                    className="group flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_-8px_rgba(0,32,65,0.25)] ring-1 ring-brand-900/8 transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_50px_-20px_rgba(0,32,65,0.45)]"
                  >
                    <div className="relative aspect-video w-full overflow-hidden bg-brand-100">
                      {notice.image_url ? (
                        <Image
                          src={notice.image_url}
                          alt={notice.title}
                          fill
                          loading="lazy"
                          sizes="(min-width: 640px) 50vw, 100vw"
                          className="object-cover transition duration-700 group-hover:scale-105"
                        />
                      ) : (
                        <span className="grid h-full w-full place-items-center text-brand-300">
                          <IconNewspaper className="h-10 w-10" />
                        </span>
                      )}

                      <div className="absolute inset-x-0 bottom-0 h-20 bg-linear-to-t from-brand-900/70 to-transparent" />

                      {notice.noticeable && (
                        <span className="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-brand-700">
                          {notice.noticeable.name}
                        </span>
                      )}

                      {notice.published_at && (
                        <p className="absolute inset-x-4 bottom-3 text-xs font-medium text-white/90">
                          {new Date(notice.published_at).toLocaleDateString("pt-BR")}
                        </p>
                      )}
                    </div>

                    <div className="flex flex-1 flex-col p-6">
                      <h2 className="text-lg font-semibold leading-snug text-brand-800 transition group-hover:text-accent-600">
                        {notice.title}
                      </h2>

                      {notice.excerpt && (
                        <p className="mt-2 line-clamp-3 text-sm leading-relaxed text-brand-900/55">
                          {notice.excerpt}
                        </p>
                      )}

                      <span className="mt-auto inline-flex items-center gap-1.5 pt-4 text-sm font-semibold text-brand-600 transition group-hover:text-accent-600">
                        Ler notícia
                        <IconArrow className="h-4 w-4 transition group-hover:translate-x-0.5" />
                      </span>
                    </div>
                  </Link>
                </Reveal>
              ))}
            </div>
          )}
        </div>
      </section>
    </>
  );
}
