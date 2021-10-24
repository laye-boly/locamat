<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/equipment-edit.css">
    <link rel="stylesheet" href="../../css/form.css">
    <script src="../../js/equipment-edit.js" defer></script>
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
            {!! Form::open(['url' => route('equipment.update', ['equipment' => $equipment]), 'files' => true, 'class' => 'form-edit']) !!}
                <div class="@if($errors->any()) error-container @elseif(session('success')) success-container @elseif(session('warning')) warning-container @endif">
                    @if($errors->any())
                        <div class="error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                   <li>{{$error}}</li> 
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="success">
                            <p>{{ session('success') }}</p> 
                            <p><a href="{{route('equipment.show', ['equipment' => session('equipmentId')])}}">Voir l'équipment</a></p>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="warning">
                            <p>{{ session('warning') }}</p> 
                            {{-- <p><a href="{{route('equipment.show', ['equipment' => session('equipmentId')])}}">Voir l'équipment</a></p> --}}
                        </div>
                    @endif
                </div>
                <div class="input-container">
                    <div class="form-item">
                        {{ Form::label('type', "Type d'équipement", ['class' => 'form-label']) }}
                        {{  Form::text('type', $equipment->type, ['class' => 'form-input']) }}
                     </div>
                     <div class="form-item">
                         {{ Form::label('quantity', "Quantité du type d'équipement", ['class' => 'form-label']) }}
                         {{  Form::number('quantity', $equipment->quantity, ['class' => 'form-input']) }}
                     </div>
                     <div class="form-item">
                         {{Form::label('file', "Télécharger les images d'illustration ")}}
                         {{Form::file('file[]', ['multiple' => 'multiple', 'class' => 'form-input'])}}
                     </div>
                     
                </div>
                <div class="description-item-container">
                    <div class="form-item">
                        {{ Form::label('description', "Description du type d'équipement", ['class' => 'form-label']) }}
                        {{  Form::textarea('description', $equipment->description, ['class' => 'form-input']) }}
                    </div>
                </div>
                <div class="form-item sumbit-form-item">
                    {{Form::submit('Soumettre', ['class'=>'btn btn-success'])}}
                </div>
            {!! Form::close() !!}

            <div class="equipment-images">
                @foreach ($equipment->images as $image)
                    <div class="image-delete-form-container image-no-{{$image->id}}">
                        <img src="/storage/equipment-images/{{$image->url}}" alt="{{$image->url}}">
                        {!! Form::open(['url' => route('image.delete'), 'class' => "form-image-delete"]) !!}
                            {{  Form::hidden('image-id', $image->id) }}
                            {{  Form::hidden('owner-image-id', $equipment->id) }}
                            <div class="form-item sumbit-form-item">
                                {{Form::submit('supprimer', ['class'=>'btn btn-danger'])}}
                            </div>
                        {!! Form::close() !!}              
                    </div>
                @endforeach
            </div>

        </div>
        <div id="images-number" hidden>{{count($equipment->images)}}</div>
        {{-- debut div qui alert le user qu'il ne reste qu'une seule image et ne eut la supprimer --}}
        <div class="warning-bg div-info" style="display: none;">
            <button class="button" id="close-div">Fermer</button>
            <p>Un équipement doit obligatoirement avoir au moins une image d'illustration</p>
        </div>
        {{-- fin div qui alert le user qu'il ne reste qu'une seule image et ne eut la supprimer --}}
    </div>
</body>
</html>