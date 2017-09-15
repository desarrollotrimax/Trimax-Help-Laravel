<!DOCTYPE html>
<html lang="es_MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $solicitante['nombre']." ha solicitado ".$serviceRequest['tipoDeSolicitud'] }}</title>
</head>
<body>
    <p>
        Hola Ericka, <b>{{ $solicitante['nombre'] }}</b> ha solicitado <b>{{ $serviceRequest['tipoDeSolicitud'] }}</b>, para su equipo {{ $equipo['modelo'] }} con numero de serie <b>{{ $equipo['serie'] }}</b>.
        <br>
		Las <b>características</b> de la solicitud son:
    </p>

    @if ( $serviceRequest['tipoDeSolicitud'] === "Toner")

        <ul>
            <li>
                <p>Tintas:</p>
                <ul>
                    @foreach ($caracteristicas['tintas'] as $k => $v)
                        @if ($v)
                            <li>{{$k}}</li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li>
                <p>Contadores:</p>
                <ul>
                    @foreach ($caracteristicas['contadores'] as $k => $v)
                        @if ($v)
                            <li> <b> {{$k}} :</b> {{$v}}</li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>
        
    @elseif ($serviceRequest['tipoDeSolicitud'] === "Servicio Técnico")
        @if( $caracteristicas['problema'] === "Otro (especificar)")
            <p><b>Problema Especificado:</b> {{ $caracteristicas['problemaEspecifico'] }}. </p>
        @else
            <p><b>Problema Seleccionado:</b> {{ $caracteristicas['problema'] }}. </p>
        @endif
        <?php
            $contadores = false;
            foreach ($caracteristicas['contadores'] as $valor) {
                if( $valor!=='' ){
                    $contadores = true;
                }
            }
        ?>
        @if($contadores)
            <p>Contadores:</p>
                <ul>
                    @foreach ($caracteristicas['contadores'] as $k => $v)
                        @if ($v)
                            <li> <b> {{$k}} :</b> {{$v}}</li>
                        @endif
                    @endforeach
                </ul>
        @endif
    @elseif ($serviceRequest['tipoDeSolicitud'] === "Configuración")
        <p>
     @if( $caracteristicas['configuracionRequerida'] === "Otro (especificar)")
            <b>El solicitante especificó:</b> {{ $caracteristicas['configuracionEspecifica'] }}.
        @else
            <p><b>El solicitante seleccionó:</b> {{ $caracteristicas['configuracionRequerida'] }}. </p>
        @endif
            <br>
            Para <b>{{ $caracteristicas['numeroDeUsuarios'] }}</b> número de usuarios.
        </p>
    @endif
   
    <p>
        Los datos de la persona que hizo la solicitud son:
        <ul>
            <li><b>Nombre:</b> {{ $solicitante['nombre'] }} {{ $solicitante['apellido'] }}.</li>
            <li><b>Celular:</b> {{ $solicitante['celular'] }}.</li>
        </ul>
    </p>
    <p>
        Nunca dudes que un pequeño grupo de personas comprometidas pueda cambiar el mundo. <br>
        De hecho, es la única forma en que se ha logrado. <br>
        <i>-Margaret Meade.</i>
    </p>
			
</body>
</html>