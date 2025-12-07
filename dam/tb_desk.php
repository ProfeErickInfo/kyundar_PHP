 <section>
  <!-- Tarjetas de Resumen Financiero -->
  <div class="row mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 4px solid #3b82f6;">
        <div class="card-body text-center">
          <div class="mb-2">
            <i class="fas fa-coins fa-2x" style="color: #3b82f6;"></i>
          </div>
          <h6 class="card-title" style="color: #1e293b; font-weight: 600;">Aporte Mensual</h6>
          <small style="color: #64748b;"><? echo $nomMes;?></small>
          <h5 class="mt-2 mb-0" style="color: #0f172a; font-weight: 700;"><?echo $subMes->formatCurrency($SumaMes, "COP");?></h5>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #1e40af;">
        <div class="card-body text-center">
          <div class="mb-2">
            <i class="fas fa-minus-circle fa-2x" style="color: #1e40af;"></i>
          </div>
          <h6 class="card-title" style="color: #1e293b; font-weight: 600;">Gastos</h6>
          <small style="color: #64748b;"><? echo $nomMes;?></small>
          <h5 class="mt-2 mb-0" style="color: #0f172a; font-weight: 700;">$ 500,000</h5>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 4px solid #2563eb;">
        <div class="card-body text-center">
          <div class="mb-2">
            <i class="fas fa-user-plus fa-2x" style="color: #2563eb;"></i>
          </div>
          <h6 class="card-title" style="color: #1e293b; font-weight: 600;">Inscripciones</h6>
          <small style="color: #64748b;"><? echo $nomMes;?></small>
          <h5 class="mt-2 mb-0" style="color: #0f172a; font-weight: 700;">$ 1,000,000</h5>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #60a5fa;">
        <div class="card-body text-center">
          <div class="mb-2">
            <i class="fas fa-chart-pie fa-2x" style="color: #60a5fa;"></i>
          </div>
          <h6 class="card-title" style="color: #1e293b; font-weight: 600;">Otros Ingresos</h6>
          <small style="color: #64748b;"><? echo $nomMes;?></small>
          <h5 class="mt-2 mb-0" style="color: #0f172a; font-weight: 700;">$ 1,500,000</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Tarjetas de Detalle Financiero -->
  <div class="row"> 
    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-top: 4px solid #3b82f6;">
        <div class="card-header text-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #e2e8f0;">
          <i class="fas fa-coins me-2" style="color: #3b82f6;"></i>
          <strong style="color: #1e293b;">Aporte Mensual</strong>
          <br><small style="color: #64748b;">Detalle de pagos</small>
        </div>
        <div class="card-body" style="height: 300px; overflow-y: auto; padding: 15px; background-color: #fafbfc;">
          <?php include('modDam/modFinan/ejec/ListPago.php'); ?>
        </div>
        <div class="card-footer text-center" style="background-color: #f1f5f9; border-top: 1px solid #e2e8f0;">
          <button class="btn btn-sm" style="background-color: #3b82f6; color: white; border: none;" onclick="window.open('#', '_blank')">
            <i class="fas fa-external-link-alt me-1"></i>Ver Informe
          </button>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-top: 4px solid #1e40af;">
        <div class="card-header text-center" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-bottom: 1px solid #cbd5e1;">
          <i class="fas fa-minus-circle me-2" style="color: #1e40af;"></i>
          <strong style="color: #1e293b;">Gastos/Egresos</strong>
          <br><small style="color: #64748b;">Detalle de gastos</small>
        </div>
        <div class="card-body" style="height: 300px; overflow-y: auto; padding: 15px; background-color: #fafbfc;">
          <?php include('modDam/mod_consultas/scrin/ListGastos.php'); ?>
        </div>
        <div class="card-footer text-center" style="background-color: #f1f5f9; border-top: 1px solid #cbd5e1;">
          <button class="btn btn-sm" style="background-color: #1e40af; color: white; border: none;" onclick="window.open('#', '_blank')">
            <i class="fas fa-external-link-alt me-1"></i>Ver Informe
          </button>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-top: 4px solid #2563eb;">
        <div class="card-header text-center" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid #e2e8f0;">
          <i class="fas fa-user-plus me-2" style="color: #2563eb;"></i>
          <strong style="color: #1e293b;">Inscripciones</strong>
          <br><small style="color: #64748b;">Nuevos miembros</small>
        </div>
        <div class="card-body" style="height: 300px; overflow-y: auto; padding: 15px; background-color: #fafbfc;">
          <?php include('modDam/mod_consultas/scrin/ListInscripciones.php'); ?>
        </div>
        <div class="card-footer text-center" style="background-color: #f1f5f9; border-top: 1px solid #e2e8f0;">
          <button class="btn btn-sm" style="background-color: #2563eb; color: white; border: none;" onclick="window.open('#', '_blank')">
            <i class="fas fa-external-link-alt me-1"></i>Ver Informe
          </button>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-top: 4px solid #60a5fa;">
        <div class="card-header text-center" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-bottom: 1px solid #cbd5e1;">
          <i class="fas fa-chart-pie me-2" style="color: #60a5fa;"></i>
          <strong style="color: #1e293b;">Otros Ingresos</strong>
          <br><small style="color: #64748b;">Ingresos adicionales</small>
        </div>
        <div class="card-body" style="height: 300px; overflow-y: auto; padding: 15px; background-color: #fafbfc;">
          <?php include('modDam/mod_consultas/scrin/ListVentas.php'); ?>
        </div>
        <div class="card-footer text-center" style="background-color: #f1f5f9; border-top: 1px solid #cbd5e1;">
          <button class="btn btn-sm" style="background-color: #60a5fa; color: white; border: none;" onclick="window.open('#', '_blank')">
            <i class="fas fa-external-link-alt me-1"></i>Ver Informe
          </button>
        </div>
      </div>
    </div>
  </div><!-- /.row -->
</section>