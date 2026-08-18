"use client";

import { useState, type FormEvent } from "react";
import type { Property } from "@/lib/api";
import { formatPhoneBR } from "@/lib/phone";
import { site, whatsappLink, type SiteConfig } from "@/lib/site";
import { IconWhatsApp } from "@/components/icons";

const AGE_RANGES = ["18 a 24 anos", "25 a 32 anos", "33 a 45 anos", "A partir de 45 anos"];

type FormState = {
  property: string;
  name: string;
  email: string;
  phone: string;
  ageRange: string;
  consent: boolean;
};

const EMPTY: FormState = {
  property: "",
  name: "",
  email: "",
  phone: "",
  ageRange: "",
  consent: false,
};

export function SimulationForm({
  properties,
  config = site,
}: {
  properties: Property[];
  config?: SiteConfig;
}) {
  const [form, setForm] = useState<FormState>(EMPTY);
  const [sent, setSent] = useState(false);

  const isRental = config.dealType === "rental";

  const fieldClass =
    "w-full rounded-xl border border-white/15 bg-white/5 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-white/40 focus:border-accent-400 focus:bg-white/10 focus:ring-2 focus:ring-accent-400/25";

  function update<K extends keyof FormState>(key: K, value: FormState[K]) {
    setForm((prev) => ({ ...prev, [key]: value }));
  }

  function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    const message = [
      isRental
        ? `Olá! Quero saber mais sobre alugar um imóvel na ${config.name}.`
        : `Olá! Quero uma simulação de financiamento na ${config.name}.`,
      "",
      `Nome: ${form.name}`,
      `E-mail: ${form.email}`,
      `Telefone: ${form.phone}`,
      form.property ? `Imóvel: ${form.property}` : null,
      !isRental && form.ageRange ? `Faixa etária: ${form.ageRange}` : null,
    ]
      .filter((line) => line !== null)
      .join("\n");

    window.open(whatsappLink(message, config), "_blank", "noopener,noreferrer");
    setSent(true);
  }

  return (
    <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2">
      <label className="block sm:col-span-2">
        <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-white/50">
          Qual imóvel você tem interesse?
        </span>
        <select
          value={form.property}
          onChange={(event) => update("property", event.target.value)}
          className={`${fieldClass} appearance-none`}
        >
          <option value="" className="text-brand-900">
            Selecione...
          </option>
          {properties.map((property) => (
            <option key={property.id} value={property.name} className="text-brand-900">
              {property.name}
            </option>
          ))}
        </select>
      </label>

      <label className="block">
        <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-white/50">
          Nome
        </span>
        <input
          required
          value={form.name}
          onChange={(event) => update("name", event.target.value)}
          placeholder="Seu nome completo"
          className={fieldClass}
        />
      </label>

      <label className="block">
        <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-white/50">
          E-mail
        </span>
        <input
          required
          type="email"
          value={form.email}
          onChange={(event) => update("email", event.target.value)}
          placeholder="voce@email.com"
          className={fieldClass}
        />
      </label>

      <label className="block">
        <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-white/50">
          Telefone
        </span>
        <input
          required
          type="tel"
          value={form.phone}
          onChange={(event) => update("phone", formatPhoneBR(event.target.value))}
          placeholder="(00) 00000-0000"
          className={fieldClass}
        />
      </label>

      {!isRental && (
        <label className="block">
          <span className="mb-2 block text-[11px] font-semibold uppercase tracking-[0.16em] text-white/50">
            Faixa etária
          </span>
          <select
            value={form.ageRange}
            onChange={(event) => update("ageRange", event.target.value)}
            className={`${fieldClass} appearance-none`}
          >
            <option value="" className="text-brand-900">
              Selecione...
            </option>
            {AGE_RANGES.map((range) => (
              <option key={range} value={range} className="text-brand-900">
                {range}
              </option>
            ))}
          </select>
        </label>
      )}

      <label className="flex items-start gap-3 text-xs leading-relaxed text-white/60 sm:col-span-2">
        <input
          required
          type="checkbox"
          checked={form.consent}
          onChange={(event) => update("consent", event.target.checked)}
          className="mt-0.5 h-4 w-4 shrink-0 accent-accent-500"
        />
        Autorizo o contato de um corretor e concordo com a política de privacidade da {config.name}.
      </label>

      <div className="sm:col-span-2">
        <button
          type="submit"
          className="inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-8 py-4 text-sm font-semibold text-white transition hover:bg-accent-600 sm:w-auto"
        >
          <IconWhatsApp className="h-5 w-5" />
          Enviar e falar com um corretor
        </button>

        {sent && (
          <p className="mt-4 text-sm text-accent-200">
            Abrimos o WhatsApp com seus dados. Se a janela não abriu, chame direto em{" "}
            {config.phoneLabel}.
          </p>
        )}
      </div>
    </form>
  );
}
