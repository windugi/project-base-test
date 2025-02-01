<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
    @if(Auth::check())
        @if(Auth::user()->role == 'doctor')
            <li class="nav-item">
                <a href="{{ route('doctor.dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-user-md"></i>
                    <p>Dashboard Dokter</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.patients') }}" class="nav-link">
                    <i class="nav-icon fas fa-procedures"></i>
                    <p>Data Pasien</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('doctor.prescriptions') }}" class="nav-link">
                    <i class="nav-icon fas fa-file-prescription"></i>
                    <p>Resep Obat</p>
                </a>
            </li>
        @elseif(Auth::user()->role == 'pharmacist')
            <li class="nav-item">
                <a href="{{ route('pharmacist.dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-capsules"></i>
                    <p>Dashboard Apoteker</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacist.prescriptions') }}" class="nav-link">
                    <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                    <p>Kelola Resep</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pharmacist.payments') }}" class="nav-link">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Pembayaran</p>
                </a>
            </li>
        @endif
    @endif
</ul>
