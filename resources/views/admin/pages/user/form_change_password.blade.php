<div class="col-md-5">
    <form id="main-form" method="POST" action="{{ route($controllerName) . '/change-password' }}" accept-charset="UTF-8"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Edit User Password</h4>
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
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" value="{{ old('password', $password) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control" placeholder="Password"
                                        value="{{ old('password_confirmation', $password) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="task" value="edit-password">
                        <button type="submit" class="btn btn-fill btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
