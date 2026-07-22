import { Resend } from 'resend'

const resend = new Resend(process.env.RESEND_API_KEY)

const TO_EMAIL = process.env.CONTACT_TO_EMAIL || 'info@teisushi.com'
const FROM_EMAIL = process.env.CONTACT_FROM_EMAIL || 'Tei Sushi <onboarding@resend.dev>'

async function verifyRecaptcha(token) {
  if (!token) return false
  const params = new URLSearchParams({
    secret: process.env.RECAPTCHA_SECRET,
    response: token,
  })
  const res = await fetch('https://www.google.com/recaptcha/api/siteverify', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: params,
  })
  const data = await res.json()
  return data.success === true
}

function isBlank(value) {
  return typeof value !== 'string' || value.trim() === ''
}

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    res.setHeader('Allow', 'POST')
    return res.status(405).json({ success: false, code: 'method_not_allowed' })
  }

  const { nombre, tel, mail, msj, recaptchaToken } = req.body || {}

  const captchaOk = await verifyRecaptcha(recaptchaToken)
  if (!captchaOk) {
    return res.status(400).json({ success: false, code: 'captcha' })
  }

  if (isBlank(nombre) || isBlank(tel) || isBlank(mail) || isBlank(msj)) {
    return res.status(400).json({ success: false, code: 'empty_field' })
  }

  try {
    await resend.emails.send({
      from: FROM_EMAIL,
      to: TO_EMAIL,
      reply_to: mail,
      subject: `${nombre} ha enviado un nuevo mensaje`,
      html: `
        <p><strong>Nombre:</strong> ${nombre}</p>
        <p><strong>Email:</strong> ${mail}</p>
        <p><strong>Teléfono:</strong> ${tel}</p>
        <p><strong>Mensaje:</strong> ${msj}</p>
      `,
    })
    return res.status(200).json({ success: true, code: '0' })
  } catch (err) {
    console.error('contact.js send error', err)
    return res.status(500).json({ success: false, code: 'send_failed' })
  }
}
