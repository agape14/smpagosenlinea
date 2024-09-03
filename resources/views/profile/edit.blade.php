@extends('layouts.mazer-admin')


@section('content')
    <div class="row my-2">
        <div class="col-12 col-md-4">
            <div class="card">
                <form action="{{ route('profile.update', Auth::user()) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Mi perfil</h4>
                        </div>
                        <!-- <div class="header-title"><button type="submit" class="btn btn-success">save</button></div> -->
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <!-- <div class="crm-profile-img-edit position-relative">
                                <img id="output" class="img-fluid rounded avatar-100"
                                    src="{{ asset('storage/' . $user->photo) }}" alt="">
                                <div class="crm-p-image ">
                                    <i class="las la-pen upload-button"></i>
                                    <input class="file-upload btn btn-outline-primary" type="file" onchange="loadFile(event)" name="photo"
                                        accept="image/*">
                                </div>


                                <script>
                                    var loadFile = function(event) {
                                        var reader = new FileReader();
                                        reader.onload = function() {
                                            var output = document.getElementById('output');
                                            output.src = reader.result;
                                        };
                                        reader.readAsDataURL(event.target.files[0]);
                                    };
                                </script>
                            </div> -->
                            <!-- <div class="img-extension mt-3">
                                <div class="d-inline-block align-items-center">
                                    <span>Only</span>
                                    <a href="javascript:void();">.jpg</a>
                                    <a href="javascript:void();">.png</a>
                                    <a href="javascript:void();">.jpeg</a>
                                    <span>allowed</span>
                                </div>
                            </div> -->
                        </div>

                        <div class="form-group">
                            <label for="furl">Contribuyente:</label>
                            <input type="text" name="name" class="form-control" id="furl" placeholder="Nombre"
                                value="{{ $user->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="turl">Email:</label>
                            <input type="text" name="email" class="form-control" id="turl" placeholder="Login Email"
                                value="{{ $user->email }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card">
                <form action="{{ route('profile.updatePassword', Auth::user()) }}" method="POST">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Cambiar contraseña</h4>
                        </div>
                        <div class="header-title"><button type="submit" class="btn btn-success">Guardar</button></div>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="furl">Contraseña actual:</label>
                            <input type="password" name="old_password" class="form-control" id="furl"
                                placeholder="Contraseña actual">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="turl">Nueva contraseña:</label>
                            <input type="password" name="password" class="form-control" id="turl"
                                placeholder="Nueva contraseña">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="turl">Confirmar nueva contraseña:</label>
                            <input type="password" name="password_confirmation" class="form-control" id="turl"
                                placeholder="Confirmar contraseña">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
