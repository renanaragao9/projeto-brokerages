"use client";

import Image from "next/image";
import { useState, type ChangeEvent, type FormEvent } from "react";
import {
  ApiRequestError,
  submitConstructionUpdate,
  type ConstructionUpdate,
} from "@/lib/api";
import { formatPhoneBR } from "@/lib/phone";
import { IconCamera } from "@/components/icons";

type FormState = {
  name: string;
  email: string;
  phone: string;
  message: string;
};

const EMPTY: FormState = { name: "", email: "", phone: "", message: "" };

export function ConstructionUpdates({
  propertyId,
  updates,
}: {
  propertyId: number;
  updates: ConstructionUpdate[];
}) {
  const [form, setForm] = useState<FormState>(EMPTY);
  const [file, setFile] = useState<File | null>(null);
  const [status, setStatus] = useState<"idle" | "sending" | "sent" | "error">("idle");
  const [error, setError] = useState<string | null>(null);

  const fieldClass =
    "w-full rounded-xl border border-brand-200 bg-white px-4 py-3 text-sm text-brand-900 outline-none transition placeholder:text-brand-900/35 focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20";

  function update<K extends keyof FormState>(key: K, value: FormState[K]) {
    setForm((prev) => ({ ...prev, [key]: value }));
  }

  function handleFile(event: ChangeEvent<HTMLInputElement>) {
    setFile(event.target.files?.[0] ?? null);
  }

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    if (!file) {
      setError("Selecione uma foto para enviar.");
      setStatus("error");
      return;
    }

    setStatus("sending");
    setError(null);

    try {
      await submitConstructionUpdate({
        property_id: propertyId,
        author_name: form.name,
        author_email: form.email || undefined,
        author_phone: form.phone || undefined,
        message: form.message || undefined,
        image: file,
      });

      setForm(EMPTY);
      setFile(null);
      setStatus("sent");
    } catch (submitError) {
      setError(
        submitError instanceof ApiRequestError
          ? submitError.message
          : "Não foi possível enviar sua atualização. Tente novamente."
      );
      setStatus("error");
    }
  }

  return (
    <div className="grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
      <div>
        <h3 className="text-xl font-semibold text-brand-800">Fotos de quem acompanha de perto</h3>
        <p className="mt-2 text-sm leading-relaxed text-brand-900/60">
          Moradores e visitantes compartilham o dia a dia da obra. Publicações passam por
          aprovação antes de aparecer aqui.
        </p>

        {updates.length === 0 ? (
          <div className="mt-6 rounded-2xl border border-dashed border-brand-200 bg-brand-50/60 px-6 py-10 text-center text-sm text-brand-900/50">
            Nenhuma foto publicada ainda. Seja o primeiro a compartilhar!
          </div>
        ) : (
          <div className="mt-6 grid gap-4 sm:grid-cols-2">
            {updates.map((item) => (
              <figure
                key={item.id}
                className="overflow-hidden rounded-2xl bg-white shadow-[0_2px_20px_-8px_rgba(0,32,65,0.25)] ring-1 ring-brand-900/8"
              >
                <div className="relative aspect-4/3 w-full">
                  <Image
                    src={item.image_url}
                    alt={item.message ?? `Foto enviada por ${item.author_name}`}
                    fill
                    loading="lazy"
                    sizes="(min-width: 1024px) 25vw, 50vw"
                    className="object-cover"
                  />
                </div>
                <figcaption className="p-4">
                  {item.message && (
                    <p className="text-sm leading-relaxed text-brand-900/70">{item.message}</p>
                  )}
                  <p className="mt-2 text-xs font-medium text-brand-900/45">
                    {item.author_name} ·{" "}
                    {new Date(item.created_at).toLocaleDateString("pt-BR")}
                  </p>
                </figcaption>
              </figure>
            ))}
          </div>
        )}
      </div>

      <form
        onSubmit={handleSubmit}
        className="rounded-2xl border border-brand-100 bg-brand-50/60 p-6 sm:p-7"
      >
        <h4 className="text-base font-semibold text-brand-800">Compartilhe uma foto</h4>
        <p className="mt-1 text-xs leading-relaxed text-brand-900/55">
          Sua foto só aparece no site depois de revisada pela nossa equipe.
        </p>

        <div className="mt-5 grid gap-4">
          <label className="block">
            <span className="mb-1.5 block text-[11px] font-semibold uppercase tracking-wide text-brand-900/45">
              Nome
            </span>
            <input
              required
              value={form.name}
              onChange={(event) => update("name", event.target.value)}
              placeholder="Seu nome"
              className={fieldClass}
            />
          </label>

          <label className="block">
            <span className="mb-1.5 block text-[11px] font-semibold uppercase tracking-wide text-brand-900/45">
              E-mail (opcional)
            </span>
            <input
              type="email"
              value={form.email}
              onChange={(event) => update("email", event.target.value)}
              placeholder="voce@email.com"
              className={fieldClass}
            />
          </label>

          <label className="block">
            <span className="mb-1.5 block text-[11px] font-semibold uppercase tracking-wide text-brand-900/45">
              Telefone (opcional)
            </span>
            <input
              type="tel"
              value={form.phone}
              onChange={(event) => update("phone", formatPhoneBR(event.target.value))}
              placeholder="(00) 00000-0000"
              className={fieldClass}
            />
          </label>

          <label className="block">
            <span className="mb-1.5 block text-[11px] font-semibold uppercase tracking-wide text-brand-900/45">
              Mensagem (opcional)
            </span>
            <textarea
              rows={3}
              value={form.message}
              onChange={(event) => update("message", event.target.value)}
              placeholder="Como está o andamento?"
              className={fieldClass}
            />
          </label>

          <label className="block">
            <span className="mb-1.5 block text-[11px] font-semibold uppercase tracking-wide text-brand-900/45">
              Foto
            </span>
            <div className="flex items-center gap-3 rounded-xl border border-dashed border-brand-300 bg-white px-4 py-3.5 text-sm text-brand-900/60">
              <IconCamera className="h-5 w-5 shrink-0 text-accent-500" />
              <input
                required
                type="file"
                accept="image/*"
                onChange={handleFile}
                className="w-full text-sm file:mr-3 file:rounded-full file:border-0 file:bg-brand-500 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white"
              />
            </div>
          </label>
        </div>

        <button
          type="submit"
          disabled={status === "sending"}
          className="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-accent-600 disabled:cursor-not-allowed disabled:bg-brand-100 disabled:text-brand-900/35"
        >
          {status === "sending" ? "Enviando..." : "Enviar foto"}
        </button>

        {status === "sent" && (
          <p className="mt-4 text-sm text-brand-600">
            Recebemos sua foto! Ela será exibida assim que aprovada.
          </p>
        )}

        {status === "error" && error && <p className="mt-4 text-sm text-red-600">{error}</p>}
      </form>
    </div>
  );
}
