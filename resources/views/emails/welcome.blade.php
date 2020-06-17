@component('mail::message')
# Bienvenido al sistema {{ config('app.name') }}

<h1>{{ $user->full_name}}</h1>

Has sido registrado con los siguientes datos
@component('mail::table')
|                   |                    |
| ------------------|:------------------:|
| **Correo:**       | {{ $user->email}}  |
| **Contraseña:**   | {{ $password}}     |

Cualquier error en la información presente, favor de comunicarlo a tu administrador.

@endcomponent
@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
    Iniciar Sessión
@endcomponent


@endcomponent
