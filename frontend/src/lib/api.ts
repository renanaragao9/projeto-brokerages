const API_URL = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000/api/v1";

export type ApiSuccess<T> = {
  status: "success";
  message: string;
  data: T;
};

export type ApiError = {
  status: "error";
  message: string;
  errors: Record<string, string>;
};

export class ApiRequestError extends Error {
  errors: Record<string, string>;
  statusCode: number;

  constructor(message: string, errors: Record<string, string>, statusCode: number) {
    super(message);
    this.errors = errors;
    this.statusCode = statusCode;
  }
}

async function request<T>(path: string, options: RequestInit = {}): Promise<T> {
  const response = await fetch(`${API_URL}${path}`, {
    ...options,
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      ...(options.headers as Record<string, string> | undefined),
    },
    cache: "no-store",
  });

  const body = await response.json().catch(() => null);

  if (!response.ok) {
    const errBody = body as ApiError | null;
    throw new ApiRequestError(
      errBody?.message ?? "Erro ao comunicar com a API.",
      errBody?.errors ?? {},
      response.status
    );
  }

  return (body as ApiSuccess<T>).data;
}

export type PropertyImage = {
  id: number;
  url: string | null;
  alt: string | null;
  title: string | null;
  sort_order: number;
  is_cover: boolean;
};

export type PropertyFeature = {
  id: number;
  name: string;
  slug: string;
  icon: string | null;
  value: string | null;
};

export type Property = {
  id: number;
  name: string;
  slug: string;
  type: string;
  status: string;
  description: string | null;
  price: string | null;
  condominium_fee: string | null;
  iptu: string | null;
  area: string | null;
  total_area: string | null;
  bedrooms: number | null;
  suites: number | null;
  bathrooms: number | null;
  parking_spaces: number | null;
  address: string | null;
  address_number: string | null;
  address_complement: string | null;
  neighborhood: string | null;
  city: string | null;
  state: string | null;
  zip_code: string | null;
  latitude: string | null;
  longitude: string | null;
  is_featured: boolean;
  construction: { id: number; name: string } | null;
  images: PropertyImage[];
  features: PropertyFeature[];
  created_at: string;
  updated_at: string;
};

export function getProperties(): Promise<Property[]> {
  return request<Property[]>("/properties", { method: "GET" });
}

export function getProperty(id: string | number): Promise<Property> {
  return request<Property>(`/properties/${id}`, { method: "GET" });
}
