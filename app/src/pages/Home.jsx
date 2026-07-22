import { useRef } from 'react'
import { motion } from 'framer-motion'
import { useLang } from '../context/LangContext'
import { content, site } from '../data/content'
import HeroScene from '../scenes/HeroScene'
import Reveal from '../components/Reveal'
import ContactForm from '../components/ContactForm'

export default function Home() {
  const { lang } = useLang()
  const t = content[lang]
  const heroRef = useRef(null)

  return (
    <div>
      {/* HERO — 3D scene + scroll-driven motion */}
      <section ref={heroRef} className="relative h-[160svh]">
        <div className="sticky top-0 h-svh overflow-hidden">
          <HeroScene scrollTarget={heroRef} />
          <div className="pointer-events-none absolute inset-0 bg-gradient-to-b from-ink/40 via-ink/10 to-ink" />
          <div className="relative z-10 flex h-full flex-col items-center px-6 pt-[14svh] text-center">
            <motion.p
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.3, duration: 0.8 }}
              className="mb-3 text-xs uppercase tracking-[0.35em] text-gold-soft"
            >
              {t.hero.kicker}
            </motion.p>
            <motion.h1
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.5, duration: 0.9 }}
              className="font-[var(--font-display)] text-6xl sm:text-7xl md:text-8xl"
            >
              {t.hero.title}
            </motion.h1>
            <motion.a
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.8, duration: 0.8 }}
              href={site.openTable}
              target="_blank"
              rel="noreferrer"
              className="mt-8 rounded-full border border-gold px-8 py-3 text-sm uppercase tracking-widest text-gold transition-colors hover:bg-gold hover:text-ink"
            >
              {t.hero.cta}
            </motion.a>
          </div>
          <motion.div
            animate={{ y: [0, 10, 0] }}
            transition={{ repeat: Infinity, duration: 1.8 }}
            className="pointer-events-none absolute bottom-8 left-1/2 z-10 -translate-x-1/2 text-gold/70"
          >
            ↓
          </motion.div>
        </div>
      </section>

      {/* ABOUT */}
      <section className="section-padding px-6 py-24">
        <div className="mx-auto grid max-w-6xl gap-12 md:grid-cols-2 md:items-center">
          <Reveal as="left">
            <p className="text-xs uppercase tracking-[0.3em] text-gold">{t.about.subtitle}</p>
            <h2 className="mt-2 font-[var(--font-display)] text-4xl">{t.about.title}</h2>
            <p className="mt-6 leading-relaxed text-paper/75">{t.about.p1}</p>
            <p className="mt-4 leading-relaxed text-paper/75">{t.about.p2}</p>
            <a href={site.phoneHref} className="mt-6 inline-block text-gold hover:underline">
              {t.about.reservar} · {site.phone}
            </a>
          </Reveal>
          <Reveal as="right" delay={0.15} className="grid grid-cols-2 gap-4">
            <img src="/img/01.jpg" alt="" className="mt-10 rounded-lg object-cover" />
            <img src="/img/02.jpg" alt="" className="rounded-lg object-cover" />
          </Reveal>
        </div>
      </section>

      {/* CHEF */}
      <section className="bg-ink-soft px-6 py-24">
        <div className="mx-auto grid max-w-6xl gap-12 md:grid-cols-2 md:items-center">
          <Reveal as="left">
            <img src="/img/chef/chef.jpg" alt="" className="rounded-lg" />
          </Reveal>
          <Reveal as="right" delay={0.15}>
            <p className="text-xs uppercase tracking-[0.3em] text-gold">{t.chef.subtitle}</p>
            <h2 className="mt-2 font-[var(--font-display)] text-4xl">{t.chef.title}</h2>
            <p className="mt-6 leading-relaxed text-paper/75">{t.chef.p}</p>
            <a
              href={site.openTable}
              target="_blank"
              rel="noreferrer"
              className="mt-6 inline-block rounded-full border border-gold px-6 py-2.5 text-sm uppercase tracking-widest text-gold hover:bg-gold hover:text-ink transition-colors"
            >
              {t.chef.cta}
            </a>
          </Reveal>
        </div>
      </section>

      {/* GROUP */}
      <section className="px-6 py-24">
        <Reveal className="mx-auto max-w-3xl text-center">
          <p className="text-xs uppercase tracking-[0.3em] text-gold">{t.group.subtitle}</p>
          <h2 className="mt-2 font-[var(--font-display)] text-4xl">{t.group.title}</h2>
        </Reveal>
        <div className="mx-auto mt-12 grid max-w-6xl gap-8 sm:grid-cols-3">
          {t.group.brands.map((b, i) => (
            <Reveal as="scale" delay={i * 0.1} key={b.name}>
              <div className="group relative overflow-hidden rounded-lg">
                <img src={b.img} alt={b.name} className="h-64 w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                <div className="absolute inset-0 flex flex-col items-center justify-end gap-2 bg-gradient-to-t from-black/70 to-transparent p-6">
                  <img src={b.logo} alt="" className="h-10 object-contain" />
                  <h5 className="text-lg">{b.name}</h5>
                </div>
              </div>
            </Reveal>
          ))}
        </div>
      </section>

      {/* TESTIMONIALS + HOURS */}
      <section className="relative overflow-hidden bg-[url('/img/banner6.jpg')] bg-cover bg-center px-6 py-24">
        <div className="absolute inset-0 bg-ink/80" />
        <div className="relative mx-auto grid max-w-6xl gap-12 md:grid-cols-2">
          <Reveal as="left" className="space-y-8">
            {t.testimonials.map((ts) => (
              <div key={ts.name}>
                <p className="text-gold">★★★★★</p>
                <p className="mt-2 text-paper/80">{ts.text}</p>
                <p className="mt-2 font-semibold">{ts.name}</p>
              </div>
            ))}
          </Reveal>
          <Reveal as="right" delay={0.15} className="rounded-lg bg-white/5 p-8 backdrop-blur-sm">
            <h4 className="font-[var(--font-display)] text-2xl">{t.hours.title}</h4>
            <div className="mt-4 flex items-center justify-between border-t border-white/10 pt-4 text-sm uppercase tracking-wide">
              <span>{t.hours.from}</span>
              <span className="text-gold">{t.hours.time}</span>
              <span>{t.hours.to}</span>
            </div>
            <a
              href={site.openTable}
              target="_blank"
              rel="noreferrer"
              className="mt-6 inline-block rounded-full bg-gold px-6 py-2.5 text-sm uppercase tracking-widest text-ink"
            >
              {t.hours.reservar}
            </a>
            <p className="mt-4 text-sm text-paper/70">
              {t.hours.callAlso} <a href={site.phoneHref} className="text-gold">{site.phone}</a>
            </p>
            <a href={site.mapsShort} target="_blank" rel="noreferrer" className="mt-2 block text-sm text-paper/70 hover:text-gold">
              📍 {t.hours.address}
            </a>
          </Reveal>
        </div>
      </section>

      {/* SERVICES */}
      <section className="px-6 py-24">
        <div className="mx-auto grid max-w-6xl gap-8 sm:grid-cols-3">
          {t.services.map((s, i) => (
            <Reveal as="up" delay={i * 0.1} key={s.title} className="text-center">
              <h5 className="font-[var(--font-display)] text-2xl text-gold">{s.title}</h5>
              <p className="mt-3 text-paper/70">{s.text}</p>
            </Reveal>
          ))}
        </div>
      </section>

      {/* GALLERY */}
      <section id="galeria" className="px-6 py-24">
        <Reveal className="mx-auto max-w-3xl text-center">
          <p className="text-xs uppercase tracking-[0.3em] text-gold">{t.galleryTitle.subtitle}</p>
          <h2 className="mt-2 font-[var(--font-display)] text-4xl">{t.galleryTitle.title}</h2>
        </Reveal>
        <div className="mx-auto mt-12 grid max-w-6xl grid-cols-2 gap-4 sm:grid-cols-4">
          {site.gallery.map((src, i) => (
            <Reveal as="scale" delay={(i % 4) * 0.08} key={src}>
              <img src={src} alt="" className="aspect-square w-full rounded-lg object-cover" />
            </Reveal>
          ))}
        </div>
      </section>

      {/* NEWS */}
      <section className="bg-ink-soft px-6 py-24">
        <Reveal className="mx-auto max-w-3xl text-center">
          <p className="text-xs uppercase tracking-[0.3em] text-gold">{t.news.subtitle}</p>
          <h2 className="mt-2 font-[var(--font-display)] text-4xl">{t.news.title}</h2>
        </Reveal>
        <div className="mx-auto mt-12 grid max-w-6xl gap-8 sm:grid-cols-3">
          {t.news.items.map((n, i) => (
            <Reveal as="up" delay={i * 0.1} key={n.tag} className="overflow-hidden rounded-lg bg-white/5">
              <img src={n.img} alt="" className="h-48 w-full object-cover" />
              <div className="p-5">
                <span className="text-xs uppercase tracking-widest text-gold">{n.tag}</span>
                <p className="mt-2 text-paper/80">{n.text}</p>
              </div>
            </Reveal>
          ))}
        </div>
      </section>

      {/* CONTACT */}
      <section id="contacto" className="relative overflow-hidden bg-[url('/img/banner2.jpg')] bg-cover bg-center px-6 py-24">
        <div className="absolute inset-0 bg-ink/85" />
        <div className="relative mx-auto grid max-w-6xl gap-12 md:grid-cols-2 md:items-center">
          <Reveal as="left">
            <p className="text-gold">★★★★★</p>
            <h5 className="mt-3 max-w-md font-[var(--font-display)] text-2xl">{t.contact.quote}</h5>
            <a
              href={site.openTable}
              target="_blank"
              rel="noreferrer"
              className="mt-6 inline-block rounded-full border border-gold px-6 py-2.5 text-sm uppercase tracking-widest text-gold hover:bg-gold hover:text-ink transition-colors"
            >
              {t.contact.reservaOnline}
            </a>
          </Reveal>
          <Reveal as="right" delay={0.15} className="rounded-lg bg-ink-soft/90 p-8 shadow-2xl">
            <h4 className="text-center font-[var(--font-display)] text-2xl">{t.contact.title}</h4>
            <div className="mt-6">
              <ContactForm />
            </div>
          </Reveal>
        </div>
      </section>

      <div className="h-[500px] w-full">
        <iframe
          src={site.mapsEmbed}
          width="100%"
          height="100%"
          style={{ border: 0 }}
          loading="lazy"
          referrerPolicy="no-referrer-when-downgrade"
          title="Tei Sushi map"
        />
      </div>
    </div>
  )
}
