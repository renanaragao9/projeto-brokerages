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

export type Program = {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  is_active: boolean;
  properties_count: number | null;
  created_at: string;
  updated_at: string;
};

export function getPrograms(): Promise<Program[]> {
  return request<Program[]>("/programs", { method: "GET" });
}

export function getProgram(id: string | number): Promise<Program> {
  return request<Program>(`/programs/${id}`, { method: "GET" });
}
