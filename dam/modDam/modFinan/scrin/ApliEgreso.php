<!-- public/components/egreso_form.html -->
<!-- Fragmento HTML para inyectar en el div principal: formulario para registrar un egreso.
     Espera que el select de categorías sea poblado por JS (GET /api/categorias) o por render server-side.
     Incluye campos: fecha, monto, categoría (relación), método de pago y descripción. -->

<link rel="stylesheet" href="modDam/modFinan/libs/clases.css">

<div class="panel-categorias" id="panel-egreso" aria-labelledby="eg-title" role="region">
  <header class="pc-header">
    <div class="pc-header-left">
      <img src="modDam/modFinan/imgs/small-logo.svg" alt="Logo" class="pc-logo" />
      <h1 id="eg-title" class="pc-title">Registrar Egreso</h1>
    </div>
    <div class="pc-header-right">
      <div class="pc-search">
        <input id="eg-search-input" type="search" placeholder="Buscar egresos..." aria-label="Buscar egresos">
        <a href="/egresos" class="btn ghost" title="Ir a listado de egresos">Ver registros</a>
      </div>
    </div>
  </header>

  <main class="pc-main single-component" aria-labelledby="pc-main-title">
    <section class="pc-left" aria-labelledby="form-title">
      <div class="card card-form" id="card-egreso-form">
        <div class="card-title">
          <h2 id="form-title">Nuevo egreso</h2>
        </div>

        <form id="egreso-form" novalidate method="post" action="/api/egresos">
          <!-- CSRF token placeholder (si aplica): -->
          <input type="hidden" name="csrf_token" id="csrf_token" value="">

          <div class="field">
            <label for="eg-fecha">Fecha</label>
            <input id="eg-fecha" name="fecha" type="date" required aria-required="true">
            <div class="field-error" id="err-fecha" aria-live="assertive"></div>
          </div>

          <div class="field">
            <label for="eg-monto">Monto</label>
            <input id="eg-monto" name="monto" type="number" step="0.01" min="0" required aria-required="true" placeholder="0.00">
            <div class="field-error" id="err-monto" aria-live="assertive"></div>
          </div>

          <div class="field">
            <label for="eg-categoria">Categoría</label>
            <select id="eg-categoria" name="categoria_id" required aria-required="true">
              <option value="">— Cargando categorías —</option>
              <!-- Opciones deben ser inyectadas por JS o server-side:
                   <option value="1">General</option> -->
            </select>
            <div class="field-error" id="err-categoria" aria-live="assertive"></div>
          </div>

          <div class="field">
            <label for="eg-metodo">Método de pago</label>
            <select id="eg-metodo" name="metodo_pago" >
              <option value="">— Seleccione —</option>
              <option value="Efectivo">Efectivo</option>
              <option value="Tarjeta">Tarjeta</option>
              <option value="Transferencia">Transferencia</option>
              <option value="Otro">Otro</option>
            </select>
            <div class="field-error" id="err-metodo" aria-live="assertive"></div>
          </div>

          <div class="field">
            <label for="eg-descripcion">Descripción (opcional)</label>
            <textarea id="eg-descripcion" name="descripcion" rows="4" placeholder="Detalles adicionales"></textarea>
          </div>

          <div class="form-actions">
            <button id="eg-save" class="btn primary" type="submit">Registrar egreso</button>
            <button id="eg-reset" class="btn ghost" type="button">Limpiar</button>
          </div>
        </form>

        <div id="eg-form-note" style="margin-top:12px;">
          <small class="muted">La categoría clasifica el tipo de egreso. Si no existe la categoría, créala primero en "Categorías".</small>
        </div>
      </div>
    </section>

    <section class="pc-right" aria-labelledby="recent-title">
      <div class="card card-list" id="card-recent-egresos">
        <div class="card-title">
          <h3 id="recent-title">Últimos egresos</h3>
          <div class="card-actions">
            <small id="count-egresos">0 registros</small>
          </div>
        </div>

        <div id="lista-recent-egresos" class="list" role="list">
          <!-- Opcional: filas inyectadas por JS con los últimos egresos para referencia/edit later -->
          <!-- Ejemplo fila:
          <div class="row">
            <div class="left">
              <div><strong>2025-11-16 — $100.00</strong></div>
              <div class="meta">General — Compra papelería</div>
            </div>
            <div class="actions">
              <button class="edit" title="Editar">✏️</button>
            </div>
          </div>
          -->
        </div>

        <div class="list-footer" style="margin-top:12px">
          <small class="muted">Puedes editar un registro más tarde desde la pantalla de egresos.</small>
        </div>
      </div>
    </section>
  </main>

  <div id="eg-toasts" class="toasts" aria-live="polite" aria-atomic="true"></div>
</div>

<!-- El comportamiento (poblar select de categorías, validaciones cliente, envío fetch/AJAX)
     se implementa en /js/egresos.js. -->
<script src="modDam/modFinan/libs/libros.js" defer></script>