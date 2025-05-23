<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h1 {
            margin-top: 30px;
        }
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="container py-4">
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <h1 class="mb-4 text-center text-primary">Liste des utilisateurs</h1>

    <div class="row mb-4 justify-content-center">
        <div class="col-md-3 d-grid mb-2">
            <a href="{{ route('user.create') }}" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Ajouter un utilisateur
            </a>
        </div>
        <div class="col-md-3 d-grid mb-2">
            <a href="{{ route('agent.index') }}" class="btn btn-primary">
                <i class="bi bi-person-badge"></i> Voir les agents
            </a>
        </div>
        <div class="col-md-3 d-grid mb-2">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-house-door"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">NumAgent</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Vision</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->numAgent }}</td>
                    <td>{{ explode(" ", $user->name)[0] }}</td>
                    <td>{{ explode(" ", $user->name)[1] }}</td>
                    <td>{{ $user->email }}</td>
                    @if($user->vision == 1)
                    <td>Local</td>
                    @elseif($user->vision == 2)
                    <td>Global</td>
                    @elseif($user->vision == 3)
                    <td>Admin</td>
                    @endif
                    <td class="text-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="return confirm('Supprimer cet utilisateur ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
