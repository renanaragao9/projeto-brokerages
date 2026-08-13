import type { Property, PropertyImage } from "./api";

export const TYPE_LABELS: Record<string, string> = {
  apartment: "Apartamento",
  house: "Casa",
  condominium: "Condomínio",
  commercial: "Comercial",
  land: "Terreno",
  development: "Empreendimento",
};

export const STATUS_LABELS: Record<string, string> = {
  available: "Disponível",
  launch: "Lançamento",
  under_construction: "Em obras",
  finished: "Pronto para morar",
  sold_out: "Vendido",
  reserved: "Reservado",
};

export function typeLabel(property: Property): string {
  return TYPE_LABELS[property.type] ?? property.type;
}

export function statusLabel(property: Property): string {
  return STATUS_LABELS[property.status] ?? property.status;
}

export function formatBRL(value: string | null): string | null {
  if (value === null) {
    return null;
  }

  return Number(value).toLocaleString("pt-BR", {
    style: "currency",
    currency: "BRL",
    maximumFractionDigits: 0,
  });
}

export function formatArea(value: string | null): string | null {
  if (value === null) {
    return null;
  }

  return `${Number(value).toLocaleString("pt-BR", { maximumFractionDigits: 2 })} m²`;
}

export function coverImage(property: Property): PropertyImage | undefined {
  return property.images.find((image) => image.is_cover) ?? property.images[0];
}

export function shortLocation(property: Property): string {
  return [property.neighborhood, property.city, property.state].filter(Boolean).join(", ");
}

export function fullAddress(property: Property): string {
  const street = [property.address, property.address_number].filter(Boolean).join(", ");

  return [street, property.neighborhood, property.city, property.state].filter(Boolean).join(" — ");
}

export type PropertySpec = { label: string; value: string };

/** Ficha resumida do card: só entra o que existe no cadastro. */
export function propertySpecs(property: Property): PropertySpec[] {
  const specs: PropertySpec[] = [];
  const area = formatArea(property.area);

  if (area) {
    specs.push({ label: "Área privativa", value: area });
  }

  if (property.bedrooms !== null) {
    specs.push({ label: "Quartos", value: String(property.bedrooms) });
  }

  if (property.suites !== null && property.suites > 0) {
    specs.push({ label: "Suítes", value: String(property.suites) });
  }

  if (property.parking_spaces !== null) {
    specs.push({ label: "Vagas", value: String(property.parking_spaces) });
  }

  return specs;
}
