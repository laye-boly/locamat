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
            <div class="detail-header">
                <h2>Details de votre Réservation</h2>
                <h4>Prix : {{$reservation->price}} FCFA</h4>
                <h4>Téléphone : {{$reservation->user_phone}} </h4>
                <h4>Email : {{$reservation->user_email}} </h4>
                <h4>Confirmation : {{$reservation->confirmed}} </h4>
                <h4>Veuillez confirmer votre réservation avant le  : {{$reservation->deadline}} </h4>

            </div>
            <div class="daysn">
                @foreach ($reservation->reservationDays as $day)
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
                    @foreach ($day->reservedEquipments as $equipment)
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