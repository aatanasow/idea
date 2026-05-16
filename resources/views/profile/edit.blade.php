<x-layout>

    <x-form title="Edit your account" description="Need to make a change?">
        <form action="/profile" method="post" class="mt-10 space-y-4">
            @csrf
            @method('PATCH')

            <x-form.field label="Name" name="name" type="text" required :value="$user->name" />
            <x-form.field label="Email" name="email" type="email" required :value="$user->email" />
            <x-form.field label="New Password" name="password" type="password" />

            <div class="space-y-2 mt-8">
                <button type="submit" class="btn w-full h-10" data-test="register-button">Update account</button>
            </div>
        </form>
    </x-form>

</x-layout>
