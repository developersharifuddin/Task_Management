  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light py-2 px-4 border-top">
      <!-- Left navbar links -->
      <ul class="navbar-nav py-1">
          <li class="nav-item px-0">
              <a class="nav-link px-0" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="/" class="nav-link goweb" target="_blank"><i class="fa-solid fa-earth-americas"></i></a>
          </li>
      </ul>
      <!-- Left navbar links -->
      <ul class="navbar-nav py-1 mx-auto">
          <li class="nav-item">
              <div class="input-group bg-transparent">
                  <label class="input-group-text bg-transparent border-0" for="inputGroupSelect01">Store:</label>
                  <select class="form-select form-control" id="inputGroupSelect01" style="min-width:250px">
                      <option selected value="1">Main Store</option>
                      <option value="2">Sub-Store</option>
                  </select>
              </div>
          </li>
      </ul>


      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto align-items-center">
          <!-- Messages Dropdown Menu -->
          {{-- <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-comments"></i>
                  <span class="badge badge-danger navbar-badge">3</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="../backend/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  Brad Diesel
                                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                              </h3>
                              <p class="text-sm">Call me whenever you can...</p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="../backend/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  John Pierce
                                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                              </h3>
                              <p class="text-sm">I got your message bro</p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                          <img src="../backend/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                          <div class="media-body">
                              <h3 class="dropdown-item-title">
                                  Nora Silvester
                                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                              </h3>
                              <p class="text-sm">The subject goes here</p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                      </div>
                      <!-- Message End -->
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
              </div>
          </li> --}}
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell text-secoundary"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-users mr-2"></i> 8 friend requests
                      <span class="float-right text-muted text-sm">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> 3 new reports
                      <span class="float-right text-muted text-sm">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fa-solid fa-expand"></i>
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                  <i class="fa-solid fa-gear"></i>
              </a>
          </li>


          <div class="btn-group">
              <button type="button" class="btn border" data-toggle="dropdown" data-display="static" aria-expanded="false">
                  @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                  <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                  @else
                  <span class="inline-flex rounded-md flex d-flex">
                      <img class="w-12 h-12 rounded-full object-cover" height="45px" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                      <div class="ml-3 leading-tight">
                          <div class="text-gray-900">{{ Auth::user()->name }}</div>
                          <div class="text-gray-700 text-sm float-left">{{ Auth::user()->role }}</div>
                      </div>
                      <span class="fa fa-angle-down ml-4 my-auto"></span>
                  </span>
                  @endif
              </button>
              <ul class="dropdown-menu user float-right">
                  <li>

                      <!-- Account Management -->
                      <div class="block px-4 py-2 text-xs text-gray-400">
                          {{ __('Manage Account') }}
                      </div>

                  </li>
                  <li><button class="dropdown-item" type="button">
                          <x-dropdown-link href="{{ route('profile.show') }}">
                              {{ __('Profile') }}
                          </x-dropdown-link>
                      </button></li>
                  <li>
                      <button class="dropdown-item px-auto" type="button">
                          <div class="border-top border-gray-200"></div>
                          @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                          <x-dropdown-link href="{{ route('api-tokens.index') }}">
                              {{ __('API Tokens') }}
                          </x-dropdown-link>
                          @endif

                          <!-- Authentication -->
                          {{-- <form method="POST" action="{{ route('logout') }}" x-data>
                          @csrf
                          <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                              {{ __('Log Out') }}
                          </x-dropdown-link>
                          </form> --}}
                          <form action="{{ route('admin.logout') }}" method="POST">
                              @csrf
                              <button class="btn btn-transparent border-none ml-4" type="submit">Logout</button>
                          </form>
                      </button>
                  </li>
              </ul>
          </div>


      </ul>
  </nav>
  <!-- /.navbar -->
