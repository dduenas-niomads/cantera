@extends('layouts.app', ['class' => 'bg-dark'])

@section('nav-users')
active
@endsection

@section('content')
    @include('users.partials.header', [
        'title' => __('Módulo de usuarios'),
        'description' => __('Este es el perfil de ') . $user->name . __('. Puedes ver el progreso que ha hecho, administrar sus roles y accesos.'),
        'class' => 'col-lg-12'
    ])   

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-2"></div>
            <div class="col-xl-8">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Editar información') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('users.update', $user->id) }}" id="updateForm" autocomplete="off">
                            @csrf
                            @method('put')
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nombres completos') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese nombres completos') }}" value="{{ old('name', $user->name) }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-lastname">{{ __('Apellidos completos') }}</label>
                                    <input type="text" name="lastname" id="input-lastname" class="form-control {{ $errors->has('lastname') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese apellidos completos') }}" value="{{ old('lastname', $user->lastname) }}" required autofocus>
                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Teléfono') }}</label>
                                    <input type="text" name="phone" id="input-phone" 
                                        class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" 
                                        placeholder="{{ __('Ingrese número telefónico') }}" 
                                        value="{{ old('phone', $user->phone) }}" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('rols_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-rols_id">{{ __('Tipo de rol') }}</label>
                                    <select name="rols_id" class="form-control ">
                                        @foreach ($roles as $role)
                                            @if ((int)$user->rols_id === (int)$role->id)
                                                <option selected value="{{ $role->id }}"> {{ $role->name }} </option>
                                            @else
                                                <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rols_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('rols_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Correo electrónico') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Ingrese correo electrónico') }}" value="{{ old('email', $user->email) }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="button" onclick="submitFormLocal('updateForm');" class="btn btn-success mt-4">{{ __('Guardar cambios') }}</button>
                                    <button type="button" onclick="submitFormLocal('deleteForm', true);"  class="btn btn-danger mt-4">{{ __('Eliminar usuario') }}</button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('users.destroy', $user->id) }}" id="deleteForm" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <hr class="my-4" />
                        <form method="post" action="{{ route('users.password', $user->id) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Actualizar contraseña') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('Contraseña actual') }}</label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>
                                    
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Nueva contraseña') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>
                                    
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirmar nueva contraseña') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control " placeholder="{{ __('Confirm New Password') }}" value="" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Cambiar contraseña') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-2"></div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function submitFormLocal(formId, validation = false) {
        var form = document.getElementById(formId);
        if (validation) {
            var confirm = false;
            var confirm = window.confirm("¿Desea continuar con los cambios?");
            if (confirm) {
                form.submit();
            }
        } else {
            form.submit();
        }
    }
</script>
@endpush