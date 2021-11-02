<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/rental-index.css">
    <link rel="stylesheet" href="../../../css/table.css">
    <script src="../../js/rental-index.js" defer></script>
</head>
<body>
    <div class="page">
        <div class="header">
            <nav class="nav-container">
                <ul class="nav-item-container">
                    <li class="nav-item"><a href="#">Gérer mes équipments</a></li>
                    <li class="nav-item"><a href="#">Gérer mes équipments</a></li>
                    <li class="nav-item"><a href="#">Gérer mes locations</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
            @if (count($rentals) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Date de reservation</th>
                            <th>Dedaline de confirmation</th>
                            <th>Statut</th>
                            <th>Prix</th>
                            <th>Détail</th>
                            <th>Supprimer</th>


                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($rentals as $rental)
                            <tr class="equipment-no-{{$rental->id}}">
                                <td>{{$rental->created_at}}</td>
                                <td>{{$rental->deadline}}</td>
                                <td>{{$rental->confirmed}}</td>
                                <td>{{$rental->price}} FCFA</td>
                                <td><a href="{{route('rental.show', ['rental' => $rental])}}">Voir</a></td>
                                <td>
                                    {!! Form::open(['url' => route('rental.delete', ['rental' => $rental]), 'class' => "form-rental-delete"]) !!}
                                        {{  Form::hidden('rental-id', $rental->id) }}
                                        <div class="submit">
                                            {{Form::submit('supprimer', ['class'=>'btn btn-danger'])}}
                                        </div>
                                    {!! Form::close() !!} 
                                </td>
                            </tr>
                        @endforeach
                    </tbody> 
                </table>
            @else
                <div class="empty-equipment">
                    <p>Vous n'avez pas encore de réservations</p>
                </div>
            @endif
            
            
        </div>
        {{-- debut div qui notifie le user du succées de la suppression --}}
        <div class="success-bg div-info" style="display: none;">
            <button class="button" id="close-div">Fermer</button>
            <p>L'équipement à été supprimé avec succées</p>
        </div>
        {{-- fin div qui notifie le user du succées de la suppression  --}}
    </div>
</body>
</html>