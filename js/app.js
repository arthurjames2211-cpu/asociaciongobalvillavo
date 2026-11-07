/* =========================================================
   App del sitio. Todo el contenido sale de datos.json.
   - Lo que falta en datos.json NO se inventa: el público no ve nada raro,
     y quien administra (entrando con ?admin=1) ve recuadros "Información pendiente".
   ========================================================= */
(function () {
  'use strict';

  const ROOT = document.documentElement;
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
  const esc = (s) => String(s == null ? '' : s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const store = {
    get(k) { try { return localStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { localStorage.setItem(k, v); } catch (e) { /* sin almacenamiento */ } },
    del(k) { try { localStorage.removeItem(k); } catch (e) { /* sin almacenamiento */ } },
  };
  const get = (o, path) => path.split('.').reduce((a, k) => (a == null ? undefined : a[k]), o);
  const vacio = (v) => v == null || v === '' || (Array.isArray(v) && v.length === 0) || (typeof v === 'object' && !Array.isArray(v) && Object.keys(v).length === 0);
  const nf = (n, dec = 0) => Number(n).toLocaleString('es-CO', { minimumFractionDigits: dec, maximumFractionDigits: dec });

  const ICONS = window.ICONS || {};
  const BRANDS = window.BRANDS || {};
  const icon = (n, cls) => `<svg${cls ? ` class="${cls}"` : ''} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">${ICONS[n] || ''}</svg>`;
  const brand = (k, fill) => {
    const b = BRANDS[k]; if (!b) return '';
    return `<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="${fill || b.hex}" d="${b.path}"/></svg>`;
  };

  const PAGINAS = [
    ['inicio', 'Inicio', 'index.html'],
    ['quienes', 'Quiénes somos', 'quienes-somos.html'],
    ['servicios', 'Servicios', 'servicios.html'],
    ['reciclar', 'Cómo reciclar', 'como-reciclar.html'],
    ['rutas', 'Rutas y horarios', 'rutas-y-horarios.html'],
    ['toneladas', 'Toneladas aprovechadas', 'toneladas.html'],
    ['noticias', 'Noticias', 'noticias.html'],
    ['contacto', 'Contacto', 'contacto.html'],
  ];

  /* Lista de todo lo que puede faltar. Sirve para los recuadros y para la lista de pendientes. */
  const CAMPOS = {
    'empresa.fundacion': ['Año de fundación', 'Cifras del inicio y Quiénes somos'],
    'empresa.telefono': ['Teléfono', 'Encabezado, pie y Contacto'],
    'empresa.whatsapp': ['Número de WhatsApp (con indicativo, ej. 573001234567)', 'Botón del encabezado, botón flotante y trámites'],
    'empresa.correo': ['Correo electrónico', 'Pie y Contacto'],
    'empresa.direccion': ['Dirección', 'Pie y Contacto'],
    'empresa.horario': ['Horario de atención', 'Encabezado, pie y Contacto'],
    'empresa.mapaUrl': ['Mapa o cómo llegar (enlace de inserción de Google Maps)', 'Contacto'],
    'redes.facebook': ['Enlace de Facebook', 'Encabezado, pie y Contacto'],
    'redes.instagram': ['Enlace de Instagram', 'Encabezado, pie y Contacto'],
    'redes.tiktok': ['Enlace de TikTok', 'Encabezado, pie y Contacto'],
    'redes.youtube': ['Enlace de YouTube', 'Encabezado, pie y Contacto'],
    'inicio.galeria': ['Galería: de 6 a 8 fotos buenas (recicladores con uniforme, sin basura ni piso sucio)', 'Inicio'],
    'inicio.video': ['Un video corto (formato vertical)', 'Inicio'],
    'quienes.historia': ['Historia de la asociación', 'Quiénes somos'],
    'quienes.mision': ['Misión', 'Quiénes somos'],
    'quienes.vision': ['Visión', 'Quiénes somos'],
    'quienes.trabajoSocial': ['Trabajo social con los recicladores y sus familias (actividades, capacitaciones, jornadas)', 'Quiénes somos'],
    'quienes.equipo': ['Equipo (solo con autorización escrita para publicar nombre y foto)', 'Quiénes somos'],
    'quienes.certificaciones': ['Certificaciones y registros (si existen)', 'Quiénes somos'],
    'legal.nit': ['NIT', 'Pie y Quiénes somos'],
    'legal.representanteLegal': ['Representante legal', 'Quiénes somos'],
    'legal.politicaDatosUrl': ['Política de tratamiento de datos personales (revisada por un abogado)', 'Pie y formulario de Contacto'],
    'servicios.reciben': ['Materiales que recibimos', 'Servicios'],
    'servicios.recolectan': ['Qué recolectamos y dónde', 'Servicios'],
    'servicios.comoPedir': ['Pasos para pedir el servicio', 'Servicios'],
    'servicios.tarifa': ['Costo y condiciones de la recolección (por ejemplo, desde qué cantidad de material es gratis)', 'Servicios'],
    'zonas': ['Zonas o rutas con días, horario y a quién contactar', 'Rutas y horarios, buscador del inicio'],
    'toneladas': ['Toneladas de cada mes (año, mes, aprovechadas y rechazo)', 'Toneladas aprovechadas, cifras del inicio'],
    'noticias': ['Noticias con foto', 'Noticias, inicio'],
  };

  let D = {};
  const vistos = new Set();
  const faltantes = () => Object.keys(CAMPOS).filter((k) => vacio(get(D, k)));
  const pend = (path, extra) => {
    const c = CAMPOS[path] || [path, ''];
    vistos.add(path);
    return `<div class="pendiente" role="note"><strong>Información pendiente</strong>${esc(c[0])}${extra ? ' — ' + esc(extra) : ''}</div>`;
  };

  const waLink = (msg) => {
    let n = String((D.empresa && D.empresa.whatsapp) || '').replace(/\D/g, '');
    if (!n) return null;
    if (n.length === 10 && n[0] === '3') n = '57' + n;
    return `https://wa.me/${n}?text=${encodeURIComponent(msg || '')}`;
  };
  const nombre = () => (D.empresa && D.empresa.nombre) || 'Nuestra asociación';
  const msgBase = () => `Hola, quiero información sobre el servicio de reciclaje de ${nombre()}.`;
  const msgRecoleccion = () => `Hola, quiero pedir una recolección de material reciclable. Mi barrio es: `;

  const fechaLarga = (iso) => {
    const d = new Date(iso + 'T00:00:00Z');
    if (isNaN(d)) return iso;
    return d.toLocaleDateString('es-CO', { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' });
  };
  const MESES = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

  /* ---------- Accesibilidad (tamaño de letra y contraste) ---------- */
  function aplicarPrefs() {
    const t = store.get('tam'); if (t) ROOT.dataset.tam = t;
    ROOT.classList.toggle('alto-contraste', store.get('contraste') === '1');
  }
  function cambiarTam(delta) {
    let t = parseInt(ROOT.dataset.tam || '0', 10) + delta;
    t = Math.max(0, Math.min(3, t));
    ROOT.dataset.tam = String(t); store.set('tam', String(t));
  }
  function alternarContraste(btn) {
    const on = !ROOT.classList.contains('alto-contraste');
    ROOT.classList.toggle('alto-contraste', on); store.set('contraste', on ? '1' : '0');
    btn.setAttribute('aria-pressed', on ? 'true' : 'false');
  }

  /* ---------- Redes ---------- */
  function htmlRedes(grande) {
    const r = D.redes || {};
    const lista = [['facebook', 'Facebook'], ['instagram', 'Instagram'], ['tiktok', 'TikTok'], ['youtube', 'YouTube'], ['x', 'X']]
      .filter(([k]) => !vacio(r[k]));
    if (!lista.length) return '';
    return `<div class="redes${grande ? ' redes--grande' : ''}" role="list">${lista.map(([k, n]) =>
      `<a role="listitem" href="${esc(r[k])}" target="_blank" rel="noopener" aria-label="${n} de ${esc(nombre())}" title="${n}">${brand(k)}</a>`).join('')}</div>`;
  }

  /* ---------- Encabezado y pie ---------- */
  function renderCabecera(pagina) {
    const e = D.empresa || {};
    const wa = waLink(msgBase());
    const tel = e.telefono ? `<a href="tel:${esc(String(e.telefono).replace(/[^\d+]/g, ''))}">${icon('phone')} ${esc(e.telefono)}</a>` : '';
    const mail = e.correo ? `<a href="mailto:${esc(e.correo)}">${icon('mail')} ${esc(e.correo)}</a>` : '';
    const hor = e.horario ? `<span>${icon('clock')} ${esc(e.horario)}</span>` : '';
    const top = `
      <div class="barra-top">
        <div class="contenedor">
          <div class="barra-top__datos">${tel}${mail}${hor}</div>
          <div class="barra-top__der">
            <div class="a11y" role="group" aria-label="Opciones de accesibilidad">
              <button type="button" data-a11y="menos" aria-label="Reducir el tamaño del texto">A−</button>
              <button type="button" data-a11y="mas" aria-label="Aumentar el tamaño del texto">A+</button>
              <button type="button" data-a11y="contraste" aria-pressed="${ROOT.classList.contains('alto-contraste')}" aria-label="Alto contraste"><span class="hide-s">Alto contraste</span><span class="show-s">Contraste</span></button>
            </div>
            ${htmlRedes(false)}
          </div>
        </div>
      </div>`;
    const nav = PAGINAS.map(([id, txt, href]) => `<li><a href="${href}"${id === pagina ? ' aria-current="page"' : ''}>${txt}</a></li>`).join('');
    const botonWa = wa
      ? `<a class="btn btn--wa btn--chico cabecera__wa" href="${esc(wa)}" target="_blank" rel="noopener">${brand('whatsapp', '#fff')}<span>WhatsApp</span></a>`
      : `<span class="pend-chip cabecera__wa">Falta WhatsApp</span>`;
    if (!wa) vistos.add('empresa.whatsapp');
    const cab = `
      <header class="cabecera" id="cabecera">
        <div class="contenedor">
          <a class="marca" href="index.html" aria-label="${esc(nombre())}, ir al inicio">
            <img src="img/logo.webp" width="54" height="54" alt="">
            <span class="marca__texto"><strong>${esc(nombre())}</strong>${e.ciudad ? `<small>${esc(e.ciudad)}</small>` : ''}</span>
          </a>
          ${botonWa}
          <button class="btn-menu" type="button" aria-expanded="false" aria-controls="menu-principal">${icon('menu')}<span>Menú</span></button>
          <nav class="nav" id="menu-principal" aria-label="Principal" data-abierto="false"><ul>${nav}</ul></nav>
        </div>
      </header>`;
    const saltar = `<a class="saltar" href="#contenido">Saltar al contenido</a>`;
    document.body.insertAdjacentHTML('afterbegin', saltar + top + cab);

    // menú móvil
    const btn = $('.btn-menu'); const menu = $('#menu-principal');
    const cerrar = () => { menu.dataset.abierto = 'false'; btn.setAttribute('aria-expanded', 'false'); btn.innerHTML = `${icon('menu')}<span>Menú</span>`; };
    btn.addEventListener('click', () => {
      const abierto = menu.dataset.abierto === 'true';
      if (abierto) { cerrar(); } else { menu.dataset.abierto = 'true'; btn.setAttribute('aria-expanded', 'true'); btn.innerHTML = `${icon('x')}<span>Cerrar</span>`; }
    });
    document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape' && menu.dataset.abierto === 'true') { cerrar(); btn.focus(); } });
    $$('a', menu).forEach((a) => a.addEventListener('click', cerrar));

    // accesibilidad
    $$('[data-a11y]').forEach((b) => b.addEventListener('click', () => {
      const k = b.dataset.a11y;
      if (k === 'mas') cambiarTam(1); else if (k === 'menos') cambiarTam(-1); else alternarContraste(b);
    }));
  }

  function renderPie(pagina) {
    const e = D.empresa || {}; const l = D.legal || {};
    const contacto = [];
    if (e.telefono) contacto.push(`<li>${icon('phone')} <a href="tel:${esc(String(e.telefono).replace(/[^\d+]/g, ''))}">${esc(e.telefono)}</a></li>`);
    if (e.correo) contacto.push(`<li>${icon('mail')} <a href="mailto:${esc(e.correo)}">${esc(e.correo)}</a></li>`);
    if (e.direccion) contacto.push(`<li>${icon('map-pin')} ${esc(e.direccion)}${e.ciudad ? ', ' + esc(e.ciudad) : ''}</li>`);
    if (e.horario) contacto.push(`<li>${icon('clock')} ${esc(e.horario)}</li>`);
    const pendContacto = ['empresa.telefono', 'empresa.correo', 'empresa.direccion', 'empresa.horario'].filter((k) => vacio(get(D, k))).map((k) => pend(k)).join('');
    const redes = htmlRedes(true);
    const pendRedes = ['facebook', 'instagram', 'tiktok', 'youtube'].filter((k) => vacio((D.redes || {})[k])).map((k) => pend('redes.' + k)).join('');
    const politica = l.politicaDatosUrl
      ? `<a href="${esc(l.politicaDatosUrl)}" target="_blank" rel="noopener">Política de tratamiento de datos personales</a>`
      : pend('legal.politicaDatosUrl');
    const pie = `
      <footer class="pie">
        <div class="contenedor">
          <div class="pie__grid">
            <div>
              <div class="pie__marca"><img src="img/logo.webp" width="64" height="64" alt="" loading="lazy"><strong>${esc(nombre())}</strong></div>
              <p>${e.lema ? esc(e.lema) : 'Reciclaje que cuida el ambiente y a las personas que lo hacen posible.'}</p>
            </div>
            <div>
              <h2>Páginas</h2>
              <ul>${PAGINAS.map(([id, t, h]) => `<li><a href="${h}">${t}</a></li>`).join('')}</ul>
            </div>
            <div>
              <h2>Contacto</h2>
              ${contacto.length ? `<ul class="pie-contacto">${contacto.join('')}</ul>` : `<p><a href="contacto.html">Escríbenos desde el formulario de contacto</a></p>`}
              ${pendContacto}
            </div>
            <div${redes ? '' : ' class="solo-admin"'}>
              <h2>Síguenos</h2>
              ${redes || ''}${pendRedes}
            </div>
          </div>
          <div class="pie__legal">
            <span>© ${new Date().getFullYear()} ${esc(nombre())}${l.nit ? ' · NIT ' + esc(l.nit) : ''}</span>
            <span>${politica}</span>
          </div>
          ${l.nit ? '' : pend('legal.nit')}
        </div>
      </footer>`;
    document.body.insertAdjacentHTML('beforeend', pie);
    $$('.pie-contacto svg').forEach((s) => { s.style.cssText = 'width:1em;height:1em;vertical-align:-.12em;margin-right:.3rem'; });
  }

  function renderWaFlotante() {
    const wa = waLink(msgBase());
    if (!wa) return;
    document.body.insertAdjacentHTML('beforeend',
      `<a class="wa-flota" href="${esc(wa)}" target="_blank" rel="noopener" aria-label="WhatsApp: ¿Dudas? Escríbenos">${brand('whatsapp', '#fff')}<span>¿Dudas? Escríbenos</span></a>`);
  }

  /* Botones que piden recolección: WhatsApp si hay número; si no, el formulario. */
  function enlazarRecoleccion() {
    const wa = waLink(msgRecoleccion());
    $$('[data-wa-recoleccion]').forEach((a) => {
      if (wa) { a.href = wa; a.target = '_blank'; a.rel = 'noopener'; }
      else { a.href = 'contacto.html?asunto=solicitud#formulario'; }
    });
    $$('[data-wa-general]').forEach((a) => {
      const w = waLink(msgBase());
      if (w) { a.href = w; a.target = '_blank'; a.rel = 'noopener'; } else { a.href = 'contacto.html#formulario'; }
    });
  }

  /* ---------- Textos con datos (data-bind) ---------- */
  function hidratar() {
    $$('[data-bind]').forEach((el) => {
      const v = get(D, el.dataset.bind);
      if (!vacio(v)) el.textContent = v;
    });
    $$('[data-icon]').forEach((el) => { el.innerHTML = icon(el.dataset.icon); });
    $$('[data-brand]').forEach((el) => { el.innerHTML = brand(el.dataset.brand, el.dataset.fill); });
  }

  /* ---------- Piezas reutilizables ---------- */
  const vaciaPublica = (ic, texto) => `<div class="vacio reveal">${icon(ic)}<p>${esc(texto)}</p></div>`;

  function htmlNoticia(n, i) {
    const foto = n.foto ? `<img class="noticia__foto" src="${esc(n.foto)}" alt="${esc(n.fotoAlt || '')}" loading="lazy" width="640" height="360">` : `<span class="noticia__foto" aria-hidden="true"></span>`;
    const parrafos = (n.texto || '').split(/\n{2,}|\n/).filter(Boolean).map((p) => `<p>${esc(p)}</p>`).join('');
    return `<article class="tarjeta noticia reveal" style="--d:${(i % 3) * .08}s">
      ${foto}
      <div class="noticia__cuerpo">
        <time datetime="${esc(n.fecha)}">${esc(fechaLarga(n.fecha))}</time>
        <h3>${esc(n.titulo)}</h3>
        <p>${esc(n.resumen || '')}</p>
        ${parrafos ? `<details><summary>Leer la noticia completa</summary>${parrafos}</details>` : ''}
      </div></article>`;
  }
  const noticiasOrdenadas = () => (D.noticias || []).slice().sort((a, b) => String(b.fecha).localeCompare(String(a.fecha)));

  /* ---------- Páginas ---------- */
  const paginas = {};

  paginas.inicio = function () {
    // Buscador de zona
    const zonas = D.zonas || [];
    const dl = $('#lista-zonas');
    const campo = $('#buscar-zona'); const res = $('#buscar-res');
    if (dl) dl.innerHTML = zonas.flatMap((z) => [z.nombre].concat(z.barrios || [])).filter((v, i, a) => v && a.indexOf(v) === i).map((v) => `<option value="${esc(v)}">`).join('');
    const buscar = () => {
      const q = (campo.value || '').trim().toLowerCase();
      if (!zonas.length) {
        res.innerHTML = `<div class="resultado-ruta">Todavía no hay rutas publicadas. <a href="contacto.html#formulario">Escríbenos tu barrio</a> y te contamos si llegamos.</div>` + pend('zonas');
        return;
      }
      if (!q) { res.innerHTML = ''; return; }
      const hit = zonas.filter((z) => [z.nombre].concat(z.barrios || []).some((x) => String(x).toLowerCase().includes(q)));
      res.innerHTML = hit.length
        ? hit.map((z) => `<div class="resultado-ruta"><strong>${esc(z.nombre)}</strong><br>${z.dias ? 'Días: ' + esc(z.dias) : ''}${z.horario ? ' · Horario: ' + esc(z.horario) : ''}<br><a href="rutas-y-horarios.html?zona=${encodeURIComponent(z.nombre)}">Ver la ruta completa</a></div>`).join('')
        : `<div class="resultado-ruta">No encontramos «${esc(campo.value)}» en las rutas publicadas. <a href="contacto.html#formulario">Escríbenos tu barrio</a>.</div>`;
    };
    $('#form-buscar').addEventListener('submit', (ev) => { ev.preventDefault(); buscar(); });
    campo.addEventListener('input', () => { if (zonas.length) buscar(); });
    if (!zonas.length) { res.innerHTML = pend('zonas'); }

    // Cifras
    const caja = $('#cifras');
    const cifras = [];
    const e = D.empresa || {};
    if (e.fundacion) cifras.push({ n: e.fundacion, t: 'Año de fundación', sep: false });
    if ((D.zonas || []).length) cifras.push({ n: D.zonas.length, t: 'Zonas atendidas' });
    const total = (D.toneladas || []).reduce((s, r) => s + (Number(r.aprovechadas) || 0), 0);
    if (total > 0) cifras.push({ n: total, t: 'Toneladas aprovechadas', dec: total % 1 ? 1 : 0 });
    const sec = $('#sec-cifras');
    if (cifras.length) {
      caja.innerHTML = `<div class="cifras">${cifras.map((c, i) => `<div class="tarjeta tarjeta--plana cifra reveal" style="--d:${i * .1}s"><div class="cifra__num" data-cuenta="${c.n}" data-dec="${c.dec || 0}" data-sep="${c.sep === false ? 0 : 1}">0</div><div class="cifra__txt">${esc(c.t)}</div></div>`).join('')}</div>`;
      sec.hidden = false;
    }
    const pc = ['empresa.fundacion', 'zonas', 'toneladas'].filter((k) => vacio(get(D, k))).map((k) => pend(k)).join('');
    if (pc) { caja.insertAdjacentHTML('beforeend', pc); sec.hidden = false; if (!cifras.length) sec.classList.add('solo-admin'); }

    // Galería y video
    const gal = (D.inicio && D.inicio.galeria) || [];
    const vid = D.inicio && D.inicio.video;
    const gcaja = $('#galeria');
    let g = '';
    if (gal.length) {
      const n = Math.min(gal.length, 8); const cols = n % 4 === 0 ? 4 : 3;
      g += `<div class="galeria" style="--cols:${cols}">${gal.slice(0, 8).map((f, i) => `<button type="button" class="reveal" style="--d:${(i % 4) * .06}s" data-foto="${esc(f.src)}" data-alt="${esc(f.alt || '')}" aria-label="Ampliar foto: ${esc(f.alt || 'galería')}"><img src="${esc(f.src)}" alt="${esc(f.alt || '')}" loading="lazy" width="480" height="360"></button>`).join('')}</div>`;
    }
    if (gal.length < 6) g += pend('inicio.galeria', gal.length ? `hay ${gal.length}, faltan ${6 - gal.length}` : '');
    const vcaja = $('#video-caja');
    let v = '';
    if (vid && vid.src) {
      v = `<video class="video-vertical" controls playsinline preload="metadata" ${vid.poster ? `poster="${esc(vid.poster)}"` : ''} aria-label="${esc(vid.titulo || 'Video de la asociación')}"><source src="${esc(vid.src)}" type="video/mp4"></video>`;
    } else { v = pend('inicio.video'); }
    if (gal.length || (vid && vid.src) || document.body.classList.contains('es-admin')) { $('#sec-galeria').hidden = false; }
    gcaja.innerHTML = g; vcaja.innerHTML = v;
    $('#galeria-wrap').classList.toggle('con-video', !!(vid && vid.src));
    if (!(gal.length || (vid && vid.src))) $('#sec-galeria').classList.add('solo-admin');
    $$('[data-foto]').forEach((b) => b.addEventListener('click', () => {
      const dlg = $('#visor'); $('img', dlg).src = b.dataset.foto; $('img', dlg).alt = b.dataset.alt; dlg.showModal();
    }));
    const dlg = $('#visor'); if (dlg) { dlg.addEventListener('click', (ev) => { if (ev.target === dlg || ev.target.closest('[data-cerrar]')) dlg.close(); }); }

    // Últimas noticias
    const ult = noticiasOrdenadas().slice(0, 3);
    const nc = $('#ultimas-noticias');
    if (ult.length) { nc.innerHTML = `<div class="rejilla rejilla--3">${ult.map(htmlNoticia).join('')}</div>`; }
    else { $('#sec-noticias').classList.add('solo-admin'); nc.innerHTML = pend('noticias'); }
  };

  paginas.quienes = function () {
    const q = D.quienes || {}; const l = D.legal || {}; const e = D.empresa || {};
    const parte = (clave, titulo, ic, extra = '') => {
      const v = q[clave];
      if (vacio(v)) return pend('quienes.' + clave);
      return `<article class="tarjeta tarjeta--plana cita-mv reveal"><div class="icono-caja">${icon(ic)}</div><h2>${titulo}</h2>${String(v).split(/\n+/).map((p) => `<p>${esc(p)}</p>`).join('')}${extra}</article>`;
    };
    const historia = vacio(q.historia) ? pend('quienes.historia') : `<div class="reveal"><span class="etiqueta">Nuestra historia</span><h2>Cómo empezamos</h2>${q.historia.split(/\n+/).map((p) => `<p class="lead">${esc(p)}</p>`).join('')}</div>`;
    $('#q-historia').innerHTML = historia + (e.fundacion ? `<p class="reveal"><strong>Fundada en ${esc(e.fundacion)}.</strong></p>` : pend('empresa.fundacion'));
    $('#q-mv').innerHTML = parte('mision', 'Misión', 'target') + parte('vision', 'Visión', 'eye');
    $('#q-social').innerHTML = vacio(q.trabajoSocial)
      ? pend('quienes.trabajoSocial')
      : `<div class="reveal" style="max-width:70ch">${String(q.trabajoSocial).split(/\n+/).map((p) => `<p class="lead">${esc(p)}</p>`).join('')}</div>`;
    if (vacio(q.trabajoSocial)) $('#q-social-sec').classList.add('solo-admin');
    const eq = q.equipo || [];
    $('#q-equipo').innerHTML = eq.length
      ? `<div class="equipo">${eq.map((p, i) => `<div class="tarjeta persona reveal" style="--d:${i * .07}s">${p.foto ? `<img src="${esc(p.foto)}" alt="${esc(p.nombre)}" width="112" height="112" loading="lazy">` : `<span class="avatar" aria-hidden="true"></span>`}<h3>${esc(p.nombre)}</h3><small>${esc(p.cargo || '')}</small></div>`).join('')}</div>`
      : pend('quienes.equipo');
    const ce = q.certificaciones || [];
    $('#q-certs').innerHTML = ce.length
      ? `<ul class="lista-chulos">${ce.map((c) => `<li>${esc(typeof c === 'string' ? c : c.nombre)}${c.entidad ? ` — <small>${esc(c.entidad)}</small>` : ''}</li>`).join('')}</ul>`
      : pend('quienes.certificaciones');
    const datosLegales = [];
    if (l.nit) datosLegales.push(`<li>${icon('badge-check')}<div><b>NIT</b>${esc(l.nit)}</div></li>`);
    if (l.representanteLegal) datosLegales.push(`<li>${icon('users')}<div><b>Representante legal</b>${esc(l.representanteLegal)}</div></li>`);
    $('#q-legal').innerHTML = (datosLegales.length ? `<ul class="datos-contacto">${datosLegales.join('')}</ul>` : '')
      + (l.nit ? '' : pend('legal.nit')) + (l.representanteLegal ? '' : pend('legal.representanteLegal'))
      + (l.politicaDatosUrl ? `<p><a href="${esc(l.politicaDatosUrl)}" target="_blank" rel="noopener">Política de tratamiento de datos personales</a></p>` : pend('legal.politicaDatosUrl'));
    $$('#q-legal .datos-contacto li').forEach((li) => { const s = li.querySelector('svg'); if (s) { const w = document.createElement('div'); w.className = 'icono-caja'; s.replaceWith(w); w.appendChild(s); } });
    // el público no ve secciones vacías
    const oculta = (id, vacia) => { const el = $(id); if (el && vacia) el.classList.add('solo-admin'); };
    oculta('#q-sec-mv', vacio(q.mision) && vacio(q.vision));
    oculta('#q-sec-equipo', !eq.length);
    oculta('#q-col-certs', !ce.length);
    oculta('#q-col-legal', !l.nit && !l.representanteLegal && !l.politicaDatosUrl);
    oculta('#q-sec-info', !ce.length && !l.nit && !l.representanteLegal && !l.politicaDatosUrl);
    // si nada se publicó, mensaje para el público
    const hayAlgo = ['historia', 'mision', 'vision', 'trabajoSocial'].some((k) => !vacio(q[k])) || eq.length || ce.length || l.nit || l.representanteLegal;
    if (!hayAlgo) $('#q-vacio').innerHTML = vaciaPublica('sprout', 'Estamos preparando esta página con nuestra historia, misión, visión y equipo.');
  };

  paginas.servicios = function () {
    const s = D.servicios || {};
    const lista = (arr, clase) => `<ul class="lista-chulos ${clase || ''}">${arr.map((x) => `<li>${esc(typeof x === 'string' ? x : x.nombre)}</li>`).join('')}</ul>`;
    $('#s-reciben').innerHTML = vacio(s.reciben) ? pend('servicios.reciben') : lista(s.reciben);
    $('#s-recolectan').innerHTML = vacio(s.recolectan) ? pend('servicios.recolectan') : lista(s.recolectan);
    const pasos = s.comoPedir || [];
    $('#s-como').innerHTML = pasos.length
      ? `<ol class="pasos">${pasos.map((p) => `<li><h3>${esc(p.titulo)}</h3><p>${esc(p.texto || '')}</p></li>`).join('')}</ol>`
      : pend('servicios.comoPedir');
    $('#s-tarifa').innerHTML = vacio(s.tarifa)
      ? pend('servicios.tarifa')
      : `<div class="tarjeta tarjeta--verde tarjeta--plana reveal"><h3>Costo y condiciones</h3>${String(s.tarifa).split(/\n+/).map((p) => `<p>${esc(p)}</p>`).join('')}</div>`;
    const ocultaS = (id, vacia) => { const el = $(id); if (el && vacia) el.classList.add('solo-admin'); };
    ocultaS('#s-card-reciben', vacio(s.reciben)); ocultaS('#s-card-recolectan', vacio(s.recolectan));
    ocultaS('#s-rejilla', vacio(s.reciben) && vacio(s.recolectan)); ocultaS('#s-como-bloque', !pasos.length);
    if (vacio(s.reciben) && vacio(s.recolectan)) $('#s-vacio').innerHTML = vaciaPublica('truck', 'Pronto publicaremos aquí los materiales que recibimos y lo que recolectamos. Mientras tanto, escríbenos y te contamos.');
  };

  paginas.rutas = function () {
    const zonas = D.zonas || [];
    const verTel = D.mostrarTelefonosRecicladores === true;
    const sel = $('#sel-zona'); const tabla = $('#tabla-rutas'); const info = $('#rutas-info');
    if (!zonas.length) {
      $('#rutas-contenido').hidden = true;
      info.innerHTML = vaciaPublica('map-pin', 'Todavía no hay rutas publicadas. Escríbenos tu barrio y te decimos si llegamos y qué día.') + pend('zonas');
      return;
    }
    sel.innerHTML = `<option value="">Todas las zonas</option>` + zonas.map((z) => `<option value="${esc(z.nombre)}">${esc(z.nombre)}</option>`).join('');
    const contacto = (z) => {
      if (!z.reciclador) return '<span class="solo-admin-inline">—</span>';
      const t = verTel && z.publicarTelefono === true && z.telefono ? `<br><a href="tel:${esc(String(z.telefono).replace(/[^\d+]/g, ''))}">${esc(z.telefono)}</a>` : '';
      return `${esc(z.reciclador)}${t}`;
    };
    const pintar = () => {
      const f = sel.value;
      const lista = f ? zonas.filter((z) => z.nombre === f) : zonas;
      $('tbody', tabla).innerHTML = lista.map((z) => `<tr${f ? ' class="resaltada"' : ''}><th scope="row">${esc(z.nombre)}${z.barrios && z.barrios.length ? `<br><small>${esc(z.barrios.join(', '))}</small>` : ''}</th><td>${esc(z.dias || '—')}</td><td>${esc(z.horario || '—')}</td><td>${contacto(z)}</td></tr>`).join('');
    };
    sel.addEventListener('change', pintar);
    const pre = new URLSearchParams(location.search).get('zona'); if (pre) sel.value = pre;
    pintar();
    if (!verTel) info.innerHTML = '';
  };

  paginas.toneladas = function () {
    const datos = (D.toneladas || []).filter((r) => r && r.anio && r.mes);
    const cont = $('#t-contenido');
    if (!datos.length) {
      cont.hidden = true;
      $('#t-vacio').innerHTML = vaciaPublica('chart-column', 'Aún no hemos publicado las toneladas aprovechadas. Cuando tengamos los primeros meses, las verás aquí.') + pend('toneladas');
      return;
    }
    const anios = Array.from(new Set(datos.map((r) => Number(r.anio)))).sort((a, b) => b - a);
    const sel = $('#sel-anio');
    sel.innerHTML = anios.map((a) => `<option value="${a}">${a}</option>`).join('');
    const pintar = () => {
      const anio = Number(sel.value);
      const porMes = Array.from({ length: 12 }, (_, i) => datos.filter((r) => Number(r.anio) === anio && Number(r.mes) === i + 1).reduce((s, r) => ({ a: s.a + (Number(r.aprovechadas) || 0), x: s.x + (Number(r.rechazo) || 0), hay: true }), { a: 0, x: 0, hay: false }));
      const max = Math.max(...porMes.map((m) => m.a), 0);
      // escala con marcas "redondas": 4 intervalos iguales con un paso agradable
      let paso = 1;
      outer: for (let k = -2; k <= 7; k++) { for (const m of [1, 1.2, 1.5, 2, 2.5, 3, 4, 5, 6, 8]) { const c = m * Math.pow(10, k); if (c * 4 >= max) { paso = c; break outer; } } }
      const tope = paso * 4;
      const decEje = paso < 1 ? (paso < 0.1 ? 2 : 1) : (Math.abs(paso - Math.round(paso)) > 1e-9 ? 1 : 0);
      const ejes = [4, 3, 2, 1, 0].map((i) => `<span>${nf(paso * i, decEje)}</span>`).join('');
      const barras = porMes.map((m, i) => {
        const h = m.hay ? (m.a / tope) * 100 : 0;
        const etiq = m.hay ? `${MESES[i][0].toUpperCase() + MESES[i].slice(1)}: ${nf(m.a, 1)} toneladas aprovechadas` : `${MESES[i][0].toUpperCase() + MESES[i].slice(1)}: sin datos`;
        return `<div class="barra" role="img" aria-label="${etiq}" tabindex="0" title="${etiq}"><span class="rel" data-h="${h}"></span>${m.hay ? `<b style="--h:${h}%">${nf(m.a, 1)}</b>` : ''}</div>`;
      }).join('');
      const abr = MESES.map((m) => m.slice(0, 3));
      $('#t-barras').innerHTML = `<div class="barras" id="barras-js"><div class="barras__eje" aria-hidden="true">${ejes}</div><div class="barras__area">${barras}</div><div class="barras__meses" aria-hidden="true">${abr.map((m) => `<span>${m}</span>`).join('')}</div></div>`;
      const totA = porMes.reduce((s, m) => s + m.a, 0); const totX = porMes.reduce((s, m) => s + m.x, 0);
      const meses = porMes.filter((m) => m.hay).length;
      const hayX = porMes.some((m) => m.x > 0);
      $('#t-totales').innerHTML =
        `<div class="total"><b>${nf(totA, 1)} t</b><span>Total aprovechado en ${anio}</span></div>` +
        `<div class="total"><b>${meses}</b><span>${meses === 1 ? 'mes reportado' : 'meses reportados'}</span></div>` +
        (hayX ? `<div class="total"><b>${nf(totX, 1)} t</b><span>Material de rechazo en ${anio}</span></div><div class="total"><b>${nf((totA / (totA + totX)) * 100, 0)} %</b><span>Aprovechado frente al total recibido</span></div>` : '');
      $('#t-tabla tbody').innerHTML = porMes.map((m, i) => m.hay ? `<tr><th scope="row">${MESES[i][0].toUpperCase() + MESES[i].slice(1)}</th><td class="num">${nf(m.a, 1)}</td><td class="num">${hayX ? nf(m.x, 1) : '—'}</td></tr>` : '').join('');
      $('#t-tabla tfoot').innerHTML = `<tr><td>Total ${anio}</td><td class="num">${nf(totA, 1)}</td><td class="num">${hayX ? nf(totX, 1) : '—'}</td></tr>`;
      animarBarras();
    };
    sel.addEventListener('change', pintar);
    pintar();
  };

  paginas.noticias = function () {
    const todas = noticiasOrdenadas();
    const cont = $('#n-lista');
    if (!todas.length) { cont.innerHTML = vaciaPublica('newspaper', 'Todavía no hay noticias. Aquí iremos publicando lo que hacemos: capacitaciones, jornadas y novedades.') + pend('noticias'); $('#n-filtro').hidden = true; return; }
    const anios = Array.from(new Set(todas.map((n) => String(n.fecha).slice(0, 4))));
    const sel = $('#n-anio');
    sel.innerHTML = `<option value="">Todos los años</option>` + anios.map((a) => `<option>${a}</option>`).join('');
    const pintar = () => {
      const lista = sel.value ? todas.filter((n) => String(n.fecha).startsWith(sel.value)) : todas;
      cont.innerHTML = `<div class="rejilla rejilla--3">${lista.map(htmlNoticia).join('')}</div>`;
      observarReveal();
    };
    sel.addEventListener('change', pintar); pintar();
  };

  paginas.contacto = function () {
    const e = D.empresa || {}; const l = D.legal || {};
    const items = [];
    const it = (ic, t, v) => `<li><div class="icono-caja">${icon(ic)}</div><div><b>${t}</b>${v}</div></li>`;
    const wa = waLink(msgBase());
    if (wa) items.push(it('message-circle', 'WhatsApp', `<a href="${esc(wa)}" target="_blank" rel="noopener">${esc(e.whatsappVisible || 'Escríbenos por WhatsApp')}</a>`));
    else items.push(`<li>${pend('empresa.whatsapp')}</li>`);
    items.push(e.telefono ? it('phone', 'Teléfono', `<a href="tel:${esc(String(e.telefono).replace(/[^\d+]/g, ''))}">${esc(e.telefono)}</a>`) : `<li>${pend('empresa.telefono')}</li>`);
    items.push(e.correo ? it('mail', 'Correo', `<a href="mailto:${esc(e.correo)}">${esc(e.correo)}</a>`) : `<li>${pend('empresa.correo')}</li>`);
    items.push(e.direccion ? it('map-pin', 'Dirección', `${esc(e.direccion)}${e.ciudad ? ', ' + esc(e.ciudad) : ''}`) : `<li>${pend('empresa.direccion')}</li>`);
    items.push(e.horario ? it('clock', 'Horario', esc(e.horario)) : `<li>${pend('empresa.horario')}</li>`);
    $('#c-datos').innerHTML = items.join('');
    const r = htmlRedes(true);
    $('#c-redes').innerHTML = r ? `<h2 class="h3">Síguenos</h2>${r}` : ['facebook', 'instagram', 'tiktok', 'youtube'].map((k) => pend('redes.' + k)).join('');
    $('#c-mapa').innerHTML = e.mapaUrl
      ? `<div class="tarjeta tarjeta--plana" style="padding:0;overflow:hidden"><iframe title="Mapa de ${esc(nombre())}" src="${esc(e.mapaUrl)}" width="100%" height="320" style="border:0;display:block" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>`
      : pend('empresa.mapaUrl');
    // consentimiento
    const pol = l.politicaDatosUrl ? `<a href="${esc(l.politicaDatosUrl)}" target="_blank" rel="noopener">política de tratamiento de datos personales</a>` : 'política de tratamiento de datos personales';
    $('#consent-texto').innerHTML = `Autorizo el tratamiento de mis datos personales para que me contacten sobre esta solicitud, según la ${pol} (Ley 1581 de 2012).`;
    if (!l.politicaDatosUrl) $('#consent-pend').innerHTML = pend('legal.politicaDatosUrl');
    // barrios
    const dl = $('#lista-barrios');
    if (dl) dl.innerHTML = (D.zonas || []).flatMap((z) => [z.nombre].concat(z.barrios || [])).filter((v, i, a) => v && a.indexOf(v) === i).map((v) => `<option value="${esc(v)}">`).join('');
    // asunto por URL
    const p = new URLSearchParams(location.search);
    const asunto = p.get('asunto'); if (asunto) { const s = $('#f-asunto'); if ([...s.options].some((o) => o.value === asunto)) s.value = asunto; }
    if (p.get('enviado') === '1') mostrarAviso('ok');
    iniciarFormulario();
  };

  function mostrarAviso(tipo) {
    const a = $('#f-aviso'); if (!a) return;
    a.className = 'aviso-form ' + (tipo === 'ok' ? 'aviso-form--ok' : 'aviso-form--mal');
    a.setAttribute('role', 'status'); a.tabIndex = -1;
    a.innerHTML = tipo === 'ok'
      ? '<strong>¡Recibido!</strong> Gracias por escribirnos. Revisaremos tu mensaje y te contactaremos pronto.'
      : '<strong>No pudimos enviar tu mensaje.</strong> Revisa tu conexión e inténtalo de nuevo. Si sigue fallando, escríbenos por WhatsApp o por correo.';
    a.hidden = false; a.focus({ preventScroll: false });
  }

  function iniciarFormulario() {
    const form = $('#formulario'); if (!form) return;
    const reglas = [
      ['nombre', (v) => v.trim().length >= 3, 'Escribe tu nombre completo.'],
      ['telefono', (v) => v.replace(/\D/g, '').length >= 7, 'Escribe un teléfono válido, con al menos 7 números.'],
      ['correo', (v) => v === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v), 'Revisa el correo: debe tener la forma nombre@dominio.com.'],
      ['asunto', (v) => v !== '', 'Elige si es una solicitud, queja o sugerencia.'],
      ['mensaje', (v) => v.trim().length >= 10, 'Cuéntanos un poco más (mínimo 10 letras).'],
    ];
    const err = (campo, txt) => {
      const c = form.elements[campo]; const id = 'err-' + campo; let e = document.getElementById(id);
      if (!txt) { if (e) e.remove(); c.removeAttribute('aria-invalid'); return; }
      if (!e) { e = document.createElement('div'); e.id = id; e.className = 'error'; c.insertAdjacentElement('afterend', e); }
      e.textContent = txt; c.setAttribute('aria-invalid', 'true'); c.setAttribute('aria-describedby', id);
    };
    reglas.forEach(([c, ok, txt]) => form.elements[c].addEventListener('blur', () => err(c, ok(form.elements[c].value) ? '' : txt)));
    form.addEventListener('submit', async (ev) => {
      ev.preventDefault();
      let primero = null;
      reglas.forEach(([c, ok, txt]) => { const bien = ok(form.elements[c].value); err(c, bien ? '' : txt); if (!bien && !primero) primero = form.elements[c]; });
      if (!form.elements.consentimiento.checked) { err('consentimiento', 'Necesitamos tu autorización para poder contactarte.'); if (!primero) primero = form.elements.consentimiento; } else err('consentimiento', '');
      if (primero) { primero.focus(); return; }
      const btn = $('button[type=submit]', form); const txt = btn.querySelector('span').textContent;
      btn.disabled = true; btn.querySelector('span').textContent = 'Enviando…';
      try {
        const body = new URLSearchParams(new FormData(form)).toString();
        const r = await fetch('/', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body });
        if (!r.ok) throw new Error('HTTP ' + r.status);
        form.reset(); mostrarAviso('ok');
      } catch (e) { mostrarAviso('mal'); }
      btn.disabled = false; btn.querySelector('span').textContent = txt;
    });
  }

  /* ---------- Animaciones ---------- */
  const sinMovimiento = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let io;
  function observarReveal() {
    if (!('IntersectionObserver' in window) || sinMovimiento) { $$('.reveal').forEach((e) => e.classList.add('visto')); activarCuentas(true); return; }
    if (!io) {
      io = new IntersectionObserver((entradas) => entradas.forEach((en) => {
        if (!en.isIntersecting) return;
        en.target.classList.add('visto'); io.unobserve(en.target);
        $$('[data-cuenta]', en.target).forEach(contar);
        if (en.target.matches('[data-cuenta]')) contar(en.target);
      }), { threshold: 0.15, rootMargin: '0px 0px -6% 0px' });
    }
    $$('.reveal:not(.visto)').forEach((e) => io.observe(e));
  }
  function contar(el) {
    if (el.dataset.hecho) return; el.dataset.hecho = '1';
    const fin = parseFloat(el.dataset.cuenta); const dec = parseInt(el.dataset.dec || '0', 10); const sep = el.dataset.sep !== '0';
    const fmt = (v) => sep ? nf(v, dec) : String(Math.round(v));
    if (sinMovimiento) { el.textContent = fmt(fin); return; }
    const t0 = performance.now(); const dur = 1600;
    const paso = (t) => { const p = Math.min(1, (t - t0) / dur); const e = 1 - Math.pow(1 - p, 3); el.textContent = fmt(fin * e); if (p < 1) requestAnimationFrame(paso); else el.textContent = fmt(fin); };
    requestAnimationFrame(paso);
  }
  function activarCuentas(directo) { if (directo) $$('[data-cuenta]').forEach(contar); }
  function animarBarras() {
    const caja = $('#barras-js'); if (!caja) return;
    const poner = () => { $$('.rel', caja).forEach((b, i) => { setTimeout(() => { b.style.height = b.dataset.h + '%'; }, sinMovimiento ? 0 : i * 60); }); caja.classList.add('dibujada'); };
    if (!('IntersectionObserver' in window) || sinMovimiento) { poner(); return; }
    const o = new IntersectionObserver((en) => { if (en[0].isIntersecting) { poner(); o.disconnect(); } }, { threshold: 0.3 });
    o.observe(caja);
  }

  /* ---------- Modo administrador ---------- */
  function modoAdmin() {
    const p = new URLSearchParams(location.search).get('admin');
    if (p === '1') store.set('admin', '1'); else if (p === '0') store.del('admin');
    const on = store.get('admin') === '1';
    document.body.classList.toggle('es-admin', on);
    return on;
  }
  function barraAdmin() {
    const todos = faltantes();
    const li = todos.map((k) => `<li><strong>${esc(CAMPOS[k][0])}</strong> <small>(${esc(CAMPOS[k][1])})</small></li>`).join('');
    document.body.insertAdjacentHTML('beforeend', `
      <div class="admin-lista" id="admin-lista" role="dialog" aria-label="Información pendiente"><h2>Información pendiente (${todos.length})</h2>${todos.length ? `<ul>${li}</ul>` : '<p>No falta nada.</p>'}<p><small>Edita estos datos en <code>datos.json</code>. Los recuadros solo se ven en modo administrador.</small></p></div>
      <div class="admin-barra"><span>Modo administrador: los recuadros «Información pendiente» solo los ves tú.</span>
        <button type="button" id="admin-ver" aria-expanded="false" aria-controls="admin-lista">Ver pendientes (${todos.length})</button>
        <a href="?admin=0">Salir del modo administrador</a></div>`);
    $('#admin-ver').addEventListener('click', (ev) => { const l = $('#admin-lista'); const a = l.classList.toggle('abierta'); ev.currentTarget.setAttribute('aria-expanded', a); });
  }

  /* ---------- Arranque ---------- */
  async function cargarDatos() {
    try {
      const r = await fetch('datos.json', { cache: 'no-cache' });
      if (!r.ok) throw new Error(r.status);
      return await r.json();
    } catch (e) {
      console.warn('No se pudo cargar datos.json (¿abriste el archivo sin servidor?).', e);
      return {};
    }
  }

  async function iniciar() {
    ROOT.classList.add('con-js');
    aplicarPrefs();
    D = await cargarDatos();
    const pagina = document.body.dataset.page;
    const admin = modoAdmin();
    renderCabecera(pagina);
    hidratar();
    enlazarRecoleccion();
    if (paginas[pagina]) paginas[pagina]();
    renderPie(pagina);
    renderWaFlotante();
    if (admin) barraAdmin();
    // título con el nombre de la empresa
    const h1 = $('h1'); if (h1 && pagina !== 'inicio') document.title = `${h1.textContent.trim()} · ${nombre()}`;
    observarReveal();
    $$('.reveal').forEach((el, i) => { if (!el.style.getPropertyValue('--d')) el.style.setProperty('--d', ((i % 4) * 0.07) + 's'); });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', iniciar); else iniciar();
})();
