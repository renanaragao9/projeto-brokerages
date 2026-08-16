"use client";

import Image from "next/image";
import { useState } from "react";
import type { PropertyFloorPlan } from "@/lib/api";
import { IconArrow, IconCube } from "@/components/icons";

function embedUrl(tourUrl: string): string {
  const youtube = tourUrl.match(
    /(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([\w-]{11})/
  );
  if (youtube) return `https://www.youtube.com/embed/${youtube[1]}`;

  const vimeo = tourUrl.match(/vimeo\.com\/(?:video\/)?(\d+)/);
  if (vimeo) return `https://player.vimeo.com/video/${vimeo[1]}`;

  // Matterport, Kuula e provedores similares já entregam um link embutível direto.
  return tourUrl;
}

export function FloorPlanViewer({ floorPlans }: { floorPlans: PropertyFloorPlan[] }) {
  const [index, setIndex] = useState(0);

  if (floorPlans.length === 0) return null;

  const active = floorPlans[index];
  const label = active.title ?? `Planta ${index + 1}`;

  function go(delta: number) {
    setIndex((current) => (current + delta + floorPlans.length) % floorPlans.length);
  }

  return (
    <div>
      <div className="relative aspect-video w-full overflow-hidden rounded-2xl bg-brand-100">
        {active.tour_url ? (
          <iframe
            key={active.id}
            src={embedUrl(active.tour_url)}
            title={label}
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; xr-spatial-tracking"
            allowFullScreen
            className="absolute inset-0 h-full w-full border-0"
          />
        ) : active.image_url ? (
          <Image
            src={active.image_url}
            alt={label}
            fill
            sizes="(min-width: 1024px) 66vw, 100vw"
            className="object-contain"
          />
        ) : (
          <div className="grid h-full w-full place-items-center text-brand-300">
            <IconCube className="h-10 w-10" />
          </div>
        )}

        {floorPlans.length > 1 && (
          <>
            <button
              type="button"
              onClick={() => go(-1)}
              aria-label="Planta anterior"
              className="absolute left-3 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-full bg-white/90 text-brand-700 shadow-md transition hover:bg-white"
            >
              <IconArrow className="h-4 w-4 rotate-180" />
            </button>
            <button
              type="button"
              onClick={() => go(1)}
              aria-label="Próxima planta"
              className="absolute right-3 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-full bg-white/90 text-brand-700 shadow-md transition hover:bg-white"
            >
              <IconArrow className="h-4 w-4" />
            </button>
          </>
        )}
      </div>

      <div className="mt-3 flex items-center justify-between gap-4">
        <p className="text-sm font-medium text-brand-800">{label}</p>
        {floorPlans.length > 1 && (
          <p className="shrink-0 text-xs text-brand-900/45">
            {index + 1} / {floorPlans.length}
          </p>
        )}
      </div>

      {floorPlans.length > 1 && (
        <div className="mt-4 flex gap-2 overflow-x-auto pb-1">
          {floorPlans.map((plan, planIndex) => (
            <button
              key={plan.id}
              type="button"
              onClick={() => setIndex(planIndex)}
              aria-label={plan.title ?? `Planta ${planIndex + 1}`}
              className={`relative h-14 w-20 shrink-0 overflow-hidden rounded-lg ring-2 transition ${
                planIndex === index ? "ring-accent-500" : "ring-transparent hover:ring-brand-200"
              }`}
            >
              {plan.image_url ? (
                <Image src={plan.image_url} alt="" fill sizes="80px" className="object-cover" />
              ) : (
                <span className="grid h-full w-full place-items-center bg-brand-100 text-brand-400">
                  <IconCube className="h-5 w-5" />
                </span>
              )}
            </button>
          ))}
        </div>
      )}
    </div>
  );
}
