<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/rental-show.css">
</head>
<body>
    <div class="page">
        @include('menu.menu-header')
        <div class="content">
            <div class="detail-header">
                <h2>Details de votre Location</h2>
                <h4>Prix : {{$rental->price}} FCFA</h4>
                <h4>Téléphone : {{$rental->user_phone}} </h4>
                <h4>Email : {{$rental->user_email}} </h4>
                <h4>Confirmation : {{$rental->confirmed}} </h4>

            </div>
            <div class="daysn">
                @foreach ($rental->rentalDays as $day)
                    <div class="day-date"><h3>Journée du {{$day->date}}<h3></div>
                    <table>
                        <thead>
                            <tr>
                                <th>Type Equipement</th>
                                <th>Quantité Loué</th>
                                <th>Prix Unitiare</th>
                                <th>Prix Total</th>
                            </tr>
                         </thead>
                         <tbody>
                    @foreach ($day->rentedEquipments as $equipment)
                        <tr>
                            <td>{{$equipment->type}}</td>
                            <td>{{$equipment->pivot->quantity}}</td>
                            <td>{{$equipment->unit_price}}</td>
                            <td><?php echo $equipment->unit_price * $equipment->pivot->quantity ; ?></td>
                        </tr>
                        
                    @endforeach
                </tbody> 
            </table>
                @endforeach
            </div>
            
        </div>
    </div>
</body>
</html>