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
            <label class="col-sm-3 col-form-label">Certification</label>
            <div class="col-sm-6">
                <select name="certification" class="form-control">
                    <option value="0" {{ $agent->certification == 0 ? 'selected' : '' }}>Non</option>
                    <option value="1" {{ $agent->certification == 1 ? 'selected' : '' }}>Oui</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>

            <div class="col-sm-3 d-grid">
                <a href="{{route('agent.index')}}" class="btn btn-secondary d-inline">Retour</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>