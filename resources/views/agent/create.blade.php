<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un agent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-card mx-auto col-md-8"">
        <h1 class="text-primary text-center mb-4"><i class="bi bi-person-badge"></i> Ajouter un agent</h1>

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="post" action="{{ route('agent.store') }}">
            @csrf
            <div class="mb-3 row">
                <label for="numAgent" class="col-sm-3 col-form-label text-end">Numéro agent</label>
                <div class="col-sm-9">
                    <input type="text" name="numAgent" class="form-control" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
                <a href="{{ route('agent.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        const flash = document.querySelectorAll(".alert");
        flash.forEach(f => {
            f.style.transition = "opacity 0.5s ease";
            f.style.opacity = 0;
            setTimeout(() => f.remove(), 500);
        });
    }, 3000);
</script>
</body>
</html>
