<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1>Agents</h1>
        <div class="row mb-3">
            <div class="col sm-3 d-grid">
            <a class="btn btn-primary" href="{{route('agent.create')}}" >Ajouter un agent</a>
            </div>
            @can('manage-users')
            <div class="col sm-3 d-grid">
            <a class="btn btn-primary" href="{{route('user.index')}}">Utilisateurs</a>
            </div>
            @endcan
            <div class="col sm-3 d-grid">
            <a class="btn btn-secondary" href="{{route('dashboard')}}" >Retour à l'acceuil</a>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-light"> 
                <tr>
                    <th>NumAgent</th>
                    <th>Nom </th>
                    <th>Prenom</th>
                    <th>Site</th>
                    <th>Certification</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agentsList as $agent)
                @can('see-agent', [$agent['sitename'], $userSite])
                <tr>
                    <td>{{$agent['numAgent']}}</td>
                    <td>{{$agent['nom']}}</td>
                    <td>{{$agent['prenom']}}</td>
                    <td>{{$agent['sitename']}}</td>  
                    <td>
                        @if($agent['certification'] == 1)
                            Oui
                        @elseif($agent['certification'] == 2)
                            Non
                        @elseif($agent['certification'] == 3)
                            Vide
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{route('agent.edit', $agent['id'])}}" class='btn btn-primary'>Modifier</a>
                        <form action="{{ route('agent.destroy', $agent['id']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endcan
                @endforeach
            </tbody>
        </table> 
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