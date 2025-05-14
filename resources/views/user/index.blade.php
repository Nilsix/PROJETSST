<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-primary">Liste des utilisateurs</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row mb-4">
        <div class="col-sm-3 d-grid">
            <a href="{{ route('user.create') }}" class="btn btn-success">Ajouter un utilisateur</a>
        </div>
        <div class="col-sm-3 d-grid">
            <a href="{{ route('agent.index') }}" class="btn btn-primary">Voir les agents</a>
        </div>

        <div class="col-sm-3 d-grid">
            <a class="btn btn-secondary" href="{{ route('dashboard') }}">Retour à l'accueil</a>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Vision</th>
                <th>Site</th>
                <th>Certification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->vision }}</td>

                    <td>{{ $user->certification ? 'Oui' : 'Non' }}</td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

