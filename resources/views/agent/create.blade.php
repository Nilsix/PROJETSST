<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Bootstrap PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    
    <h1 class="text-primary">Ajouter un agent</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('agent.store')}}">
        @csrf
        <div class="row mb-3 align-items-center">
            <label for="numAgent" class="col-sm-3 col-form-label text-end">Numéro agent</label>
            <div class="col-sm-6">
                <input type="text" name="numAgent" class="form-control" placeholder="UR11701281" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>

            <div class="col-sm-3 d-grid">
                <a href="{{route('agent.index')}}" class="btn btn-secondary d-inline">Annuler</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>




