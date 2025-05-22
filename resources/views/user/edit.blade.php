<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
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
    <div class="form-card mx-auto col-md-8">
        <h1 class="text-primary text-center mb-4"><i class="bi bi-person-gear"></i> Modifier un utilisateur</h1>

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

        <form method="post" action="{{ route('user.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="vision" class="col-sm-3 col-form-label text-end">Vision</label>
                <div class="col-sm-9">
                    <select name="vision" class="form-select" required>
                    <option value="">Sélectionner</option>
                    <option value="1" {{ old('vision', $user->vision) == 1 ? 'selected' : '' }}>Local</option>
                    <option value="2" {{ old('vision', $user->vision) == 2 ? 'selected' : '' }}>Global</option>
                    <option value="3" {{ old('vision', $user->vision) == 3 ? 'selected' : '' }}>Super admin</option>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-check-circle"></i> Mettre à jour
                </button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
