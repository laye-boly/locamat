<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/show-equipment.css">
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
            <div class="equipment-detail">
                <div class="item-detail">
                    Tyte Equipement : <strong>{{$equipment->type}}</strong>
                </div>
                <div class="item-detail">
                    Nombre Total : <strong>{{$equipment->quantity}}</strong>
                </div>
                <div class="item-detail">
                    Prix unitaire de Location ou de Réservation : <strong>{{$equipment->unit_price}}</strong>
                </div>
                <div class="item-detail">
                    <strong>Description</strong> : 
                    <p>{{$equipment->description}}</p>
                </div>
            </div>
            <div class="equipment-images">
                @foreach ($equipment->images as $image)
                    <img src="/storage/equipment-images/{{$image->url}}" alt="{{$image->url}}" class="item-image">
                @endforeach
            </div>
            <a href="{{route('equipment.edit', ['equipment' => $equipment])}}" class="update-btn">Modifier</a>
        </div>
    </div>
</body>
</html>