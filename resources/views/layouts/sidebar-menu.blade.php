<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="list" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/personas" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Personas
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/deligencias" class="nav-link">
          <i class="nav-icon fas fa-th-list"></i>
          <p>
            Diligencias
          </p>
        </router-link>
      </li>
      
      <li class="nav-item">
        <router-link to="/reportes" class="nav-link">
          <i class="nav-icon fas fa-file-invoice"></i>
          <p>
            Reportes
          </p>
        </router-link>
      </li>

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-users-cog yellow"></i>
          <p>
            Admin
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/users" class="nav-link">
                <i class="fas fa-user nav-icon orange"></i>
                <p>Users</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/tipo-cuaderno" class="nav-link">
              <i class="fas fa-book-medical nav-icon orange"></i>
                <p>Tipo de Cuaderno</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/grupo-aranceles" class="nav-link">
                <i class="fas fa-money-check-alt nav-icon orange"></i>
                <p>Grupos de Aranceles</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/tipo-arancel" class="nav-link">
                <i class="fas fa-money-check-alt nav-icon orange"></i>
                <p>Tipos de Arancel</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/encargos" class="nav-link">
                <i class="fas fa-edit nav-icon orange"></i>
                <p>Encargos</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/materias" class="nav-link">
                <i class="fas fa-file-alt nav-icon orange"></i>
                <p>Materias</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/tribunales" class="nav-link">
                <i class="fas fa-university nav-icon orange"></i>
                <p>Tribunales</p>
              </router-link>
            </li>
          </ul>
        </li>
      @endcan

      

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">         
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>

      @endcan
      
      

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>