import type { Metadata } from "next";
import { Poppins } from "next/font/google";
import "./globals.css";
import { site } from "@/lib/site";

const poppins = Poppins({
  variable: "--font-poppins",
  subsets: ["latin"],
  weight: ["300", "400", "500", "600", "700"],
  display: "swap",
});

export const metadata: Metadata = {
  title: {
    default: `${site.name} | Apartamentos e condomínios`,
    template: `%s | ${site.name}`,
  },
  description:
    "Condomínios residenciais com lazer completo, localização estratégica e as melhores condições de financiamento. Encontre seu apartamento e fale com um corretor.",
  openGraph: {
    type: "website",
    locale: "pt_BR",
    siteName: site.name,
    title: `${site.name} | Apartamentos e condomínios`,
    description:
      "Condomínios residenciais com lazer completo e as melhores condições de financiamento.",
  },
};

export default function RootLayout({ children }: LayoutProps<"/">) {
  return (
    <html lang="pt-BR" className={`${poppins.variable} h-full antialiased`}>
      <body className="flex min-h-full flex-col bg-white text-brand-900">{children}</body>
    </html>
  );
}
