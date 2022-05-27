<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">DEPT IT</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{route('admin.dashboard')}}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="menu-label">Menu</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-book' ></i>
                </div>
                <div class="menu-title">Master</div>
            </a>
            <ul>
                
                
                {{-- <li> <a href="#" class="has-arrow"><i class="bx bx-right-arrow-alt"></i>Network Device</a>
                    <ul>
                        <li> <a href="{{ route('networkdevice.index')}}"><i class="bx bx-right-arrow-alt"></i>Data</a>
                        </li>
                        <li> <a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Lokasi</a>
                        </li>
                    </ul>
                </li> --}}
                
                <li> <a href="{{ route('kategori.index') }}"><i class="bx bx-right-arrow-alt"></i>Kategori</a>
                </li>
                <li> <a href="{{ route('satuan.index') }}"><i class="bx bx-right-arrow-alt"></i>Unit of Material</a>
                </li>
                <li> <a href="{{ route('arealokasi.index') }}"><i class="bx bx-right-arrow-alt"></i>Area Lokasi</a>
                </li>
                @if (Auth::user()->nip == '88888888')
                <li> <a href="{{ route('sap.index') }}"><i class="bx bx-right-arrow-alt"></i>SAP Item</a>
                </li>
                @endif
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-layer-plus' ></i>
                </div>
                <div class="menu-title">Transaksi</div>
            </a>
            <ul>
                <li> <a href="{{ route('item.index') }}"><i class="bx bx-right-arrow-alt"></i>Item</a>
                </li>
                <li> <a href="{{ route('networkdevice.index') }}"><i class="bx bx-right-arrow-alt"></i>Network Device</a>
                </li>
                <li> <a href="{{ route('itemmasuk.index') }}"><i class="bx bx-right-arrow-alt"></i>Pengembalian</a>
                </li>
                <li> <a href="{{ route('itemkeluar.index') }}"><i class="bx bx-right-arrow-alt"></i>Penyerahan</a>
                </li>
                <li> <a href="{{route('itemperbaikan.index')}}"><i class="bx bx-right-arrow-alt"></i>Upgrade</a>
                </li>
                <li> <a href="{{route('kerusakan.index')}}"><i class="bx bx-right-arrow-alt"></i>Kerusakan</a>
                </li>
                {{-- <li> <a href="{{route('permintaan.index')}}"><i class="bx bx-right-arrow-alt"></i>Permintaan</a>
                </li> --}}
                <li>
                    <a href="javascript:;" class="has-arrow" style="">
                        <i class='bx bx-right-arrow-alt' ></i>
                        <div class="menu-title" style="margin-left:0px;">Permintaan</div>
                    </a>
                    <ul>
                        <li> <a href="{{route('permintaan.index')}}"><i class="bx bx-right-arrow-alt"></i>Data</a>
                        </li>
                        <li> <a href="{{route('permintaan.indexapprove')}}"><i class="bx bx-right-arrow-alt"></i>Approve </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-package' ></i>
                </div>
                <div class="menu-title">Inventory</div>
            </a>
            <ul>
                <li> <a href="{{ route('pengguna.index') }}"><i class="bx bx-right-arrow-alt"></i>Pengguna</a>
                </li>
                <li> <a href="{{route('item.laptop')}}"><i class="bx bx-right-arrow-alt"></i>Laptop</a>
                </li>
                <li> <a href="{{route('item.printer')}}"><i class="bx bx-right-arrow-alt"></i>Printer</a>
                </li>
                <li> <a href="{{route('item.pc')}}"><i class="bx bx-right-arrow-alt"></i>PC</a>
                </li>
                <li> <a href="{{route('item.nd')}}"><i class="bx bx-right-arrow-alt"></i>Network Device</a>
                </li>
                <li> <a href="{{route('item.peripheral')}}"><i class="bx bx-right-arrow-alt"></i>Peripheral</a>
                </li>
                <li> <a href="{{route('item.consumable')}}"><i class="bx bx-right-arrow-alt"></i>Consumable</a>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow" style="">
                        <i class='bx bx-right-arrow-alt' ></i>
                        <div class="menu-title" style="margin-left:0px;">Stok</div>
                    </a>
                    <ul>
                        <li> <a href="{{route('stok.index')}}"><i class="bx bx-right-arrow-alt"></i>Device</a>
                        </li>
                        <li> <a href="{{route('stok.detail',6)}}"><i class="bx bx-right-arrow-alt"></i>Consumable</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-task' ></i>
                </div>
                <div class="menu-title">Laporan</div>
            </a>
            <ul>
                <li> <a href="{{route('laporan.pengguna')}}"><i class="bx bx-right-arrow-alt"></i>Pengguna</a>
                </li>
                <li> <a href="{{route('laporan.stok')}}"><i class="bx bx-right-arrow-alt"></i>Stok</a>
                </li>
                <li> <a href="{{route('laporan.material-request')}}"><i class="bx bx-right-arrow-alt"></i>Material Request</a>
                </li>
                <li> <a href="{{route('laporan.transaksi')}}"><i class="bx bx-right-arrow-alt"></i>Transaksi</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cog' ></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
            <ul>
                {{-- <li> <a href="{{ route('pengguna.index') }}"><i class="bx bx-right-arrow-alt"></i>Pengguna</a>
                </li> --}}
                <li> <a href="{{route('backup.index')}}"><i class="bx bx-right-arrow-alt"></i>Backup</a>
                </li>
                <li> <a href="{{ route('user.index') }}"><i class="bx bx-right-arrow-alt"></i>Users</a>
                </li>
            </ul>
        </li>
        {{-- <li class="menu-label">Data</li> --}}
        
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->