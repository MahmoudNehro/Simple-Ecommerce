  <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
      <div class="navbar-wrapper">
          <div class="navbar-container content">
              <div class="navbar-collapse" id="navbar-mobile">
                  <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">

                  </div>
                  <ul class="nav navbar-nav float-right">

                      <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                  data-feather="maximize"></i></a></li>

                      <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                              href="#" data-toggle="dropdown"><i data-feather="bell"></i><span
                                  class="badge badge-pill badge-primary badge-up"
                                  id="notification-count">{{ $unreadNotifications?->count() ?? 0}}</span></a>
                          <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right"
                              style="overflow-y: auto !important; max-height: 300px;" id="notification-container">
                              <li class="dropdown-menu-header" id="notification-header">
                                  <div class="dropdown-header m-0 p-2">
                                      <h3 class="white">
                                          <span id="notification-count-label"> {{ $unreadNotifications?->count() ?? 0 }}</span>
                                          New
                                      </h3><span class="notification-title">App
                                          Notifications</span>
                                  </div>
                              </li>
                              @if ($unreadNotifications)

                                  @foreach ($unreadNotifications as $notification)
                                      <li class="media-list" id="{{ $notification->id }}">
                                          <a class="d-flex justify-content-between" href="javascript:void(0)"
                                              onclick="readNotification({{ $notification }})">
                                              <div class="media d-flex align-items-start">
                                                  <div class="media-body">
                                                      <h6 class="primary media-heading">
                                                          {{ data_get($notification, 'data.title') }}
                                                          {{ data_get($notification, 'data.order_id') }}</h6><small
                                                          class="notification-text">
                                                          {{ data_get($notification, 'data.body') }} </small>
                                                  </div><small>
                                                      <time class="media-meta"
                                                          datetime="2015-06-11T18:29:20+08:00">{{ $notification->created_at?->diffForHumans() }}</time></small>
                                              </div>
                                          </a>
                                      </li>
                                  @endforeach
                              @endif


                              <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center"
                                      href="{{ route('admin.mark-all-as-read') }}">Read all notifications</a></li>
                          </ul>
                      </li>
                      <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                              href="#" data-toggle="dropdown">
                              <div class="user-nav d-sm-flex d-none"><span
                                      class="user-name text-bold-600">{{ auth()->user()?->name }}</span></div>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right">
                              <div class="dropdown-divider">
                              </div>
                              <form action="{{ route('admin.logout') }}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="dropdown-item"><i data-feather="power"></i>
                                      Logout
                                  </button>
                              </form>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </nav>
