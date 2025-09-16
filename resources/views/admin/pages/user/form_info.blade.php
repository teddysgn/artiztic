<div class="col-md-7">
    <form id="main-form" method="POST" action="{{ route($controllerName) . '/save' }}" accept-charset="UTF-8"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Edit User Information</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) }}"
                            class="btn btn-sm btn-simple">Back to List
                        </a>
                        
                        @if (session('artiz_notify'))
                            <div class="alert alert-success">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                    aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                                {{ session('artiz_notify') }}
                            </div>
                            @endsession
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="Username" value="{{ old('username', $username) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Email" value="{{ old('email', $email) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control"
                                        placeholder="Full Name" value="{{ old('fullname', $fullname) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        @foreach ($statusValue as $key => $value)
                                            @if ($status == $key)
                                                <option value="{{ $key }}" selected>
                                                    {{ $value }}
                                                </option>
                                            @else
                                                <option value="{{ $key }}">
                                                    {{ $value }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="form-control" name="level" id="level">
                                        @foreach ($levelValue as $key => $value)
                                            @if ($level == $key)
                                                <option value="{{ $key }}" selected>
                                                    {{ $value }}
                                                </option>
                                            @else
                                                <option value="{{ $key }}">
                                                    {{ $value }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="btn btn-fill btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
