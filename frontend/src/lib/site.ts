/**
 * Configuração central da marca e dos textos institucionais da landing page.
 * Ajuste aqui (ou via variáveis de ambiente NEXT_PUBLIC_*) — nenhum componente
 * possui dado de contato fixo no código.
 */
export const site = {
  name: process.env.NEXT_PUBLIC_CONSTRUCTION_NAME ?? "Canopus Construções",
  shortName: "Canopus",
  tagline: "Value, simplified. Morar bem, sem complicação.",

  /** Contato exibido no site: Allison Marques, corretor responsável pela Canopus. */
  /** Somente dígitos, com DDI + DDD — usado nos links do WhatsApp. */
  whatsapp: process.env.NEXT_PUBLIC_WHATSAPP ?? "5585990073696",
  phoneLabel: process.env.NEXT_PUBLIC_PHONE_LABEL ?? "(85) 99007-3696",
  email: process.env.NEXT_PUBLIC_EMAIL ?? "alsmarques92@gmail.com",
  addressLine: "Av. Washington Soares, 1951 — Edson Queiroz, Fortaleza - CE, 60000-000",

  /** TODO: confirmar com o cliente antes de publicar. */
  foundedYear: 1976,
  creci: "CRECI-CE 0000-J",

  social: {
    instagram: "https://instagram.com/canopusconstrucoes",
    facebook: "https://www.facebook.com/grupocanopus/?locale=pt_BR",
    youtube: "https://www.youtube.com/@canopus.construcoes",
  },

  nav: [
    { label: "Empreendimentos", href: "/canopus#empreendimentos" },
    { label: "Vantagens", href: "/canopus#vantagens" },
    { label: "A Construtora", href: "/canopus#sobre" },
    { label: "Contato", href: "/canopus#contato" },
    { label: "Notícias", href: "/canopus/noticias" },
  ],
} as const;

export function whatsappLink(message: string): string {
  return `https://wa.me/${site.whatsapp}?text=${encodeURIComponent(message)}`;
}
