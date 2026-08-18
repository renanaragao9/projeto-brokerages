import { SiteFooter } from "@/components/site-footer";
import { SiteHeader } from "@/components/site-header";
import { mateusSite } from "@/lib/site-mateus";

export default function MateusLayout({ children }: { children: React.ReactNode }) {
  return (
    <div data-site="mateus" className="flex min-h-full flex-1 flex-col">
      <SiteHeader config={mateusSite} />
      <main className="flex-1">{children}</main>
      <SiteFooter config={mateusSite} />
    </div>
  );
}