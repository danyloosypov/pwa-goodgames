<div class="nk-widget-content">
    <form wire:submit.prevent="submit" class="nk-form">
        <div class="row vertical-gap sm-gap">
            <div class="col-md-6">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       wire:model="email" placeholder="Email *" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       wire:model="name" placeholder="Name *" required>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="nk-gap"></div>
        <textarea class="form-control @error('message') is-invalid @enderror" 
                  wire:model="message" rows="5" placeholder="Message *" required></textarea>
        @error('message') <span class="error">{{ $message }}</span> @enderror
        <div class="nk-gap-1"></div>
        <button class="nk-btn nk-btn-rounded nk-btn-color-white" type="submit">
            <span>Send</span>
            <span class="icon">
                <i class="ion-paper-airplane"></i>
            </span>
        </button>
        @if (session()->has('success'))
            <div class="nk-form-response-success">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>
