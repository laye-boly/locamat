<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/equipment-index.css">
    <link rel="stylesheet" href="../../css/table.css">
    <script src="../../js/equipment-index.js" defer></script>
</head>
<body>
    <div class="page">
        @include('menu.menu-header')
        <h3><a href="{{route('equipment.create')}}">Ajouter un nouveau type d'équipement</a></h3>
        <div class="content">
            
            @if (count($equipments) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Type Equipement</th>
                            <th>Nombre Total</th>
                            
                            <th>Détail</th>
                            <th>Supprimer</th>


                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($equipments as $equipment)
                            <tr class="equipment-no-{{$equipment->id}}">
                                <td>{{$equipment->type}}</td>
                                <td>{{$equipment->quantity}}</td>
                                
                                <td><a href="{{route('equipment.show', ['equipment' => $equipment])}}">Voir</a></td>
                                <td>
                                    {!! Form::open(['url' => route('equipment.delete'), 'class' => "form-equipment-delete"]) !!}
                                        {{  Form::hidden('equipment-id', $equipment->id) }}
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
                    <p>Vous n'avez pas encore d'équipements</p>
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