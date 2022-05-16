
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="search.js"></script>
<header style="font-family: lucida sans;" class="container-fluide header">
<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark" >
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <a class="navbar-brand" href="#">
         <img src="../img/icone1.png" alt="logo Go2Events" width="50" height="50">
       </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                  <a class="nav-link" href="../index.php">Accueil<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                   <a class="nav-link" href="../presdemoi.php">Près de moi</a>
              </li>
              <li class="nav-item active">
                  <a class="nav-link " href="../mesevents.php"> Mes Events </a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link " href="../amis.php" > Mes Amis </a>
                  </li>
            </ul>
    

 








    <?php
            if ( !isset($_SESSION['id']) &&  !isset($_SESSION['status'])) { // Si on ne détecte pas de session alors on verra les liens ci-dessous
                ?>
        <ul class="navbar-nav ml-md-auto">
          <li class="nav-item active">
            <a class="nav-link" href="../register.php">S'inscrire</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="../login.php">Se connecter</a>
          </li>
        </ul>
   

   

        <?php
             
            }elseif ( (isset($_SESSION['id']) &&  ($_SESSION['status'] != 1)) ) { // Si on ne détecte  de session mais pas admin on verra les liens ci-dessous
                ?>
          
                
                <ul class="navbar-nav ml-md-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="../profil.php?id=>?=$id?>">Mon profil</a> </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Déconnexion</a>
                    </li>
        </ul>
               

        <?php
             
            }elseif ( isset($_SESSION['id']) &&  ($_SESSION['status'] = 1)) { // Si on ne détecte la session et c'est un admin alors on verra les liens ci-dessous
                ?>
             
                
                <ul class="navbar-nav ml-md-auto">
                  <li class="nav-item">
                    
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Administration
                        </button>
                          <div class="dropdown-menu" aria-labelledby="#dropdownMenuButton">
                            <a class="dropdown-item" href="toutEvents.php">Liste d'events</a>
                            <a class="dropdown-item" href="listusers.php">Gérer les users</a>
                            <a class="dropdown-item" href="creer_event.php">Créer un event</a>
                          </div> 
                    </div>
                    
                    <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Déconnexion</a>
                    </li>
        </ul>
               
                <?php
            } 
        ?>
            </div>

            
  </div>
</nav>
</header>

