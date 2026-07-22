import { createContext, useContext, useEffect, useState } from 'react'

const LangContext = createContext(null)

export function LangProvider({ children }) {
  const [lang, setLang] = useState(() => localStorage.getItem('teisushi-lang') || 'es')

  useEffect(() => {
    localStorage.setItem('teisushi-lang', lang)
  }, [lang])

  const toggleLang = () => setLang((l) => (l === 'es' ? 'en' : 'es'))

  return <LangContext.Provider value={{ lang, setLang, toggleLang }}>{children}</LangContext.Provider>
}

export function useLang() {
  const ctx = useContext(LangContext)
  if (!ctx) throw new Error('useLang must be used within LangProvider')
  return ctx
}
