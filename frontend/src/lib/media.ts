export type MediaKind =
  | { type: "youtube"; embedUrl: string }
  | { type: "vimeo"; embedUrl: string }
  | { type: "video"; url: string }
  | { type: "image"; url: string };

/** Identifica o tipo de mídia de uma URL (YouTube, Vimeo, vídeo direto ou imagem). */
export function resolveMediaKind(url: string): MediaKind {
  const youtube = url.match(
    /(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([\w-]{11})/
  );
  if (youtube) {
    return { type: "youtube", embedUrl: `https://www.youtube.com/embed/${youtube[1]}` };
  }

  const vimeo = url.match(/vimeo\.com\/(?:video\/)?(\d+)/);
  if (vimeo) {
    return { type: "vimeo", embedUrl: `https://player.vimeo.com/video/${vimeo[1]}` };
  }

  if (/\.(mp4|webm|ogg)(\?.*)?$/i.test(url)) {
    return { type: "video", url };
  }

  return { type: "image", url };
}
