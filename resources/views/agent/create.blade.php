<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKBk/a8Rna0GQZS+MP1mcJjXpS9N7ZaM1YsXVwH7scmXQ40myYjHrVhXaw+8sh58" crossorigin="anonymous">
</head>
<body>
<div class="container my-5"> 
    <h1>Créer un agent</h1>
    <form method='post' action=''>
        @csrf

        <div class="row mb-3 align-items-center">
            <label class="col-sm-3 col-form-label text-end" for="numAgent">Numéro agent</label>
            <div class="col-sm-6">
                <input type='text' class="form-control" name='numAgent' placeholder='Numéro agent'>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label class="col-sm-3 col-form-label text-end" for="name">Nom</label>
            <div class="col-sm-6">
                <input type='text' class="form-control" name='name' placeholder='Nom'>
            </div>
        </div>

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type='submit' class="btn btn-primary">Créer</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
