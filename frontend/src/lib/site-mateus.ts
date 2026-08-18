import type { SiteConfig } from "@/lib/site";

/**
 * Configuração da landing page do Mateus Imóveis (fork da Canopus).
 * TODO: confirmar com o cliente os dados de contato, logo, redes e ano de fundação.
 */
export const mateusSite: SiteConfig = {
  name: "Mateus Imóveis",
  shortName: "Mateus",
  subtitle: "Imobiliária",
  tagline: "Seu imóvel, do jeito que você merece.",

  /** TODO: número real do corretor responsável. */
  whatsapp: "5585990000000",
  phoneLabel: "(85) 99000-0000",
  email: "contato@mateusimoveis.com.br",
  addressLine: "Fortaleza - CE",

  /** TODO: confirmar ano de fundação. */
  foundedYear: 2010,
  creci: "CRECI-CE 0000-J",
  dealType: "rental",

  logo: "/logo/mateus/mateus-logo.png",
  rootPath: "/mateus",

  social: {
    instagram: "https://instagram.com/mateusimoveis",
    facebook: "https://facebook.com/mateusimoveis",
    youtube: "https://youtube.com/@mateusimoveis",
  },

  nav: [
    { label: "Imóveis", href: "/mateus#imoveis" },
    { label: "Vantagens", href: "/mateus#vantagens" },
    { label: "A Imobiliária", href: "/mateus#sobre" },
    { label: "Contato", href: "/mateus#contato" },
    { label: "Notícias", href: "/mateus/noticias" },
  ],
};