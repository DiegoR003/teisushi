import { useLang } from '../context/LangContext'
import { content, site } from '../data/content'
import Reveal from '../components/Reveal'
import ContactForm from '../components/ContactForm'

export default function Catering() {
  const { lang } = useLang()
  const t = content[lang].catering

  return (
    <div className="pt-32">
      <div
        className="relative flex h-[55svh] items-center justify-center bg-cover bg-center"
        style={{ backgroundImage: "url('/img/catering-1.jpg')" }}
      >
        <div className="absolute inset-0 bg-ink/60" />
        <div className="relative text-center">
          <p className="text-xs uppercase tracking-[0.3em] text-gold-soft">{t.kicker}</p>
          <h1 className="mt-2 font-[var(--font-display)] text-5xl">{t.title}</h1>
          <a
            href="#contacto"
            className="mt-6 inline-block rounded-full border border-gold px-8 py-3 text-sm uppercase tracking-widest text-gold hover:bg-gold hover:text-ink transition-colors"
          >
            {t.cta}
          </a>
        </div>
      </div>

      <section className="px-6 py-24">
        <div className="mx-auto grid max-w-6xl gap-12 md:grid-cols-2 md:items-center">
          <Reveal as="left">
            <img src="/img/catering-2.jpg" alt="" className="rounded-lg" />
          </Reveal>
          <Reveal as="right" delay={0.15}>
            <h2 className="font-[var(--font-display)] text-3xl">{t.introTitle}</h2>
            <p className="mt-4 leading-relaxed text-paper/75">{t.introText}</p>
            <ul className="mt-4 space-y-1 text-paper/75">
              {t.bullets.map((b) => (
                <li key={b}>• {b}</li>
              ))}
            </ul>
            <p className="mt-4 font-medium text-paper/90">{t.extrasTitle}</p>
            <ul className="mt-1 space-y-1 text-paper/75">
              {t.extras.map((b) => (
                <li key={b}>• {b}</li>
              ))}
            </ul>
          </Reveal>
        </div>
      </section>

      <section className="bg-ink-soft px-6 py-24">
        <Reveal className="mx-auto max-w-3xl text-center">
          <p className="text-xs uppercase tracking-[0.3em] text-gold">{t.menusSubtitle}</p>
          <h2 className="mt-2 font-[var(--font-display)] text-3xl">{t.menusTitle}</h2>
        </Reveal>
        <div className="mx-auto mt-12 grid max-w-6xl gap-8 sm:grid-cols-3">
          {t.menus.map((m, i) => (
            <Reveal as="up" delay={i * 0.1} key={m.tag} className="group overflow-hidden rounded-lg">
              <div className="relative overflow-hidden">
                <img src={m.img} alt={m.tag} className="h-56 w-full object-cover transition-transform duration-700 group-hover:scale-110" />
              </div>
              <div className="-mt-8 mx-4 rounded-md bg-[#efe9e3] p-5 text-ink shadow-xl">
                <span className="text-xs uppercase tracking-[0.15em] text-[#7a6a58]">{m.tag}</span>
                <p className="mt-2 text-sm leading-relaxed">{m.text}</p>
              </div>
            </Reveal>
          ))}
        </div>
      </section>

      <section id="contacto" className="relative overflow-hidden bg-[url('/img/banner2.jpg')] bg-cover bg-center px-6 py-24">
        <div className="absolute inset-0 bg-ink/85" />
        <div className="relative mx-auto grid max-w-6xl gap-12 md:grid-cols-2 md:items-center">
          <Reveal as="left">
            <p className="text-gold">★★★★★</p>
            <h5 className="mt-3 max-w-md font-[var(--font-display)] text-2xl">{content[lang].contact.quote}</h5>
            <p className="mt-4 text-paper/70">
              📞 WhatsApp:{' '}
              <a href={site.whatsapp} target="_blank" rel="noreferrer" className="text-gold hover:underline">
                {site.phone}
              </a>
            </p>
          </Reveal>
          <Reveal as="right" delay={0.15} className="rounded-lg bg-ink-soft/90 p-8 shadow-2xl">
            <h4 className="text-center font-[var(--font-display)] text-2xl">{t.formTitle}</h4>
            <p className="mt-1 text-center text-sm text-paper/60">{t.formText}</p>
            <div className="mt-6">
              <ContactForm variant="catering" />
            </div>
          </Reveal>
        </div>
      </section>
    </div>
  )
}
