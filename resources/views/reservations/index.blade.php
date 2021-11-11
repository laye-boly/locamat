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
        @include('menu.menu-header')
        <div class="content">
            @if (count($reservations) > 0)
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
                        @foreach ($reservations as $reservation)
                            <tr class="equipment-no-{{$reservation->id}}">
                                <td>{{$reservation->created_at}}</td>
                                <td>{{$reservation->deadline}}</td>
                                <td>{{$reservation->confirmed}}</td>
                                <td>{{$reservation->price}} FCFA</td>
                                <td><a href="{{route('reservation.show', ['reservation' => $reservation])}}">Voir</a></td>
                                <td>
                                    {!! Form::open(['url' => route('reservation.delete', ['reservation' => $reservation]), 'class' => "form-rental-delete"]) !!}
                                        {{  Form::hidden('rental-id', $reservation->id) }}
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