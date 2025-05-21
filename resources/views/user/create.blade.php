

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-primary">Créer un utilisateur</h1>
    @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <form method="post" action="{{ route('user.store') }}">
        @csrf
        <div class="row mb-3">
            <label for="numAgent" class="col-sm-3 col-form-label text-end">Numéro agent</label>
            <div class="col-sm-6">
                <input type="text" name="numAgent" class="form-control" value="{{ old('numAgent') }}" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="password" class="col-sm-3 col-form-label text-end">Mot de passe</label>
            <div class="col-sm-6">
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="vision" class="col-sm-3 col-form-label text-end">Vision</label>
            <div class="col-sm-6">
                <select name="vision" class="form-control" required>
                    <option value="">Sélectionner</option>
                    <option value="1" {{ old('vision') == 1 ? 'selected' : '' }}>Local</option>
                    <option value="2" {{ old('vision') == 2 ? 'selected' : '' }}>Global</option>
                    <option value="3" {{ old('vision') == 3 ? 'selected' : '' }}>Super admin</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-6">
                <button type="submit" class="btn btn-success">Créer</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </form>
</div>

