type IconProps = { className?: string };

const base = "h-5 w-5";

export function IconPin({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11Z" strokeLinejoin="round" />
      <circle cx="12" cy="10" r="2.6" />
    </svg>
  );
}

export function IconArea({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <rect x="3.5" y="3.5" width="17" height="17" rx="2" />
      <path d="M8 3.5v3M3.5 8h3M16 20.5v-3M20.5 16h-3" strokeLinecap="round" />
    </svg>
  );
}

export function IconBed({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path d="M3 18v-8M3 13h18v5M21 18v-3.5" strokeLinecap="round" />
      <path d="M6.5 13v-2a1.5 1.5 0 0 1 1.5-1.5h8A1.5 1.5 0 0 1 17.5 11v2" />
    </svg>
  );
}

export function IconShower({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path d="M4 12h16M5 12v3a5 5 0 0 0 5 5h4a5 5 0 0 0 5-5v-3" strokeLinecap="round" />
      <path d="M7 12V6a2.5 2.5 0 0 1 5 0" strokeLinecap="round" />
    </svg>
  );
}

export function IconCar({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path d="M4 16v2.5M20 16v2.5M3 16h18v-3.2a2 2 0 0 0-.5-1.3L18 8H6l-2.5 3.5A2 2 0 0 0 3 12.8V16Z" strokeLinejoin="round" />
      <circle cx="7.5" cy="16" r="1.2" />
      <circle cx="16.5" cy="16" r="1.2" />
    </svg>
  );
}

export function IconArrow({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" className={className} aria-hidden>
      <path d="M5 12h13M13 6.5 18.5 12 13 17.5" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

export function IconKey({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <circle cx="8" cy="16" r="3.5" />
      <path d="m10.6 13.4 8-8M16.5 7.5l2 2M14 10l2 2" strokeLinecap="round" />
    </svg>
  );
}

export function IconBank({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path d="M3.5 9.5 12 4.5l8.5 5M5 9.5v8M9.5 9.5v8M14.5 9.5v8M19 9.5v8M3 19.5h18" strokeLinecap="round" />
    </svg>
  );
}

export function IconShield({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path d="M12 3.5 5 6.2v5.3c0 4.3 2.9 7.5 7 9 4.1-1.5 7-4.7 7-9V6.2L12 3.5Z" strokeLinejoin="round" />
      <path d="m9 12 2.2 2.2L15.4 10" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

export function IconWhatsApp({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" className={className} aria-hidden>
      <path d="M12.04 2C6.6 2 2.2 6.4 2.2 11.84c0 1.94.53 3.75 1.45 5.31L2 22l4.98-1.6a9.8 9.8 0 0 0 5.06 1.4h.01c5.43 0 9.84-4.4 9.84-9.84C21.89 6.4 17.48 2 12.04 2Zm5.76 14.02c-.24.68-1.4 1.3-1.94 1.34-.5.05-.98.23-3.3-.69-2.78-1.1-4.54-3.94-4.68-4.13-.13-.19-1.11-1.48-1.11-2.82 0-1.34.7-2 .95-2.27a1 1 0 0 1 .72-.34h.52c.17 0 .39-.06.6.46.24.57.8 1.98.87 2.12.07.14.12.31.02.5-.09.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.53 1.9 1.05.93 1.93 1.22 2.21 1.36.28.14.44.12.6-.07.17-.19.7-.81.88-1.09.19-.28.37-.23.63-.14.26.09 1.66.78 1.94.93.28.14.47.21.54.32.07.12.07.66-.16 1.35Z" />
    </svg>
  );
}

export function IconInstagram({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <rect x="3.5" y="3.5" width="17" height="17" rx="4.5" />
      <circle cx="12" cy="12" r="3.6" />
      <circle cx="16.9" cy="7.1" r="1" fill="currentColor" stroke="none" />
    </svg>
  );
}

export function IconFacebook({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" className={className} aria-hidden>
      <path d="M13.5 21v-7.5h2.5l.5-3h-3V8.7c0-.87.24-1.46 1.49-1.46H16.7V4.56A20 20 0 0 0 14.4 4.4c-2.3 0-3.9 1.4-3.9 4v2.1H8v3h2.5V21h3Z" />
    </svg>
  );
}

export function IconYoutube({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" className={className} aria-hidden>
      <path d="M21.5 8.2a2.6 2.6 0 0 0-1.8-1.85C18.1 6 12 6 12 6s-6.1 0-7.7.35A2.6 2.6 0 0 0 2.5 8.2 27 27 0 0 0 2.15 12c0 1.3.12 2.6.35 3.8a2.6 2.6 0 0 0 1.8 1.85C5.9 18 12 18 12 18s6.1 0 7.7-.35a2.6 2.6 0 0 0 1.8-1.85c.23-1.2.35-2.5.35-3.8s-.12-2.6-.35-3.8ZM10.25 14.6V9.4L14.75 12l-4.5 2.6Z" />
    </svg>
  );
}

export function IconMail({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <rect x="3" y="5" width="18" height="14" rx="2.5" />
      <path d="m4 7 8 5.5L20 7" strokeLinecap="round" strokeLinejoin="round" />
    </svg>
  );
}

export function IconPhone({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.6" className={className} aria-hidden>
      <path
        d="M6.2 3.5h2.3l1.5 3.7-1.9 1.4a11.5 11.5 0 0 0 5.3 5.3l1.4-1.9 3.7 1.5v2.3a2 2 0 0 1-2.2 2A15.8 15.8 0 0 1 4.2 5.7a2 2 0 0 1 2-2.2Z"
        strokeLinejoin="round"
      />
    </svg>
  );
}

export function IconMenu({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" className={className} aria-hidden>
      <path d="M4 7h16M4 12h16M4 17h16" strokeLinecap="round" />
    </svg>
  );
}

export function IconClose({ className = base }: IconProps) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" className={className} aria-hidden>
      <path d="m6 6 12 12M18 6 6 18" strokeLinecap="round" />
    </svg>
  );
}
