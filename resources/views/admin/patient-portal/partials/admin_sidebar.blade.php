<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            @php
                $prefix = Request::route()->getPrefix();
                $route = Route::current()->getName();
            @endphp

            <div class="nav">
               

                <a class="nav-link {{ $route == 'patientPortal.dashboard' ? 'active' : '' }}" href="{{ route('patientPortal.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    <span class="nav-link-text">Dashboard</span>
                </a>              
              
                <a class="nav-link {{ $route == 'patientPortal.invoice' ? 'active' : '' }}" href="{{ route('patientPortal.invoice') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                    <span class="nav-link-text">Invoice List</span>
                </a>

                <a class="nav-link {{ $route == 'patientPortal.prescription' ? 'active' : '' }}" href="{{ route('patientPortal.prescription') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-prescription"></i></div>
                    <span class="nav-link-text">Prescription</span>
                </a>

                <a class="nav-link {{ $route == 'patientPortal.ipd' ? 'active' : '' }}" href="{{ route('patientPortal.ipd') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-notes-medical"></i></div>
                    <span class="nav-link-text">IPD</span>
                </a>

                <a class="nav-link" href="{{ route('patientPortal.logout') }}"
                    onclick="return confirm('Are you sure logout from Admin Panel')">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    <span class="nav-link-text">Log Out</span>
                </a>
            </div>
        </div>
    </nav>
</div>

<!-- Add this script at the bottom of your page or in your main JS file -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle the side navigation
        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
                localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
            });
        }
        
        // Initialize sidebar state from localStorage
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.add('sb-sidenav-toggled');
        }
    });
</script>

<style>
    /* Ensure proper sidebar behavior */
    .sb-sidenav {
        height: 100vh;
        z-index: 1000;
        position: fixed;
        top: 0;
        left: 0;
        width: 225px;
        transition: all 0.3s;
        overflow-y: auto;
    }
    
    .sb-sidenav-toggled .sb-sidenav {
        width: 0;
        overflow: hidden;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 991.98px) {
        .sb-sidenav {
            width: 0;
            overflow: hidden;
        }
        
        .sb-sidenav-toggled .sb-sidenav {
            width: 225px;
        }
        
        /* Push content when sidebar is open */
        .sb-sidenav-toggled #layoutSidenav_content {
            margin-left: 225px;
            overflow: hidden;
        }
    }
    
    /* Smooth transitions */
    .nav-link-text {
        transition: opacity 0.3s;
    }
    
    .sb-sidenav-toggled .nav-link-text {
        opacity: 0;
    }
</style>