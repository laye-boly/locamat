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
            @if (count($devisData) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Type Equipement</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Prix total</th>
                        </tr>
                     </thead>
                     <tbody>
                        
                            @foreach ($devisData as $equipment)
                            
                            @if ($equipment !== $devisData['email'] && $equipment !== $devisData['phone'] && $equipment !== $devisData['total'])
                                <tr>
                                    <td>{{$equipment['equipment']}}</td>
                                    <td>{{$equipment['quantity']}}</td>
                                    <td>{{$equipment['unitPrice']}}</td>
                                    <td>{{$equipment['unitPrice'] * $equipment['quantity']}}</td>
                                
                                </tr>
                                @endif
                            @endforeach 
                        
                    </tbody> 
                </table>
                <div class="total">
                    <p>Total du devis : <strong>{{$devisData['total']}}</strong></p>
                </div>
            @else
                <div class="empty-equipment">
                    <p>Vous n'avez pas encore d'équipements</p>
                </div>
            @endif
            
            
        </div>
        
    </div>
</body>
</html>