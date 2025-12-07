// public/js/categorias.js
// Integración fetch() con API real para gestión de categorías.
// Espera los endpoints REST:
// GET    /api/categorias           -> [{id,nombre,descripcion}, ...]
// POST   /api/categorias           -> 201 {id, nombre, descripcion}
// PUT    /api/categorias/:id       -> 200 {id, nombre, descripcion}
// DELETE /api/categorias/:id       -> 204
//
// Ajusta API_BASE si tus endpoints usan otro prefijo.

(() => {
  const API_BASE = '/api'; // cambiar si tu API está en otro prefijo
  let categorias = [];
  let editingId = null;

  // DOM helpers
  const $ = sel => document.querySelector(sel);
  const $$ = sel => Array.from(document.querySelectorAll(sel));

  document.addEventListener('DOMContentLoaded', init);

  function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) return meta.getAttribute('content');
    if (window.__CSRF_TOKEN__) return window.__CSRF_TOKEN__;
    return null;
  }

  async function apiFetch(path, opts = {}) {
    const headers = opts.headers || {};
    if (!headers['Accept']) headers['Accept'] = 'application/json';
    if (opts.body && !(opts.body instanceof FormData)) {
      headers['Content-Type'] = 'application/json';
    }
    const csrf = getCsrfToken();
    if (csrf) headers['X-CSRF-Token'] = csrf;

    try {
      const res = await fetch(API_BASE + path, { credentials: 'same-origin', ...opts, headers });
      // If no content
      if (res.status === 204) return null;
      const contentType = res.headers.get('Content-Type') || '';
      if (contentType.includes('application/json')) {
        const data = await res.json();
        if (!res.ok) throw { status: res.status, data };
        return data;
      } else {
        // fallback to text
        const txt = await res.text();
        if (!res.ok) throw { status: res.status, data: txt };
        return txt;
      }
    } catch (err) {
      // Normalize error
      if (err instanceof TypeError) throw { message: 'Network error or CORS issue', original: err };
      throw err;
    }
  }

  async function init(){
    bindEvents();
    await loadCategorias();
    renderList();
  }

  function bindEvents(){
    $('#categoria-form').addEventListener('submit', onSubmit);
    $('#cat-reset').addEventListener('click', resetForm);
    $('#pc-new-cat-btn').addEventListener('click', () => { scrollToForm(); });
    $('#list-search').addEventListener('input', renderList);
    $('#pc-search-input').addEventListener('input', (e) => {
      $('#list-search').value = e.target.value;
      renderList();
    });
    $('#pc-cancel-edit').addEventListener('click', resetForm);
  }

  async function loadCategorias(){
    try {
      const data = await apiFetch('/categorias', { method: 'GET' });
      if (Array.isArray(data)) categorias = data;
      else categorias = [];
    } catch (err) {
      console.error('Error cargando categorías', err);
      showToast('No se pudieron cargar las categorías', 'error');
      categorias = [];
    }
  }

  async function onSubmit(ev){
    ev.preventDefault();
    const nameInput = $('#cat-nombre');
    const descInput = $('#cat-descripcion');
    const errNombre = $('#err-nombre');
    errNombre.textContent = '';

    const nombre = nameInput.value.trim();
    const descripcion = descInput.value.trim();

    if (!nombre) {
      errNombre.textContent = 'El nombre es obligatorio.';
      nameInput.focus();
      return;
    }

    try {
      if (editingId) {
        // Update
        const payload = { nombre, descripcion };
        const updated = await apiFetch(`/categorias/${editingId}`, {
          method: 'PUT',
          body: JSON.stringify(payload),
        });
        // update local list
        categorias = categorias.map(c => c.id === editingId ? updated : c);
        showToast('Categoría actualizada', 'success');
      } else {
        // Create
        const payload = { nombre, descripcion };
        const created = await apiFetch('/categorias', {
          method: 'POST',
          body: JSON.stringify(payload),
        });
        // prepend created
        categorias.unshift(created);
        showToast('Categoría creada', 'success');
      }
      resetForm();
      renderList();
    } catch (err) {
      console.error('Error guardando categoría', err);
      const msg = err && err.data && err.data.message ? err.data.message : (err.message || 'Error guardando');
      showToast(msg, 'error');
    }
  }

  function resetForm(){
    editingId = null;
    $('#form-title').textContent = 'Nueva categoría';
    $('#pc-cancel-edit').hidden = true;
    $('#categoria-form').reset();
    $('#err-nombre').textContent = '';
  }

  function scrollToForm(){
    $('#card-form').scrollIntoView({behavior:'smooth', block:'center'});
    $('#cat-nombre').focus();
  }

  function renderList(){
    const container = $('#lista-categorias');
    const count = $('#count-categorias');
    const q = ($('#list-search').value || '').toLowerCase().trim();

    container.innerHTML = '';

    const filtered = categorias.filter(c => {
      if (!q) return true;
      return (c.nombre || '').toLowerCase().includes(q) || (c.descripcion || '').toLowerCase().includes(q);
    });

    if (filtered.length === 0) {
      container.innerHTML = `<div class="empty muted">No se encontraron categorías. Usa el formulario para crear la primera.</div>`;
      count.textContent = '0 categorías';
      return;
    }

    filtered.forEach(c => {
      const row = document.createElement('div');
      row.className = 'row';
      row.innerHTML = `
        <div class="left">
          <div>
            <div><strong>${escapeHtml(c.nombre)}</strong></div>
            <div class="meta">${escapeHtml(c.descripcion || '')}</div>
          </div>
        </div>
        <div class="actions" data-id="${c.id}">
          <button class="edit" title="Editar">✏️</button>
          <button class="del" title="Eliminar">🗑️</button>
        </div>
      `;
      row.querySelector('.actions').addEventListener('click', (ev) => {
        const id = Number(ev.currentTarget.dataset.id);
        if (ev.target.classList.contains('edit')) startEdit(id);
        else if (ev.target.classList.contains('del')) deleteCategory(id);
      });
      container.appendChild(row);
    });

    count.textContent = `${filtered.length} categorías`;
  }

  function startEdit(id){
    const c = categorias.find(x => x.id === id);
    if (!c) return;
    editingId = id;
    $('#form-title').textContent = 'Editar categoría';
    $('#pc-cancel-edit').hidden = false;
    $('#cat-nombre').value = c.nombre;
    $('#cat-descripcion').value = c.descripcion || '';
    scrollToForm();
  }

  async function deleteCategory(id){
    const c = categorias.find(x => x.id === id);
    if (!c) return;
    if (!confirm(`¿Eliminar '${c.nombre}'? Esta acción no se puede deshacer.`)) return;
    try {
      await apiFetch(`/categorias/${id}`, { method: 'DELETE' });
      categorias = categorias.filter(x => x.id !== id);
      renderList();
      showToast('Categoría eliminada', 'success');
    } catch (err) {
      console.error('Error eliminando', err);
      const msg = err && err.data && err.data.message ? err.data.message : (err.message || 'Error eliminando');
      showToast(msg, 'error');
    }
  }

  function showToast(text, type='success'){
    const toasts = $('#pc-toasts');
    const div = document.createElement('div');
    div.className = `toast ${type}`;
    div.textContent = text;
    toasts.appendChild(div);
    setTimeout(()=> div.remove(), 3000);
  }

  function escapeHtml(s){ if (!s && s !== 0) return ''; return String(s).replace(/[&<>"']/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m]; }); }
})();