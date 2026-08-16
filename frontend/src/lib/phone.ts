/** Formata um telefone BR enquanto o usuário digita: (00) 00000-0000 ou (00) 0000-0000. */
export function formatPhoneBR(value: string): string {
  const digits = value.replace(/\D/g, "").slice(0, 11);

  if (digits.length === 0) return "";
  if (digits.length <= 2) return `(${digits}`;

  const ddd = digits.slice(0, 2);
  const rest = digits.slice(2);

  if (rest.length <= 4) return `(${ddd}) ${rest}`;
  if (digits.length <= 10) return `(${ddd}) ${rest.slice(0, 4)}-${rest.slice(4)}`;

  return `(${ddd}) ${rest.slice(0, 5)}-${rest.slice(5)}`;
}
