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
  const isFormData = options.body instanceof FormData;

  const response = await fetch(`${API_URL}${path}`, {
    ...options,
    headers: {
      Accept: "application/json",
      ...(isFormData ? {} : { "Content-Type": "application/json" }),
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

export type PropertyBank = {
  id: number;
  name: string;
  logo_url: string | null;
  link_simulation: string | null;
  description: string | null;
  instructions: string | null;
};

export type PropertyNotice = {
  id: number;
  title: string;
  slug: string;
  excerpt: string | null;
  image_url: string | null;
  published_at: string | null;
};

export type PropertyFloorPlan = {
  id: number;
  title: string | null;
  image_url: string | null;
  tour_url: string | null;
  sort_order: number;
};

export type Property = {
  id: number;
  name: string;
  slug: string;
  type: string;
  status: string;
  construction_phase: string | null;
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
  construction?: { id: number; name: string } | null;
  images: PropertyImage[];
  features?: PropertyFeature[];
  banks?: PropertyBank[];
  floor_plans?: PropertyFloorPlan[];
  notices?: PropertyNotice[];
  created_at: string;
  updated_at: string;
};

export function getProperties(construction?: string): Promise<Property[]> {
  const query = construction ? `?construction=${encodeURIComponent(construction)}` : "";
  return request<Property[]>(`/properties${query}`, { method: "GET" });
}

export function getProperty(id: string | number): Promise<Property> {
  return request<Property>(`/properties/${id}`, { method: "GET" });
}

export type ConstructionUpdate = {
  id: number;
  image_url: string;
  author_name: string;
  message: string | null;
  created_at: string;
};

export function getConstructionUpdates(propertyId: string | number): Promise<ConstructionUpdate[]> {
  return request<ConstructionUpdate[]>(
    `/construction-updates?property_id=${encodeURIComponent(String(propertyId))}`,
    { method: "GET" }
  );
}

export type NewConstructionUpdate = {
  property_id: string | number;
  author_name: string;
  author_email?: string;
  author_phone?: string;
  message?: string;
  image: File;
};

export function submitConstructionUpdate(update: NewConstructionUpdate): Promise<null> {
  const formData = new FormData();
  formData.append("property_id", String(update.property_id));
  formData.append("author_name", update.author_name);
  if (update.author_email) formData.append("author_email", update.author_email);
  if (update.author_phone) formData.append("author_phone", update.author_phone);
  if (update.message) formData.append("message", update.message);
  formData.append("image", update.image);

  return request<null>("/construction-updates", { method: "POST", body: formData });
}

export type NoticeableType = "construction" | "broker" | "property" | "bank";

export type Notice = {
  id: number;
  title: string;
  slug: string;
  excerpt: string | null;
  content?: string;
  image_url: string | null;
  media_url: string | null;
  published_at: string | null;
  noticeable: { type: NoticeableType | null; id: number; name: string } | null;
};

export function getNotices(filter?: {
  noticeableType?: NoticeableType;
  noticeableId?: string | number;
}): Promise<Notice[]> {
  const params = new URLSearchParams();
  if (filter?.noticeableType) params.set("noticeable_type", filter.noticeableType);
  if (filter?.noticeableId) params.set("noticeable_id", String(filter.noticeableId));

  const query = params.toString();
  return request<Notice[]>(`/notices${query ? `?${query}` : ""}`, { method: "GET" });
}

export function getNotice(slug: string): Promise<Notice> {
  return request<Notice>(`/notices/${encodeURIComponent(slug)}`, { method: "GET" });
}
