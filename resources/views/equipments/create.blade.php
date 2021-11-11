<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Creation d'un matériel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div class="page">
        @include('menu.menu-header')
        <div class="content">
            {!! Form::open(['url' => route('equipment.store'), 'files' => true ]) !!}
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
                        {{  Form::text('type', '', ['class' => 'form-input']) }}
                     </div>
                     <div class="form-item">
                         {{ Form::label('quantity', "Quantité du type d'équipement", ['class' => 'form-label']) }}
                         {{  Form::number('quantity', '', ['class' => 'form-input']) }}
                     </div>
                     <div class="form-item">
                        {{ Form::label('unit_price', "Prix unitaire de Location ou de Réservation", ['class' => 'form-label']) }}
                        {{  Form::number('unit_price', '', ['class' => 'form-input']) }}
                    </div>
                     <div class="form-item">
                         {{Form::label('file', "Télécharger les images d'illustration ")}}
                         {{Form::file('file[]', ['multiple' => 'multiple', 'class' => 'form-input'])}}
                     </div>
                     
                </div>
                <div class="description-item-container">
                    <div class="form-item">
                        {{ Form::label('description', "Description du type d'équipement", ['class' => 'form-label']) }}
                        {{  Form::textarea('description', '', ['class' => 'form-input']) }}
                    </div>
                </div>
                <div class="form-item sumbit-form-item">
                    {{Form::submit('Soumettre', ['class'=>'btn btn-primary'])}}
                </div>
            {!! Form::close() !!}

        </div>
    </div>
</body>
</html>