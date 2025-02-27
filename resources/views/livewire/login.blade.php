<!-- START: Login Modal -->
<div class="nk-modal modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="ion-android-close"></span>
                </button>
                <h4 class="mb-0">
                    <span class="text-main-1">Sign</span> In
                </h4>
                <div class="nk-gap-1"></div>
                <div>
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                
                    <form wire:submit.prevent="login" class="nk-form text-white">
                        <div class="row vertical-gap">
                            <div class="col-md-6">
                                Use email and password:
                                <div class="nk-gap"></div>
                                <input type="email" wire:model="email" name="email" class="form-control" placeholder="Email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                <div class="nk-gap"></div>
                                <input type="password" wire:model="password" name="password" class="form-control" placeholder="Password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                Or social account:
                                <div class="nk-gap"></div>
                                <ul class="nk-social-links-2">
                                    <li><a class="nk-social-facebook" href="#"><span class="fab fa-facebook"></span></a></li>
                                    <li><a class="nk-social-google-plus" href="#"><span class="fab fa-google-plus"></span></a></li>
                                    <li><a class="nk-social-twitter" href="#"><span class="fab fa-twitter"></span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="nk-gap-1"></div>
                        <div class="row vertical-gap">
                            <div class="col-md-6">
                                <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-block">Sign In</button>
                            </div>
                            <div class="col-md-6">
                                <div class="mnt-5">
                                    <small><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalForgotPassword">Forgot your password?</a></small>
                                </div>
                                <div class="mnt-5">
                                    <small><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalRegister">Not a member? Sign up</a></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- END: Login Modal -->

@script
<script>
    $wire.on('loginSuccessfull', () => {
        $('#modalLogin').modal('hide');
    });
</script>
@endscript