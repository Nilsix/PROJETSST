

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    
    <h1 class="text-primary">Modifier un utilisateur</h1>
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
    <form method="post" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <label for="vision" class="col-sm-3 col-form-label text-end">Vision</label>
            <div class="col-sm-6">
                <select name="vision" class="form-control" required>
                    <option value="">Sélectionner</option>
                    <option value="1" {{ old('vision', $user->vision) == 1 ? 'selected' : '' }}>Local</option>
                    <option value="2" {{ old('vision', $user->vision) == 2 ? 'selected' : '' }}>Global</option>
                    <option value="3" {{ old('vision', $user->vision) == 3 ? 'selected' : '' }}>Super admin</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-6">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </form>
</div>
</body>
<script> 
setTimeout(()=>{
    const flash = document.querySelectorAll(".alert");
    if(flash){
        flash.forEach(f => {
            f.style.transition = "opacity 0.5s ease";
            f.style.opacity = 0;
            setTimeout(()=> f.remove(),500);
        });
    }
}, 3000);
</script>
</html>

