type PropertyMapProps = {
  address: string | null;
  addressNumber: string | null;
  neighborhood: string | null;
  city: string | null;
  state: string | null;
  latitude: string | null;
  longitude: string | null;
  className?: string;
};

export function PropertyMap({
  address,
  addressNumber,
  neighborhood,
  city,
  state,
  latitude,
  longitude,
  className = "",
}: PropertyMapProps) {
  const street = [address, addressNumber].filter(Boolean).join(", ");
  const query =
    latitude && longitude
      ? `${latitude},${longitude}`
      : [street, neighborhood, city, state].filter(Boolean).join(", ");

  if (!query) return null;

  const src = `https://www.google.com/maps?q=${encodeURIComponent(query)}&output=embed`;

  return (
    <div className={`relative aspect-video w-full overflow-hidden rounded-2xl sm:aspect-21/9 ${className}`}>
      <iframe
        src={src}
        title="Localização do imóvel no mapa"
        loading="lazy"
        referrerPolicy="no-referrer-when-downgrade"
        className="absolute inset-0 h-full w-full border-0"
      />
    </div>
  );
}
