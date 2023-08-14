<!-- Left side column. contains the sidebar -->
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
     
      <div class="sidebar-brand d-none d-md-flex">
        <div class="sidebar-brand-full"  alt="CoreUI Logo">
        <img decoding="async" src="{{asset ('img/logo.png')}}"  width="200" height="90" >

</div>
        <div class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
        <img decoding="async" src="https://i0.wp.com/uecec.edu.ec/wp-content/uploads/2020/09/cropped-logo-cec-por2.png?fit=32%2C32&#038;ssl=1" >
</div>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        
        <li class="nav-title">Navegacion</li>
        <li class="nav-item {{ ! Route:: is('home') ?: 'active' }}"><a class="nav-link" href="{{ route('home') }}">
        <svg class="nav-icon">
              <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speedometer ') }}"></use>
        </svg>
         Inicio</a></li>

         <li class="nav-item {{ ! Route:: is('estudiante.index') ?: 'active' }}"><a class="nav-link" href="{{ route('estudiante.index') }}">
        <svg class="nav-icon">
              <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil ') }}"></use>
        </svg>
         Registro estudiantes</a></li>

         <li class="nav-item {{ ! Route:: is('insumo.index') ?: 'active' }}"><a class="nav-link" href="{{ route('insumo.index') }}">
            <svg class="nav-icon">
              <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cursor ') }}"></use>
            </svg>
         Registro insumos</a></li>

         <li class="nav-item {{ ! Route:: is('informe_medico.index') ?: 'active' }}"><a class="nav-link" href="{{ route('informe_medico.index') }}">
            <svg class="nav-icon">
              <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-notes ') }}"></use>
            </svg>
         Registro enfermeria</a></li>

         <li class="nav-item {{ ! Route:: is('user.index') ?: 'active' }}"><a class="nav-link" href="{{ route('user.index') }}">
            <svg class="nav-icon">
              <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-user ') }}"></use>
            </svg>
          Usuarios</a></li>

       
      </ul>
      <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>

