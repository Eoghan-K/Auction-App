<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../index.php">topChoice Auctions</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if ( $GLOBALS[ 'isLoggedIn' ] ) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="./userPage.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./sellItem.php">Sell Item</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="./contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./about.php">About</a>
            </li>
            <li class="nav-item">
                <form id='search-bar' class="form-inline my-2 my-lg-0" method="GET" action="search.php">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                        name="search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if ( $GLOBALS[ 'isLoggedIn' ] ) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="./scripts/Logout.php">
                        <button type="button" class="btn btn-success">Logout</button>
                    </a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link " href="./login.php">
                        <button type="button" class="btn btn-success">Login</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="./registration.php">
                        <button type="button" class="btn btn-success">Sign Up</button>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
