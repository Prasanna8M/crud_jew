<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 text-center" style="max-width: 500px; width: 100%;">
            <h2 class="mb-4">Welcome <strong><?= $this->session->userdata('user_name'); ?></strong></h2>
            <div class="d-grid gap-3">
                <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger">Logout</a>
                <a href="<?= site_url('product'); ?>" class="btn btn-primary">Go to Product List</a>
            </div>
        </div>
    </div>

</body>
</html>
