<!-- public/components/categorias.html -->
<!-- Fragmento para inyectar dentro de tu <div id="main-content"> -->
<link rel="stylesheet" href="modDam/modFinan/libs/clases.css">

<div class="panel-categorias" id="panel-categorias" aria-labelledby="pc-title" role="region">
  <header class="pc-header">
    <div class="pc-header-left">
     <img src="modDam/modFinan/imgs/small-logo.svg" alt="Logo" class="pc-logo" />
      <h1 id="pc-title" class="pc-title">Gestión de Categorías de Egresos</h1>
    </div>
    <div class="pc-header-right">
      <div class="pc-search">
        <input id="pc-search-input" type="search" placeholder="Buscar categoría..." aria-label="Buscar categoría">
        <button id="pc-new-cat-btn" class="btn primary" aria-haspopup="true">+ Nueva categoría</button>
      </div>
    </div>
  </header>

  <main class="pc-main single-component" aria-labelledby="pc-main-title">
    <!-- Left: form -->
    <section class="pc-left" aria-labelledby="form-title">
      <div class="card card-form" id="card-form">
        <div class="card-title">
          <h2 id="form-title">Nueva categoría</h2>
          <div class="card-actions">
            <button id="pc-cancel-edit" class="btn ghost" hidden>Cancelar</button>
          </div>
        </div>

        <form id="categoria-form" novalidate>
          <div class="field">
            <label for="cat-nombre">Nombre de la categoría</label>
            <input id="cat-nombre" name="nombre" type="text" placeholder="Ej: Transporte" required>
            <div class="field-error" id="err-nombre" aria-live="assertive"></div>
          </div>

          <div class="field">
            <label for="cat-descripcion">Descripción (opcional)</label>
            <textarea id="cat-descripcion" name="descripcion" rows="3" placeholder="Descripción corta"></textarea>
          </div>

          <div class="form-actions">
            <button id="cat-save" class="btn primary" type="submit">Guardar categoría</button>
            <button id="cat-reset" class="btn ghost" type="button">Limpiar</button>
          </div>
        </form>
      </div>
    </section>

    <!-- Right: lista y búsqueda -->
    <section class="pc-right" aria-labelledby="list-title">
      <div class="card card-list" id="card-categorias">
        <div class="card-title">
          <h3 id="list-title">Categorías</h3>
          <div class="card-actions">
            <small id="count-categorias">0 categorías</small>
          </div>
        </div>

        <div class="card-search" style="margin-bottom:12px">
          <input id="list-search" type="search" placeholder="Buscar por nombre o descripción..." aria-label="Buscar en categorías">
        </div>

        <div id="lista-categorias" class="list" role="list">
          <!-- filas inyectadas por JS -->
        </div>

        <div class="list-footer" style="margin-top:12px">
          <small class="muted">Puedes editar o eliminar una categoría desde las acciones.</small>
        </div>
      </div>
    </section>
  </main>

  <!-- Toasts / notifications -->
  <div id="pc-toasts" class="toasts" aria-live="polite" aria-atomic="true"></div>
</div>

<script src="modDam/modFinan/libs/libro.js" defer></script>