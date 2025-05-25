<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Register</h2>

            <!-- Show Validation Errors -->
            <?php if (validation_errors()): ?>
                <div class="alert alert-danger"><?= validation_errors(); ?></div>
            <?php endif; ?>

            <?= form_open('auth/register'); ?>
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            <?= form_close(); ?>

            <div class="text-center mt-3">
                <a href="<?= site_url('auth/login'); ?>" class="text-decoration-none">Already have an account? Login</a>
            </div>
        </div>
    </div>

</body>
</html>
