<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container" style="margin-left: 20%">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">

            <h2 class="text-center m-5 p-5">Sign Up</h2>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username"
                           class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                           value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email"
                           class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                           value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password"
                           class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                           value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password"
                           class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                           value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-dark btn-block" value="Submit">

                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>
</div>
</body>
</html>