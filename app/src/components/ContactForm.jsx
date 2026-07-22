import { useRef, useState } from 'react'
import { motion } from 'framer-motion'
import ReCAPTCHA from 'react-google-recaptcha'
import { useLang } from '../context/LangContext'
import { content, site } from '../data/content'

export default function ContactForm({ variant = 'default' }) {
  const { lang } = useLang()
  const t = variant === 'catering' ? content[lang].catering : content[lang].contact
  const messages = content[lang].contact

  const recaptchaRef = useRef(null)
  const [status, setStatus] = useState('idle') // idle | sending | success | error | captcha

  async function handleSubmit(e) {
    e.preventDefault()
    const form = e.currentTarget
    const captchaToken = recaptchaRef.current?.getValue()
    if (!captchaToken) {
      setStatus('captcha')
      return
    }

    setStatus('sending')
    const formData = new FormData(form)
    const payload = Object.fromEntries(formData.entries())
    payload.recaptchaToken = captchaToken

    try {
      const res = await fetch('/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      })
      const data = await res.json().catch(() => null)
      if (res.ok && data?.success) {
        setStatus('success')
        form.reset()
        recaptchaRef.current?.reset()
      } else {
        setStatus('error')
      }
    } catch {
      setStatus('error')
    }
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label className="mb-1 block text-xs uppercase tracking-widest text-paper/60">{t.fields.nombre}</label>
        <input name="nombre" required className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-2.5 text-paper placeholder:text-paper/30 focus:border-gold focus:outline-none" placeholder={t.fields.nombre} />
      </div>
      <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label className="mb-1 block text-xs uppercase tracking-widest text-paper/60">{t.fields.tel}</label>
          <input name="tel" required className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-2.5 text-paper placeholder:text-paper/30 focus:border-gold focus:outline-none" placeholder={t.fields.tel} />
        </div>
        <div>
          <label className="mb-1 block text-xs uppercase tracking-widest text-paper/60">{t.fields.mail}</label>
          <input type="email" name="mail" required className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-2.5 text-paper placeholder:text-paper/30 focus:border-gold focus:outline-none" placeholder={t.fields.mail} />
        </div>
      </div>
      <div>
        <label className="mb-1 block text-xs uppercase tracking-widest text-paper/60">{t.fields.msj}</label>
        <textarea name="msj" rows={4} className="w-full rounded-md border border-white/15 bg-white/5 px-4 py-2.5 text-paper placeholder:text-paper/30 focus:border-gold focus:outline-none" placeholder={t.fields.msj} />
      </div>

      <ReCAPTCHA ref={recaptchaRef} sitekey={site.recaptchaSiteKey} theme="dark" />

      <motion.button
        whileHover={{ scale: 1.02 }}
        whileTap={{ scale: 0.98 }}
        type="submit"
        disabled={status === 'sending'}
        className="w-full rounded-md bg-gold px-6 py-3 font-medium tracking-wide text-ink transition-opacity disabled:opacity-60"
      >
        {status === 'sending' ? '…' : t.fields.submit}
      </motion.button>

      {status === 'success' && <p className="text-sm text-emerald-400">{messages.success}</p>}
      {status === 'error' && <p className="text-sm text-red-400">{messages.error}</p>}
      {status === 'captcha' && <p className="text-sm text-red-400">{messages.captchaError}</p>}
    </form>
  )
}
