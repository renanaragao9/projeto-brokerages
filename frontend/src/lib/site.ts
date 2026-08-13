/**
 * Configuração central da marca e dos textos institucionais da landing page.
 * Ajuste aqui (ou via variáveis de ambiente NEXT_PUBLIC_*) — nenhum componente
 * possui dado de contato fixo no código.
 */
export const site = {
  name: process.env.NEXT_PUBLIC_CONSTRUCTION_NAME ?? "Canopus Construções",
  shortName: "Canopus",
  tagline: "Value, simplified. Morar bem, sem complicação.",

  /** Somente dígitos, com DDI + DDD — usado nos links do WhatsApp. */
  whatsapp: process.env.NEXT_PUBLIC_WHATSAPP ?? "5585999999999",
  phoneLabel: process.env.NEXT_PUBLIC_PHONE_LABEL ?? "(85) 99999-9999",
  email: process.env.NEXT_PUBLIC_EMAIL ?? "contato@canopusconstrucoes.com.br",
  addressLine: "Av. Washington Soares, 1000 — Fortaleza, CE",

  /** TODO: confirmar com o cliente antes de publicar. */
  foundedYear: 1998,
  creci: "CRECI-CE 0000-J",

  social: {
    instagram: "https://instagram.com/",
    facebook: "https://facebook.com/",
    youtube: "https://youtube.com/",
  },

  nav: [
    { label: "Empreendimentos", href: "#empreendimentos" },
    { label: "Vantagens", href: "#vantagens" },
    { label: "A Construtora", href: "#sobre" },
    { label: "Contato", href: "#contato" },
  ],
} as const;

export function whatsappLink(message: string): string {
  return `https://wa.me/${site.whatsapp}?text=${encodeURIComponent(message)}`;
}
