"use client";

import Image from "next/image";
import Link from "next/link";
import { useEffect, useState } from "react";
import { site, whatsappLink } from "@/lib/site";
import { IconClose, IconMenu, IconWhatsApp } from "@/components/icons";

export function SiteHeader() {
  const [scrolled, setScrolled] = useState(false);
  const [open, setOpen] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24);

    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });

    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    document.body.style.overflow = open ? "hidden" : "";

    return () => {
      document.body.style.overflow = "";
    };
  }, [open]);

  const solid = scrolled || open;

  return (
    <header
      className={`fixed inset-x-0 top-0 z-50 transition-all duration-300 ${
        solid
          ? "bg-brand-800/95 shadow-lg shadow-brand-900/20 backdrop-blur"
          : "bg-linear-to-b from-brand-900/70 to-transparent"
      }`}
    >
      <div className="mx-auto flex h-20 w-full max-w-7xl items-center gap-6 px-5 lg:px-8">
        <Link href="/canopus" className="flex items-center gap-3" onClick={() => setOpen(false)}>
          <Image
            src="/logo/canopus/canopus-logo.png"
            alt={site.name}
            width={40}
            height={40}
            priority
            className="h-10 w-10 rounded-xl object-contain"
          />
          <span className="leading-tight text-white">
            <span className="block text-lg font-semibold tracking-tight">{site.shortName}</span>
            <span className="block text-[10px] uppercase tracking-[0.28em] text-white/60">
              Construções
            </span>
          </span>
        </Link>

        <nav className="ml-auto hidden items-center gap-8 lg:flex">
          {site.nav.map((item) => (
            <a
              key={item.href}
              href={item.href}
              className="text-sm font-medium text-white/85 transition hover:text-accent-300"
            >
              {item.label}
            </a>
          ))}
        </nav>

        <a
          href={whatsappLink(`Olá! Vim pelo site da ${site.name} e quero falar com um corretor.`)}
          target="_blank"
          rel="noopener noreferrer"
          className="ml-auto hidden items-center gap-2 rounded-full bg-accent-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-accent-600 lg:ml-0 lg:inline-flex"
        >
          <IconWhatsApp className="h-4 w-4" />
          Falar com corretor
        </a>

        <button
          type="button"
          onClick={() => setOpen((value) => !value)}
          aria-label={open ? "Fechar menu" : "Abrir menu"}
          aria-expanded={open}
          className="ml-auto grid h-11 w-11 place-items-center rounded-lg text-white transition hover:bg-white/10 lg:hidden"
        >
          {open ? <IconClose className="h-6 w-6" /> : <IconMenu className="h-6 w-6" />}
        </button>
      </div>

      {open && (
        <div className="border-t border-white/10 bg-brand-800 lg:hidden">
          <div className="mx-auto flex max-w-7xl flex-col gap-1 px-5 pb-6 pt-3">
            {site.nav.map((item) => (
              <a
                key={item.href}
                href={item.href}
                onClick={() => setOpen(false)}
                className="rounded-lg px-2 py-3 text-base font-medium text-white/90 transition hover:bg-white/10"
              >
                {item.label}
              </a>
            ))}

            <a
              href={whatsappLink(`Olá! Vim pelo site da ${site.name} e quero falar com um corretor.`)}
              target="_blank"
              rel="noopener noreferrer"
              className="mt-3 inline-flex items-center justify-center gap-2 rounded-full bg-accent-500 px-5 py-3 text-sm font-semibold text-white"
            >
              <IconWhatsApp className="h-4 w-4" />
              Falar com corretor
            </a>
          </div>
        </div>
      )}
    </header>
  );
}
