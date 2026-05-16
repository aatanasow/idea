@props(['idea' => new \App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit idea' : 'New idea' }}">

    <form
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        id="modal-form"
        method="POST"
        {{-- enctype="multipart/form-data" --}}
    >
        @csrf
        @if ($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">

            <x-form.field
                label="Title"
                name="title"
                placeholder="Enter an idea for your title"
                autofocus
                required
                :value="$idea->title"
            />

            <div class="space-y-2">
                <label class="label">Status</label>

                {{-- <div class="flex gap-x-3">
                    @foreach (App\IdeaStatus::cases() as $status)

                        <button class="btn flex-1 h-10 btn-outlined">
                            {{ $status->label() }}
                        </button>

                    @endforeach

                </div> --}}

                <div class="flex gap-x-3">

                    @foreach (App\IdeaStatus::cases() as $status)
                        <input class="hidden" id="{{ $status->value }}" type="radio" name="status" value="{{ $status->value }}"  {{ $status->value === old('status', $idea->status->value) ? 'checked' : '' }}>
                        <label
                            class="flex flex-1 h-10 justify-center items-center"
                            for="{{ $status->value }}"
                            data-test="button-status-{{ $status->value }}"
                        >
                            {{ $status->label() }}
                        </label>
                    @endforeach

                </div>

                <x-form.error name='status' />

            </div>

            <x-form.field
                label="Description"
                name="description"
                type="textarea"
                placeholder="Describe your idea"
                :value="$idea->description"
            />

            <div class="space-y-2">
                <label for="image" class="label">Featured image</label>


                @if ($idea->image_path)
                <div class="space-y-2">
                    <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-48 object-cover rounded-b-md">
                    <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove image</button>
                </div>
                @endif

                <input type="file" name="image" id="image" accept="image/*">
                <x-form.error name='image' />
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legent class="label">Actionable Steps</legent>

                    <template id="template-step">
                        <div class="flex gap-x-2 items-center">
                            <input type="text" name="steps[][description]" class="input">
                            <input type="hidden" name="steps[][completed]" class="input" value="0">

                            <button
                                type="button"
                                aria-label="Remove a step"
                                id="remove-step-button"
                                class="form-muted-icon"
                                onclick="remove_line(this.parentNode)"
                            >
                                <x-icons.close />
                            </button>
                        </div>
                    </template>

                    <div id="steps" class="space-y-2 pb-2">

                        @if (old('steps', $idea->steps))

                        @foreach (old('steps', $idea->steps) as $index => $step)
                            <div class="flex gap-x-2 items-center">
                                <input type="text" name="steps[{{ $index }}][description]" class="input" value="{{ $step->description }}">
                                <input type="hidden" name="steps[{{ $index }}][completed]" class="input" value="{{ $step->completed }}">

                                <button
                                    type="button"
                                    aria-label="Remove a step"
                                    id="remove-step-button"
                                    class="form-muted-icon"
                                    onclick="remove_line(this.parentNode)"
                                >
                                    <x-icons.close />
                                </button>
                            </div>
                        @endforeach

                        @endif

                    </div>

                    <div class="flex gap-x-2 items-center">
                        <input
                            type="text"
                            id="new-step"
                            data-test="new-step"
                            placeholder="What need to be done?"
                            class="input flex-1"
                            spellcheck="false"
                        >
                        <button
                            type="button"
                            aria-label="Add a new step"
                            id="new-step-button"
                            data-test="new-step-button"
                            class="form-muted-icon"
                            disabled
                        >
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>

                    <script>
                        const new_step = document.getElementById("new-step");
                        const new_step_button = document.getElementById("new-step-button");
                        new_step.addEventListener("input", success);
                        new_step_button.addEventListener("click", add_new_line);
                        function success() {
                            new_step_button.disabled = new_step.value==="" ? true : false;
                        }

                        const steps = document.getElementById("steps");
                        const template_step = document.getElementById("template-step");
                        function add_new_line(){
                            if(new_step.value!==""){
                                let num = steps.childElementCount;
                                const clone = document.importNode(template_step.content, true);
                                let input = clone.querySelector("input[type=text]");
                                let inputh = clone.querySelector("input[type=hidden]");
                                input.value = new_step.value;
                                input.name = "steps["+num+"][description]";
                                inputh.name = "steps["+num+"][completed]";
                                steps.appendChild(clone);
                                new_step.value="";
                            }

                        }
                        function remove_line(node){
                            return node.remove();
                        }
                        const image = document.getElementById("image");
                        const form = document.getElementById("modal-form");
                        image.addEventListener("input", activateEnctype);
                        function activateEnctype(){
                            form.enctype="multipart/form-data";
                        }
                    </script>

                </fieldset>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legent class="label">Links</legent>

                    <template id="template-link">
                        <div class="flex gap-x-2 items-center">
                            <input type="text" name="links[]" class="input">

                            <button
                                type="button"
                                aria-label="Remove a link"
                                id="remove-link-button"
                                class="form-muted-icon"
                                onclick="remove_line(this.parentNode)"
                            >
                                <x-icons.close />
                            </button>
                        </div>
                    </template>

                    <div id="links" class="space-y-2 pb-2">

                        @if (old('links', $idea->links))

                        @foreach (old('links', $idea->links) as $link)
                            <div class="flex gap-x-2 items-center">
                                <input type="text" name="links[]" class="input" value="{{ $link }}">

                                <button
                                    type="button"
                                    aria-label="Remove a link"
                                    id="remove-link-button"
                                    class="form-muted-icon"
                                    onclick="remove_line(this.parentNode)"
                                >
                                    <x-icons.close />
                                </button>
                            </div>
                        @endforeach

                        @endif

                    </div>

                    <div class="flex gap-x-2 items-center">
                        <input
                            type="url"
                            id="new-link"
                            data-test="new-link"
                            placeholder="https://example.com"
                            autocomplete="url"
                            class="input flex-1"
                            spellcheck="false"
                        >
                        <button
                            type="button"
                            aria-label="Add a new link"
                            id="new-link-button"
                            data-test="new-link-button"
                            class="form-muted-icon"
                            disabled
                        >
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>

                    <script>
                        const new_link = document.getElementById("new-link");
                        const new_link_button = document.getElementById("new-link-button");
                        new_link.addEventListener("input", success);
                        new_link_button.addEventListener("click", add_new_line);
                        function success() {
                            new_link_button.disabled = new_link.value==="" ? true : false;
                        }

                        const links = document.getElementById("links");
                        const template_link = document.getElementById("template-link");
                        function add_new_line(){
                            if(new_link.value!==""){
                                const clone = document.importNode(template_link.content, true);
                                let input = clone.querySelector("input");
                                input.value = new_link.value;
                                links.appendChild(clone);
                                new_link.value="";
                            }

                        }
                        function remove_line(node){
                            return node.remove();
                        }
                    </script>

                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button type="button" id="cancel">Cancel</button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>

        </div>

    </form>

    @if ($idea->image_path)
        <form action="{{ route('idea.image.destroy', $idea) }}" method="POST" id="delete-image-form">
            @csrf
            @method('DELETE')

        </form>
    @endif


</x-modal>
