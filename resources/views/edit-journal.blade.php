@vite('resources/css/app.css')
<div class="mx-auto max-w-4xl p-8">
    <div class="flex justify-between">
        <button id="back-button" onclick="location.href='{{ route('dashboard') }}'" class="block hover:text-customPink3">
            <div class="flex" style="margin-top: 12px; margin-bottom: 12px;">
                <h1 class="text-left text-xl" style="margin-top: 4px;">&laquo; Back</h1>
            </div>
        </button>
        <button id="save-button" name="save-button" type="submit" form="journal-form" class="hidden">
            <img src="{{ asset('img/icon_save.png') }}" style="width: 40px; height: 40px; padding: 4px; margin-left: 8px; margin-right: 8px;">
        </button>
        <button id="edit-button" type="button" onclick="toggleEditMode(true)">
            <img src="{{ asset('img/icon_edit.png') }}" style="width: 40px; height: 40px; padding: 4px; margin-left: 8px; margin-right: 8px;">
        </button>
    </div>
    
    <div>
        <form id="journal-form" action="{{ route('update-journal', ['id_journal' => $journal->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input id="journal-title" name="title" required type="text" value="{{ old('title', $journal->title) }}" class="appearance-none focus:outline-none border-none w-full py-2 px-3 text-customGray3 text-4xl font-bold leading-tight" placeholder="Put your title here">
            <textarea id="journal-description" name="description" required rows="18" class="w-full text-gray-700 border-none p-4 focus:outline-none" placeholder="How's your feeling today?">{{ old('description', $journal->description) }}</textarea>
    
            <div id="gallery-preview" class="flex space-x-4">
                @if ($journal->image)
                    <img src="{{ asset('storage/' . $journal->image) }}" alt="Journal Image" class="rounded-lg max-h-24 object-cover">
                @endif
            </div>
            <div class="flex flex-col items-center">
                <div id="edit-tools" class="flex flex-col items-center hidden">
                    <div class="border-none shadow-lg rounded-lg flex justify-center" style="width: 240px;">
                        <label id="gallery-button" class="cursor-pointer">
                            <img src="{{ asset('img/icon_album.png') }}" style="width: 40px; height: 40px; padding: 4px; margin-left: 8px; margin-right: 8px;">
                            <input type="file" name="images" id="journal-images" accept="image/*" class="hidden">
                        </label>
                        <input id="journal-date" 
                            name="date" 
                            class="text-gray-700 pb-2 border-none focus:outline-none" 
                            type="date" 
                            value="{{ old('date', $journal->date) }}">
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>

<div id="popup-updated" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-4 rounded-2xl shadow-lg w-1/2 text-center">
        <p class="text-xl font-semibold">Journal Updated</p>
        <button id="ok-button" class="bg-customPink2 hover:bg-customPink3 text-white w-3/4 py-2 px-4 rounded-full focus:outline-none focus:shadow-outline" style="margin-top: 16px">OK</button>
    </div>
</div>

<div id="popup-max-image" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-4 rounded-2xl shadow-lg w-1/2 text-center">
        <p class="text-xl font-semibold">Max 1 image only</p>
        <button id="close-button" class="bg-customPink2 hover:bg-customPink3 text-white w-3/4 py-2 px-4 rounded-full focus:outline-none focus:shadow-outline" style="margin-top: 16px">Close</button>
    </div>
</div>

<script>
    function toggleEditMode(isEdit) {
        const inputs = document.querySelectorAll('#journal-title, #journal-description, #journal-images, #journal-date');
        const saveButton = document.getElementById('save-button');
        const editButton = document.getElementById('edit-button');
        const editTools = document.getElementById('edit-tools');

        inputs.forEach(input => input.disabled = !isEdit);
        editTools.style.display = isEdit ? 'block' : 'none';
        saveButton.style.display = isEdit ? 'inline-block' : 'none';
        editButton.style.display = isEdit ? 'none' : 'inline-block';
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleEditMode(false);
    });

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('journal-date').value = today;

    document.getElementById('ok-button').addEventListener('click', () => {
        window.location.href = '{{ route('dashboard') }}';
    });

    document.getElementById('close-button').addEventListener('click', () => {
        document.getElementById('popup-max-image').classList.add('hidden');
    });

    @if (session('updated'))
        document.getElementById('popup-updated').classList.remove('hidden');
    @endif

    let imageAdded = false;

    document.getElementById('journal-images').addEventListener('change', (e) => {
        const fileInput = e.target;
        const file = fileInput.files[0];
        const galleryPreview = document.getElementById('gallery-preview');

        if (file) {
            if (imageAdded) {
                document.getElementById('popup-max-image').classList.remove('hidden');
                return;
            }

            const imageUrl = URL.createObjectURL(file);
            const container = document.createElement('div');
            container.classList.add('relative', 'flex', 'items-start');
            container.innerHTML = `
                <img src="${imageUrl}" alt="Image preview" class="w-4/5 h-24 object-cover">
                <button type="button" class="absolute top-0 right-0 text-black" onclick="removeImage(this)">
                    <img src='{{ asset('img/icon_cross.png') }}' style="width: 24px; height: 24px" class="flex items-start">
                </button>
            `;
            galleryPreview.innerHTML = '';
            galleryPreview.appendChild(container);
            imageAdded = true;
        }
    });

    function removeImage(button) {
        const previewContainer = document.getElementById('gallery-preview');
        previewContainer.innerHTML = '';
        document.getElementById('journal-images').value = '';
        imageAdded = false;
    }
</script>