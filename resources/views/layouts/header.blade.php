<!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown dropdown-large">
                                    
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count" id="total_notifikasi"></span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifikasi</p>
                                            {{-- <p class="msg-header-clear ms-auto">Marks all as read</p> --}}
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                            <a class="dropdown-item" href="{{route('permintaan.indexapprove')}}">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify bg-light-primary text-primary"><i class="bx bx-archive"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        {{-- <h6 class="msg-name">Request Order<span class="msg-time float-end">14 Sec
                                                    ago</span></h6> --}}
                                                        <h6 class="msg-name">Request Order</h6>
                                                        <p class="msg-info"><span id="notif_jumlah_belum_approve"></span> Permintaan belum disetujui</p>
                                                    </div>
                                                </div>
                                            </a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <div class="dropdown-menu dropdown-menu-end">
                                    
                                    <div class="header-message-list">
                                        
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{asset('assets/images/avatars/admin.jpg')}}" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{Auth::user()->name}}</p>
                                {{-- <p class="designattion mb-0">{{Auth::user()->role}}</p> --}}
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li> --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class='bx bx-log-out-circle'></i>
                                        {{ __('Logout') }}
                                    </a>

                                    
                                {{-- <a class="dropdown-item" href="{{ url('authentication-signin') }}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a> --}}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                {{-- <a class="dropdown-item" href="javascript:;"><i class='bx bx-log-out-circle'></i><span>Logout</span></a> --}}
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->