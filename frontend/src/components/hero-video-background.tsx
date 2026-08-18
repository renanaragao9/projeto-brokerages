"use client";

import { useEffect, useRef, useState } from "react";

/**
 * Fundo de vídeo do hero com transição em crossfade entre múltiplos clipes.
 * Cada vídeo toca até o fim e cede lugar ao próximo com fade suave;
 * o clipe seguinte é pré-carregado enquanto o atual ainda toca, pra
 * transição não travar. Cai para um poster estático se o usuário
 * preferir menos movimento.
 */
export function HeroVideoBackground({
  videos,
  poster,
}: {
  videos: string[];
  poster?: string;
}) {
  const [activeIndex, setActiveIndex] = useState(0);
  const [reducedMotion, setReducedMotion] = useState(false);
  const videoRefs = useRef<Array<HTMLVideoElement | null>>([]);

  useEffect(() => {
    const query = window.matchMedia("(prefers-reduced-motion: reduce)");
    setReducedMotion(query.matches);

    const onChange = (event: MediaQueryListEvent) => setReducedMotion(event.matches);
    query.addEventListener("change", onChange);
    return () => query.removeEventListener("change", onChange);
  }, []);

  useEffect(() => {
    if (reducedMotion || videos.length === 0) return;

    videoRefs.current.forEach((video, index) => {
      if (!video) return;

      if (index === activeIndex) {
        video.currentTime = 0;
        video.play().catch(() => {});
      } else {
        video.pause();
      }
    });
  }, [activeIndex, reducedMotion, videos.length]);

  if (videos.length === 0) return null;

  const nextIndex = (activeIndex + 1) % videos.length;

  if (reducedMotion) {
    return (
      <div
        className="absolute inset-0 bg-cover bg-center"
        style={poster ? { backgroundImage: `url(${poster})` } : undefined}
      />
    );
  }

  return (
    <div className="absolute inset-0 overflow-hidden">
      {videos.map((src, index) => (
        <video
          key={src}
          ref={(el) => {
            videoRefs.current[index] = el;
          }}
          src={src}
          poster={index === 0 ? poster : undefined}
          muted
          playsInline
          autoPlay={index === 0}
          preload={index === activeIndex || index === nextIndex ? "auto" : "none"}
          disablePictureInPicture
          disableRemotePlayback
          onEnded={() => setActiveIndex((current) => (current + 1) % videos.length)}
          className={`absolute inset-0 h-full w-full object-cover transition-opacity duration-1000 ease-in-out ${
            index === activeIndex ? "opacity-100" : "opacity-0"
          }`}
        />
      ))}
    </div>
  );
}
