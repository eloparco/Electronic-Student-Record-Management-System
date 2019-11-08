<?php include("includes/config.php"); ?>
<!doctype html>
<html lang="en">

<head>
  <?php include("includes/head.php"); ?>
  <link href="css/signin.css" rel="stylesheet">
</head>

<body>
  <?php include("includes/header.php"); ?>

  <main role="main" class="container">
    <form class="form-signin">
      <img class="mb-4" src="images/login.svg" alt="" width="102" height="102">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
  </main>

  <?php include("includes/footer.php"); ?>
</body>

</html>