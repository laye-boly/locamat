<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/calendar-index.css">
    <script src="../../js/calendar-index.js" defer></script>
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
        <div class="action-button">
            <button id="rents">Louer</button>
            <button id="books">Réserver</button>
        </div>
        <div class="page-container">
            <div class="content">
                
                <?php 
                    $keys = array_keys($weekSchedule);
                ?>
                @foreach ($keys as $key)
                    <div class="day">
                        <div class="day-date">
                            {{$key}}
                        </div>
                        @if(count($weekSchedule[$key]) > 0)
                            <div class="equipment-schedule-container">
                                @foreach ($weekSchedule[$key] as $daySchedule )
                                    <div class="equipment-schedule" data-type-equipment="{{$daySchedule[0]->type}}" quantity-available="{{$daySchedule[1]}}">
                                        <p>{{$daySchedule[0]->type}} : {{$daySchedule[1]}}</p>
                                        <p><button class="button"><a href="#" class="detail" id="{{$daySchedule[0]->id}}" data-quantity="{{$daySchedule[1]}}">voir détail</a></button></p>
                                    </div>
                                
                                @endforeach
                                
                                <div class="client-action">
                                    <button class="button rent" id="rent"><a href="">Louer</a></button>
                                    <button class="button book"><a href="">Réserver</a></button>
                                </div>
                            </div>
                        @else
                            <div class="not-available">
                                <p>Aucun équipement n'est disponible pour cette journée</p>
                            </div>
                        @endif
                    </div>   
                @endforeach
            </div>
            <div class="resume">
                <h2>Détail de la réservation</h2>
                <div class="resume-detail"></div>
            </div>
        </div>
        
    </div>
</body>
</html>