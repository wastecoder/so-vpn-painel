<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!-- Brand -->
    <a class="navbar-brand fs-4 mx-2" href="/index.php">Administrador</a>

    <!-- Toggler/collapse button -->
    <button class="navbar-toggler mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar content -->
    <div class="collapse navbar-collapse" id="navbarContent">

        <!-- Centered Links -->
        <ul class="navbar-nav mx-auto">
            <!-- Página inicial -->
            <li class="nav-item">
                <a class="nav-link" href="/index.php">
                    <i class="fa-solid fa-house"></i>
                    Página inicial
                </a>
            </li>

            <!-- Dropdown de CERTIFICADO -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/views/certificados.php" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fa-solid fa-book"></span>
                    Certificado
                </a>
                <ul class="dropdown-menu bg-dark" aria-labelledby="dropdown1">
                    <li><a class="dropdown-item text-light" href="/views/certificados.php">Início</a></li>
                </ul>
            </li>

            <!-- Dropdown de ADM -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="/views/adms.php" id="dropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fa-solid fa-users-between-lines"></span>
                    ADM
                </a>
                <ul class="dropdown-menu bg-dark" aria-labelledby="dropdown2">
                    <li><a class="dropdown-item text-light" href="/views/adms.php">Início</a></li>
                    <li><a class="dropdown-item text-light" href="/views/cadastro.php">Cadastrar</a></li>
                </ul>
            </li>
        </ul>

        <!-- Right aligned links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/views/logout.php" class="nav-link">
                    <span class="fa-solid fa-right-from-bracket"></span>
                    Sair
                </a>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
