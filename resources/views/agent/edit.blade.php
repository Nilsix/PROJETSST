<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Bootstrap PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-primary">Modifier un agent</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('agent.update',['agent'=>$agent])}}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Numéro</label>
            <div class="col-sm-6">
                <input type="text" name="numAgent" class="form-control" value="{{ $agent->numAgent }}">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Nom</label>
            <div class="col-sm-6">
                <input type="text" name="nomAgent" class="form-control" value="{{ $agent->nomAgent }}">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Prénom</label>
            <div class="col-sm-6">
                <input type="text" name="prenomAgent" class="form-control" value="{{ $agent->prenomAgent }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>