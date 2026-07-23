import { useLang } from "../context/LangContext";
import { content, site } from "../data/content";

export default function Footer() {
  const { lang } = useLang();
  const t = content[lang].footer;

  return (
    <footer className="border-t border-white/10 bg-ink py-8 text-center text-sm text-paper/60">
      <p>{t.rights} </p>
      <p className="mt-2">
        <a href={site.phoneHref} className="hover:text-gold transition-colors">
          {site.phone}
        </a>
      </p>
      <p className="mt-4 text-xs text-paper/35">
        3D model "Stylized Salmon Nigiri Sushi" by{" "}
        <a
          href="https://sketchfab.com/chenkl"
          target="_blank"
          rel="noreferrer"
          className="hover:text-gold/70"
        >
          chenkl
        </a>
        , licensed{" "}
        <a
          href="http://creativecommons.org/licenses/by/4.0/"
          target="_blank"
          rel="noreferrer"
          className="hover:text-gold/70"
        >
          CC-BY-4.0
        </a>
        .
      </p>
    </footer>
  );
}
