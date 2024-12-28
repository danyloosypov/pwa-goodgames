<div class="nk-modal modal fade" id="modalForgotPassword" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="ion-android-close"></span>
                </button>

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if($isCodeSent && !$isCodeVerified)
                    <h4 class="mb-0">Verify Code</h4>
                    <div class="nk-gap-1"></div>

                    @if ($errorMessage)
                        <span class="text-danger">{{ $errorMessage }}</span>
                    @endif

                    <form wire:submit.prevent="verifyCode" class="nk-form">
                        <input type="text" wire:model="code" class="form-control" placeholder="Enter verification code">
                        @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="nk-gap"></div>
                        <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-block">Verify Code</button>
                    </form>

                @elseif($isCodeVerified)
                    <h4 class="mb-0">Reset Your Password</h4>
                    <div class="nk-gap-1"></div>

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="resetPassword" class="nk-form">
                        <input type="password" wire:model="password" class="form-control" placeholder="New Password">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                        <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Confirm Password">
                        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror

                        <div class="nk-gap"></div>
                        <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-block">Reset Password</button>
                    </form>

                @else
                    <h4 class="mb-0">Forgot Password</h4>
                    <div class="nk-gap-1"></div>

                    <form wire:submit.prevent="sendResetCode" class="nk-form">
                        <input type="email" wire:model="email" class="form-control" placeholder="Enter your email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="nk-gap"></div>
                        <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-block">Send Reset Code</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('passwordResetSuccess', () => {
        $('#modalForgotPassword').modal('hide');

        $('#modalLogin').modal('show');
    });
</script>
@endscript