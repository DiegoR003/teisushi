import { useLang } from '../context/LangContext'
import { content, site } from '../data/content'

export default function Footer() {
  const { lang } = useLang()
  const t = content[lang].footer

  return (
    <footer className="border-t border-white/10 bg-ink py-8 text-center text-sm text-paper/60">
      <p>
        {t.rights}{' '}
        <a href="https://bananagroup.mx" target="_blank" rel="noreferrer" className="text-gold hover:underline">
          Banana Group Marketing
        </a>
      </p>
      <p className="mt-2">
        <a href={site.phoneHref} className="hover:text-gold transition-colors">
          {site.phone}
        </a>
      </p>
    </footer>
  )
}
