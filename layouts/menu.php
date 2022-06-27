<div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Beranda </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cara_pesan.php">Cara Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kotak.php">Kontak</a>
                    </li>
                </ul>
                <?php if (isset($_SESSION["id"])){
                   $id = $_SESSION['id'];
                   $sql = "select * from user where id='$id'";
                   $result = $mysqli->query($sql);
                   $row = $result->fetch_assoc();    
                   $user = $row["username"];
                ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-success my-2 my-sm-0 dropdown-toggle"  style="color:white;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-address-card"></i> <?php echo $user; ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="detail.php">Detail</a>
                            <a class="dropdown-item" href="logout.php" id='logout'>Logout</a>
                        </div>
                        
                    </div>
                    <div class="form-inline my-2 my-lg-0">
                        <a href="pesanan.php" class="btn btn-outline-success my-2 my-sm-0" style="color:white;">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                    
                   
                    <?php  }else{ //echo $_SESSION['id'];?>
                        <div class="form-inline my-2 my-lg-0">
                        <a href="login.php" class="btn btn-outline-success my-2 my-sm-0" type="submit" style="color:white;">
                        <i class="fas fa-address-card"></i> Login</a>
                         <a class="class="btn btn-outline-success my-2 my-sm-0"  href="daftar.php" style="color:white;">Daftar</a>
                        
                        </a>
                    </div>
                     
                    <?php  }?>
                
            </div>