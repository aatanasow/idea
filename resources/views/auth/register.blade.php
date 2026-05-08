<x-layout>

    <x-form title="Register Now" description="Start tracking your ideas today">
        <form action="/register" method="post" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="Name" name="name" type="text" required />
            <x-form.field label="Email" name="email" type="email" required />
            <x-form.field label="Password" name="password" type="password" required />

            <div class="space-y-2 mt-8">
                <button type="submit" class="btn w-full h-10" data-test="register-button">Create account</button>
            </div>
        </form>
    </x-form>

</x-layout>
