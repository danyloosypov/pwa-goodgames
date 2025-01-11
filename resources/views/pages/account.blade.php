<x-layout>
    <div class="nk-gap-2"></div>
    <div class="container mt-5">
        <h2>Account Settings</h2>

        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('api-user-edit', [], false) }}" onsubmit="user_edit(this)">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        <div class="input-error text-danger" style="display: none;"></div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        <div class="input-error text-danger" style="display: none;"></div>
                    </div>

                    <!-- Avatar -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                        <div class="input-error text-danger" style="display: none;"></div>  

                        @if (auth()->user()->avatar)
                            <div class="mt-3">
                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" width="100" class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                    <div class="nk-gap"></div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <div class="nk-gap"></div>

                    <div class="account-answer success text-success" style="display: none;">Profile updated successfully.</div>
                    <div class="account-answer error text-danger" style="display: none;">There was an error updating your profile.</div>
                </form>


                
            </div>
            <div class="col-md-4 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Logout</h5>
                        <p class="card-text">You can log out of your account from here.</p>
                        <button onclick="logout('{{ route('api-logout', [], false) }}')" class="btn btn-danger">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-gap-2"></div>

    <x-slot name="metaTitle">
        {{-- {{ $metaTitle }} --}}
    </x-slot>

    <x-slot name="metaDescription">
        {{-- {{ $metaDescription }} --}}
    </x-slot>

    <x-slot name="javascript">
        <script>
            async function user_edit(form) {
    
                event.preventDefault()
    
                const route = form.getAttribute('action')
    
                const data = {
                    name: form.elements['name'].value,
                    email: form.elements['email'].value,
                };

                if (form.elements['avatar'].files.length > 0) {
                    const avatarFile = form.elements['avatar'].files[0];

                    const avatarData = await fileToBase64(avatarFile);
                    data.avatar = avatarData;
                }
    
                const response = await req.post(route, data, true)
    
                if (response.success) {
                    form.querySelector('.account-answer.success').style.display = 'block'
                    form.querySelector('.account-answer.error').style.display = 'none'
                } else {
                    if (response.data.errors) {
    
                        for (const [key, error] of Object.entries(response.data.errors)) {
                            const errorElement = form.elements[key].parentElement.querySelector('.input-error')
                            errorElement.innerText = error
                            errorElement.style.display = 'block'
                        }
    
                    } else {
                        form.querySelector('.account-answer.success').style.display = 'none'
                        form.querySelector('.account-answer.error').style.display = 'block'	
                    }
                }
            }

            function fileToBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            }
        </script>
    </x-slot>

</x-layout>

