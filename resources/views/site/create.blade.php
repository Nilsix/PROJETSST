<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Bootstrap PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    
    <h1 class="text-primary">Créer un site</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('site.store')}}">
        @csrf
        <div class="row mb-3 align-items-center">
            <label for="nomSite" class="col-sm-3 col-form-label text-end">Nom site</label>
            <div class="col-sm-6">
                <input type="text" name="nomSite" class="form-control" placeholder="Nom site">
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a href="{{route('site.index')}}" class="btn btn-secondary d-inline">Retour</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>




