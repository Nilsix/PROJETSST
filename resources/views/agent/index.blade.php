<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des agents</title>
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

    <h1 class="mb-4 text-center">Liste des Agents</h1>

    <div class="row mb-4 justify-content-center">
        <div class="col-md-3 d-grid mb-2">
            <a class="btn btn-success" href="{{ route('agent.create') }}">
                <i class="bi bi-plus-circle"></i> Ajouter un agent
            </a>
        </div>
        @can('manage-users')
        <div class="col-md-3 d-grid mb-2">
            <a class="btn btn-warning" href="{{ route('user.index') }}">
                <i class="bi bi-people-fill"></i> Utilisateurs
            </a>
        </div>
        @endcan
        <div class="col-md-3 d-grid mb-2">
            <a class="btn btn-secondary" href="{{ route('dashboard') }}">
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
                    <th scope="col">Site</th>
                    <th scope="col">Certification</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agentsList as $agent)
                @can('see-agent', [$agent['sitename'], $userSite])
                <tr>
                    <td>{{ $agent['numAgent'] }}</td>
                    <td>{{ $agent['nom'] }}</td>
                    <td>{{ $agent['prenom'] }}</td>
                    <td>{{ $agent['sitename'] }}</td>
                    <td>
                        @if($agent['certification'] == 1)
                            <span class="badge bg-success">Oui</span>
                        @elseif($agent['certification'] == 2)
                            <span class="badge bg-danger">Non</span>
                        @else
                            <span class="badge bg-secondary">Vide</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('agent.show', $agent['id']) }}" class="btn btn-outline-info btn-sm me-1" title="Détails">
                            <i class="bi bi-info-circle"></i>
                        </a>
                        <a href="{{ route('agent.edit', $agent['id']) }}" class="btn btn-outline-primary btn-sm me-1" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('agent.destroy', $agent['id']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endcan
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-dismiss alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 500);
        });
    }, 4000);
</script>

</body>
</html>
