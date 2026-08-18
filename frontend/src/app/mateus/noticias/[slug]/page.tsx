import Image from "next/image";
import Link from "next/link";
import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { getNotice } from "@/lib/api";
import { Reveal } from "@/components/reveal";
import { resolveMediaKind } from "@/lib/media";
import { IconArrow } from "@/components/icons";

const NOTICEABLE_LINK: Record<string, (id: number) => string> = {
  property: (id) => `/mateus/${id}`,
};

export async function generateMetadata(props: PageProps<"/mateus/noticias/[slug]">): Promise<Metadata> {
  const { slug } = await props.params;
  const notice = await getNotice(slug).catch(() => null);

  if (!notice) {
    return { title: "Notícia não encontrada" };
  }

  return {
    title: notice.title,
    description: notice.excerpt ?? undefined,
  };
}

export default async function NoticiaDetailPage(props: PageProps<"/mateus/noticias/[slug]">) {
  const { slug } = await props.params;
  const notice = await getNotice(slug).catch(() => null);

  if (!notice) {
    notFound();
  }

  const noticeableHref = notice.noticeable
    ? NOTICEABLE_LINK[notice.noticeable.type ?? ""]?.(notice.noticeable.id)
    : null;

  const media = notice.media_url ? resolveMediaKind(notice.media_url) : null;

  return (
    <>
      <section className="relative flex min-h-[52vh] items-end overflow-hidden bg-brand-900">
        {notice.image_url && (
          <Image
            src={notice.image_url}
            alt={notice.title}
            fill
            priority
            sizes="100vw"
            className="object-cover"
          />
        )}

        <div className="absolute inset-0 bg-linear-to-t from-brand-900 via-brand-900/70 to-brand-900/40" />

        <div className="relative mx-auto w-full max-w-3xl px-5 pb-14 pt-36 lg:px-8">
          <Link
            href="/mateus/noticias"
            className="mb-6 inline-flex items-center gap-2 text-sm font-medium text-white/70 transition hover:text-accent-300"
          >
            <IconArrow className="h-4 w-4 rotate-180" />
            Voltar às notícias
          </Link>

          <div className="flex flex-wrap items-center gap-2">
            {notice.published_at && (
              <span className="rounded-full bg-white/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white/80 backdrop-blur">
                {new Date(notice.published_at).toLocaleDateString("pt-BR")}
              </span>
            )}

            {notice.noticeable &&
              (noticeableHref ? (
                <Link
                  href={noticeableHref}
                  className="rounded-full bg-accent-500 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white transition hover:bg-accent-600"
                >
                  {notice.noticeable.name}
                </Link>
              ) : (
                <span className="rounded-full bg-accent-500 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">
                  {notice.noticeable.name}
                </span>
              ))}
          </div>

          <h1 className="mt-4 max-w-2xl text-3xl font-semibold leading-tight tracking-tight text-white sm:text-4xl">
            {notice.title}
          </h1>

          {notice.excerpt && (
            <p className="mt-3 max-w-xl text-base leading-relaxed text-white/75">
              {notice.excerpt}
            </p>
          )}
        </div>
      </section>

      <section className="bg-white py-16 lg:py-20">
        <article className="mx-auto w-full max-w-3xl px-5 lg:px-8">
          {media && (
            <Reveal className="mb-10 overflow-hidden rounded-2xl">
              {media.type === "youtube" || media.type === "vimeo" ? (
                <div className="relative aspect-video w-full bg-brand-900">
                  <iframe
                    src={media.embedUrl}
                    title={notice.title}
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowFullScreen
                    className="absolute inset-0 h-full w-full"
                  />
                </div>
              ) : media.type === "video" ? (
                <video src={media.url} controls className="w-full rounded-2xl" />
              ) : (
                <div className="relative aspect-video w-full">
                  <Image
                    src={media.url}
                    alt={notice.title}
                    fill
                    sizes="(min-width: 1024px) 768px, 100vw"
                    className="object-cover"
                  />
                </div>
              )}
            </Reveal>
          )}

          {notice.content && (
            <Reveal className="notice-content text-base leading-relaxed text-brand-900/75">
              <div dangerouslySetInnerHTML={{ __html: notice.content }} />
            </Reveal>
          )}

          <Reveal delay={80} className="mt-14 border-t border-brand-100 pt-8">
            <Link
              href="/mateus/noticias"
              className="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-accent-600"
            >
              <IconArrow className="h-4 w-4 rotate-180" />
              Ver todas as notícias
            </Link>
          </Reveal>
        </article>
      </section>
    </>
  );
}
