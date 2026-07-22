import { useState } from 'react'
import { site } from '../data/content'

const items = [
  { href: site.whatsapp, label: 'WhatsApp', sub: '+52 (624) 123 7003', bg: 'bg-[#25d366]', icon: WhatsAppIcon },
  { href: site.instagram, label: 'Instagram', sub: '@teisushicabo', bg: 'bg-gradient-to-br from-[#405de6] via-[#c13584] to-[#fd1d1d]', icon: InstagramIcon },
  { href: site.facebook, label: 'Facebook', sub: 'Tei Sushi', bg: 'bg-[#3b5998]', icon: FacebookIcon },
]

export default function SocialFloat() {
  const [activeIndex, setActiveIndex] = useState(null)

  return (
    <div className="fixed right-0 top-1/3 z-40 flex flex-col items-end gap-2" onMouseLeave={() => setActiveIndex(null)}>
      {items.map(({ href, label, sub, bg, icon: Icon }, i) => {
        const open = activeIndex === i
        return (
          <a
            key={label}
            href={href}
            target="_blank"
            rel="noreferrer"
            onMouseEnter={() => setActiveIndex(i)}
            onFocus={() => setActiveIndex(i)}
            className={`flex items-center gap-2 rounded-l-md ${bg} text-white pl-2 pr-0 py-2 overflow-hidden shadow-lg transition-[width] duration-200 ease-out ${open ? 'w-44' : 'w-12'}`}
          >
            <Icon className="h-6 w-6 shrink-0" />
            <span
              className={`whitespace-nowrap text-xs font-semibold leading-tight transition-opacity duration-150 ${open ? 'opacity-100 delay-100' : 'opacity-0'}`}
            >
              {label}
              <br />
              <small className="font-normal opacity-80">{sub}</small>
            </span>
          </a>
        )
      })}
    </div>
  )
}

function WhatsAppIcon(props) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" {...props}>
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.39 1.26 4.81L2 22l5.4-1.36a9.9 9.9 0 0 0 4.64 1.16h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.13-2.9-7A9.83 9.83 0 0 0 12.04 2Zm5.8 14.16c-.24.68-1.4 1.3-1.93 1.36-.5.06-1.13.09-1.82-.11-.42-.13-.96-.31-1.65-.6-2.9-1.25-4.8-4.17-4.94-4.36-.14-.19-1.18-1.57-1.18-3 0-1.42.75-2.12 1.02-2.41.26-.29.58-.36.77-.36h.55c.18 0 .42-.03.65.5.24.55.8 1.9.87 2.04.07.14.12.3.02.49-.09.19-.14.3-.28.46-.14.16-.29.36-.42.48-.14.14-.28.29-.12.57.16.28.7 1.15 1.5 1.86 1.03.92 1.9 1.2 2.18 1.34.28.14.44.12.6-.07.16-.19.68-.79.86-1.06.18-.28.36-.23.6-.14.24.09 1.53.72 1.79.85.26.14.44.2.5.31.07.12.07.66-.17 1.35Z" />
    </svg>
  )
}

function InstagramIcon(props) {
  return (
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" {...props}>
      <rect x="3" y="3" width="18" height="18" rx="5" />
      <circle cx="12" cy="12" r="4" />
      <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none" />
    </svg>
  )
}

function FacebookIcon(props) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" {...props}>
      <path d="M13.5 21v-7.5H16l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46H16.5V4.3C16.23 4.27 15.32 4.2 14.27 4.2c-2.2 0-3.7 1.34-3.7 3.8v2.5H8v3h2.57V21h2.93Z" />
    </svg>
  )
}
