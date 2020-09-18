<div class="box box-widget widget-user">
    <div class="widget-user-header bg-aqua-active">
      <h3 class="widget-user-username text-center">@yield('nombre-probetas')</h3>
      <h1 class="widget-user-desc text-center">@yield('cantidad-total-probetas')</h1>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-4 border-right">
          <div class="description-block">
            <span class="description-text">CHICAS</span>
            <h2 class="description-header">@yield('cantidad-probetas-chicas')</h2>
          </div>
        </div>
        <div class="col-sm-4 border-right">
          <div class="description-block">
          <span class="description-text">MEDIANAS</span>
            <h2 class="description-header">@yield('cantidad-probetas-medianas')</h2>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="description-block">
            <span class="description-text">GRANDES</span>
            <h2 class="description-header">@yield('cantidad-probetas-grandes')</h2>
          </div>
        </div>
      </div>
    </div>
  </div>