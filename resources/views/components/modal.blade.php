@props(['name','title'])

<div
    class="fixed inset-0 z-50  items-center justify-center bg-black/50 backdrop-blur-xs hidden"
    id="modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-{{ $name }}-title"
    tabindex="-1"
>
    <x-card class="shadow-xl max-w-2xl w-full max-h-[80dvh] overflow-auto">
        <div class="flex justify-between items-center">
            <h2 id="modal-{{ $name }}-title" class="text-xl font-bold">{{ $title }}</h2>

            <button aria-label="close modal" id="close">
                <x-icons.close />

            </button>
        </div>
        <div class="mt-4">
            {{ $slot }}
        </div>
    </x-card>
</div>

<script>
    let modal = document.getElementById("modal");
    let btn = document.getElementById("btn");
    let close = document.getElementById("close");
    let cancel = document.getElementById("cancel");
    btn.onclick = function() {
        modal.style.display = "flex";
    }
    close.onclick = function() {
        modal.style.display = "none";
    }
    cancel.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
