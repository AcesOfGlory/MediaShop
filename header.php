<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="/u1762930/MediaShop/main.css" rel="stylesheet" type="text/css"/>
</head>

<header>
  <div>
    <nav class="navbar navbar-default navigation-clean-button">
      <div class="container">
        <div class="navbar-header"><a class="navbar-brand" href="/u1762930/MediaShop/index.php">The Media Shop</a>
          <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="nav navbar-nav">

            <li>
              <form action="/u1762930/MediaShop/results.php" method="get">
                <input class="btn material-icons search-header-icon" role="button" type="submit" value="search"/>
                <input class="navbar-link search-header-box" type="text" placeholder="Search... " name="search_query"/>
              </form>
            </li>

            <li role="presentation"><a href="/u1762930/MediaShop/results.php?search_query=&sort=asc">Browse</a></li>
            <?php
              require_once("globalFunctions.php");
              $random = getRandomFilm();
              echo "<li role='presentation'><a href='/u1762930/MediaShop/title.php?id=$random'>Random</a></li>";
            ?>
            <li role="presentation"><a href="/u1762930/MediaShop/basket.php">View Basket</a></li>

          </ul>

          <?php
          session_start();
          if (isset($_SESSION['customer'])){
            echo "
              <ul class='nav navbar-nav account'>
                <li class='dropdown'>
                  <a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false' href='#'>Account <span class='caret'></span></a>
                  <ul class='dropdown-menu' role='menu'>
                    <li role='presentation'><a href='/u1762930/MediaShop/account/order-history.php'>Order History</a></li>
                    <li role='presentation'><a href='/u1762930/MediaShop/account/user-details.php'>User Details</a></li>
                    <li role='presentation'><a href='/u1762930/MediaShop/logout.php'>Log Out</a></li>
                  </ul>
                </li>
              </ul>
            ";
          }
          ?>


          <p class="navbar-text navbar-right actions">
            <!-- <a class="navbar-link login" href="/u1762930/MediaShop/account/index.php">Account</a> -->
            <a class="navbar-link login" href="/u1762930/MediaShop/login.php">Log In</a>

            <a class="btn btn-default action-button" role="button" href="/u1762930/MediaShop/register.php">Sign Up</a>
          </p>
        </div>
      </div>
    </nav>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</header>

</html>
