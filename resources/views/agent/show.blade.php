<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Agent - {{ $agent['prenom'] }} {{ $agent['nom'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .page-title {
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }
        .info-card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
            height: 100%;
        }
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .info-card .card-body {
            padding: 1.25rem;
        }
        
        .info-label {
            min-width: 100px;
        }
        .info-card .card-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }
        .info-item {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
        }
        .info-item i {
            margin-right: 0.75rem;
            color: #2575fc;
            width: 20px;
            text-align: center;
            margin-top: 0.2rem;
        }
        .info-label {
            font-weight: 500;
            color: #6c757d;
            min-width: 120px;
        }
        .info-value {
            font-weight: 400;
            color: #212529;
            flex: 1;
        }
        .certification-badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
        }
        .certification-badge i {
            margin-right: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
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
        <div class="row justify-content-center">
            <div class="col-12">
        <!-- Bouton de retour -->
        <div class="mb-4">
            <a href="{{ route('agent.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <!-- <h1 class="page-title">{{ $agent['prenom'] }} {{ $agent['nom'] }}</h1> -->

        <div class="row">
            <div class="col-12">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-info-circle me-2"></i>Informations
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-person-badge"></i>
                                    <span class="info-label">Matricule:</span>
                                    <span class="info-value">{{ $agent['numagent'] }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <i class="bi bi-person-vcard"></i>
                                    <span class="info-label">Nom:</span>
                                    <span class="info-value">{{ $agent['nom'] }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <i class="bi bi-person"></i>
                                    <span class="info-label">Prénom:</span>
                                    <span class="info-value">{{ $agent['prenom'] }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <i class="bi bi-envelope"></i>
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">{{ $agent['email'] }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-phone"></i>
                                    <span class="info-label">Téléphone:</span>
                                    @if($agent['mobile'] != null)
                                    <span class="info-value">{{ $agent['mobile'] }}</span>
                                    @else
                                    <span class="info-value">{{ $agent['telephone'] }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-building"></i>
                                    <span class="info-label">Site:</span>
                                    <span class="info-value">{{ $agent['sitename'] }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <i class="bi bi-person-workspace"></i>
                                    <span class="info-label">Fonction:</span>
                                    <span class="info-value">{{ $agent['jobname'] }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-person-workspace"></i>
                                    <span class="info-label">Service : </span>
                                    <span class="info-value"> {{$agent['servicename']}}</span>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-person-workspace"></i>
                                    <span class="info-label">Branche </span>
                                    <span class="info-value"> {{$agent['branchcode']}}</span>
                                </div>

                                <div class="info-item">
                                    <i class="bi bi-person-workspace"></i>
                                    <span class="info-label">Direction : </span>
                                    <span class="info-value"> {{$agent['directionname']}}</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
