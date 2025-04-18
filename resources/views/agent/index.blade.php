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
        <a href="{{route('agent.create')}}" >Ajouter un agent</a>
        <table class="table">
            <thead> 
                <tr>
                    <th>NumAgent</th>
                    <th>Nom </th>
                    <th>Prenom</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agents as $agent)
                <tr>
                    <td>{{$agent->numAgent}}</td>
                    <td>{{$agent->nomAgent}}</td>
                    <td>{{$agent->prenomAgent}}</td>
                    <td>
                        <a href="{{route('agent.edit',['agent' => $agent ])}}" class='btn btn-primary'>Modifier</a>
                        <form action="{{route('agent.destroy',['agent' => $agent ])}}" method="post" class="d-inline">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
</body>
</html>