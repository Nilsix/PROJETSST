<!DOCTYPE html>
<html lang="fr">
    <head>
    </head>
        <body>
            
        <form method="GET" action="{{ route('agent.seeInfos') }}">
            <label for="numAgent">Numéro d'agent :</label>
            <input type="text" name="numAgent" required>
            <button type="submit">Rechercher</button>
        </form>
        </body>
            
</html>
