<x-layout>

    <x-form title="Log In" description="Glad to have you back">
        <form action="/login" method="post" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Email" name="email" type="email" required />
            <x-form.field label="Password" name="password" type="password" required />

            <div class="space-y-2 mt-8">
                <button type="submit" class="btn w-full h-10" data-test="login-button">Login</button>
            </div>
        </form>
    </x-form>

</x-layout>
