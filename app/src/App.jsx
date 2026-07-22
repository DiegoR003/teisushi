import { Routes, Route } from 'react-router-dom'
import { LangProvider } from './context/LangContext'
import Layout from './layout/Layout'
import Home from './pages/Home'
import Menu from './pages/Menu'
import Catering from './pages/Catering'

export default function App() {
  return (
    <LangProvider>
      <Routes>
        <Route element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="menu" element={<Menu />} />
          <Route path="catering" element={<Catering />} />
        </Route>
      </Routes>
    </LangProvider>
  )
}
