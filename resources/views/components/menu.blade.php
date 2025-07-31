<li class="nav-item">
    <a class="nav-link menu-link" href="#sidebarDepartamentiManager" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDepartamentiManager">
        <i class="ri-folders-line"></i> <span data-key="t-project-manager">Departamenti Shitjes</span>
    </a>
    <div class="collapse menu-dropdown" id="sidebarDepartamentiManager">
        <ul class="nav nav-sm flex-column">
            
            <!-- Categories Dropdown -->
            <li class="nav-item">
                <a href="#sidebarCategories" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCategories">
                    Categories
                </a>
                <div class="collapse menu-dropdown" id="sidebarCategories">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('space.categories') }}" class="nav-link" data-key="t-shitesi"> Add Hapsira </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('modele_products.categories') }}" class="nav-link" data-key="t-shitesi"> Add Product Category</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Other direct links -->
            <li class="nav-item">
                <a href="{{ route('departamentishitjes.modeles.dashboard') }}" class="nav-link" data-key="t-modeles"> Models </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('departamentishitjes.shitesi.dashboard') }}" class="nav-link" data-key="t-shitesi"> Shitesi </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('departamentishitjes.arkitekti.dashboard') }}" class="nav-link" data-key="t-arkitekti"> Arkitekti </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('departamentishitjes.kostoisti.dashboard') }}" class="nav-link" data-key="t-kostoisti"> Kostoisti </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('departamentishitjes.kryeinxhinieri.dashboard') }}" class="nav-link" data-key="t-kryeinxhinieri"> KryeInxhinier </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('departamentishitjes.ofertuesi.dashboard') }}" class="nav-link" data-key="t-ofertuesi"> Ofertuesi </a>
            </li>
        </ul>
    </div>
</li>
