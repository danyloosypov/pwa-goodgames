<div class="nk-modal modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="ion-android-close"></span>
                </button>
                <h4 class="mb-0">
                    <span class="text-main-1">Sign</span> Up
                </h4>
                <div class="nk-gap-1"></div>
                <form wire:submit.prevent="register" class="nk-form text-white">
                    <div class="nk-gap"></div>

                    <!-- Name -->
                    <input type="text" wire:model.defer="name" class="form-control" placeholder="Name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="nk-gap"></div>

                    <!-- Email -->
                    <input type="email" wire:model.defer="email" class="form-control" placeholder="Email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="nk-gap"></div>

                    <!-- Password -->
                    <input type="password" wire:model.defer="password" class="form-control" placeholder="Password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="nk-gap"></div>

                    <!-- Confirm Password -->
                    <input type="password" wire:model.defer="password_confirmation" class="form-control" placeholder="Confirm Password">
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="nk-gap"></div>

                    <!-- Avatar Upload -->
                    <input type="file" wire:model="avatar" class="form-control">
                    @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror

                    <div class="nk-gap"></div>

                    <!-- Avatar Preview -->
                    @if ($avatar)
                        <div class="nk-gap"></div>
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar Preview" class="img-thumbnail">
                        <div class="nk-gap"></div>
                    @endif

                    <div class="nk-gap-1"></div>

                    <div class="row vertical-gap">
                        <div class="col-md-6">
                            <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-block">Sign Up</button>
                        </div>
                        <div class="col-md-6">
                            <div class="mnt-5">
                                <small>
                                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalLogin">Already have an account? Sign In</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@script
<script>
    $wire.on('registerSuccessfull', () => {
        $('#modalRegister').modal('hide');
    });
</script>
@endscript