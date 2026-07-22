import { useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { useLang } from '../context/LangContext'
import { content } from '../data/content'
import Reveal from '../components/Reveal'

export default function Menu() {
  const { lang } = useLang()
  const t = content[lang].menu
  const [active, setActive] = useState(t.tabs[0].key)
  const activeTab = t.tabs.find((tab) => tab.key === active) ?? t.tabs[0]

  return (
    <div className="pt-32">
      <div
        className="relative flex h-[45svh] items-center justify-center bg-cover bg-center"
        style={{ backgroundImage: "url('/img/banner8.jpg')" }}
      >
        <div className="absolute inset-0 bg-ink/60" />
        <div className="relative text-center">
          <p className="text-xs uppercase tracking-[0.3em] text-gold-soft">{t.kicker}</p>
          <h1 className="mt-2 font-[var(--font-display)] text-5xl">{t.title}</h1>
        </div>
      </div>

      <section className="mx-auto max-w-5xl px-6 py-16">
        <div className="flex flex-wrap justify-center gap-2 rounded-lg bg-white p-2">
          {t.tabs.map((tab) => (
            <button
              key={tab.key}
              onClick={() => setActive(tab.key)}
              className={`rounded-md px-4 py-2 text-sm font-medium uppercase tracking-wide transition-colors ${
                active === tab.key ? 'bg-ink text-gold' : 'text-ink/70 hover:bg-ink/5'
              }`}
            >
              {tab.label}
            </button>
          ))}
        </div>

        <AnimatePresence mode="wait">
          <motion.div
            key={active}
            initial={{ opacity: 0, y: 12 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -12 }}
            transition={{ duration: 0.35 }}
            className="mt-10 grid gap-6 sm:grid-cols-2"
          >
            {activeTab.images.map((src) => (
              <img key={src} src={src} alt={activeTab.label} className="w-full rounded-lg" />
            ))}
          </motion.div>
        </AnimatePresence>
      </section>

      <Reveal className="pb-16 text-center text-paper/60">—</Reveal>
    </div>
  )
}
