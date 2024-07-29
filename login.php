<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="./imgs/WhatsApp Image 2022-11-30 at 9.52.27 AM.jpeg">
  <link rel="stylesheet" href="./css/login_and_register.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
  <title>login</title>
</head>

<body>
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-5 col-md-6 col-sm-12 mb-5">
        <form action="login-action.php" method="post">
          <div class="login">
            <h2 class=" mb-3 mt-3">Sign In</h2>
            <div class="mt-5">
              <input type="text" class="form-control log" placeholder="Enter DeviceName" id="DeviceName" name="DeviceName" value="<?php echo shell_exec("wmic computersystem get username"); ?>" required />
              <p id="log"></p>
            </div>
            <input type="radio" id="html" name="option" value="Breakfast">
            <label for="html">Breakfast</label>
            <input type="radio" id="css" name="option" value="Lanch">
            <label for="css">Lunch</label>
            <div class="mt-4 d-flex justify-content-center allign-items-center btn-login">
              <!-- <button onclick="document.location='index.html'" type="submit" id="submit"> -->
              <button type="submit" id="submit">
                Login
              </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>