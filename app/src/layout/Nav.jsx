import { useEffect, useState } from 'react'
import { Link, NavLink } from 'react-router-dom'
import { motion } from 'framer-motion'
import { useLang } from '../context/LangContext'
import { content } from '../data/content'

export default function Nav() {
  const { lang, toggleLang } = useLang()
  const t = content[lang].nav
  const [scrolled, setScrolled] = useState(false)

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40)
    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  const linkClass = ({ isActive }) =>
    `text-sm tracking-[0.12em] uppercase transition-colors hover:text-gold ${isActive ? 'text-gold' : 'text-paper/85'}`

  return (
    <motion.nav
      initial={{ y: -30, opacity: 0 }}
      animate={{ y: 0, opacity: 1 }}
      transition={{ duration: 0.6 }}
      className={`fixed top-0 inset-x-0 z-50 transition-all duration-500 ${
        scrolled ? 'bg-ink/85 backdrop-blur-md py-3 shadow-lg shadow-black/30' : 'bg-transparent py-6'
      }`}
    >
      <div className="mx-auto max-w-7xl px-6 flex items-center justify-between">
        <Link to="/" className="flex items-center gap-2">
          <img src="/img/logo2.png" alt="Tei Sushi" className="h-10 w-auto" />
        </Link>

        <div className="hidden md:flex items-center gap-8">
          <NavLink to="/" end className={linkClass}>
            {t.home}
          </NavLink>
          <NavLink to="/menu" className={linkClass}>
            {t.menu}
          </NavLink>
          <NavLink to="/catering" className={linkClass}>
            {t.catering}
          </NavLink>
          <a href="/#galeria" className="text-sm tracking-[0.12em] uppercase text-paper/85 hover:text-gold transition-colors">
            {t.gallery}
          </a>
          <a href="/#contacto" className="text-sm tracking-[0.12em] uppercase text-paper/85 hover:text-gold transition-colors">
            {t.contact}
          </a>
        </div>

        <button
          onClick={toggleLang}
          className="rounded-full border border-gold/60 px-3 py-1 text-xs tracking-widest text-gold hover:bg-gold hover:text-ink transition-colors"
        >
          {lang === 'es' ? 'EN' : 'ES'}
        </button>
      </div>
    </motion.nav>
  )
}
