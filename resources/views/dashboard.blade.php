@vite('resources/css/app.css')
<div class="bg-customPink1 flex min-h-screen">
    <div class="w-1/5 bg-white text-black flex flex-col items-center p-4">
        <img src="{{ asset('img/logo_Journalit_square.png') }}" class="my-4" style="width: 80px; height: 80px;">
        
            <nav class="w-full">
                <ul>
                    <li class="border-b border-customPink3">
                        <a href="#" class="block px-4 py-2 font-bold hover:text-customPink3">Home</a>
                    </li>
                    <li class="border-b border-customPink3">
                        <a href="#journal" class="block px-4 py-2 font-bold hover:text-customPink3">Journal</a>
                    </li>
                </ul>
            </nav>
            <div class="img-fluid w-full h-8"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block px-4 py-2 font-bold text-red hover:text-customGray3">Logout</button>
            </form>
        
    </div>

    <div class="w-4/5 p-8">
        <h1 class="text-4xl font-bold mb-2">Hello, {{ Auth::user()->name }}!</h1>
        <h2 id="date-display" class="mb-6"></h2>

        <div class="bg-white rounded-2xl border-sm shadow-md">
            <div class="img-fluid w-full" style="height: 24px;"></div>
            <label class="block text-customGray2 text-center mb-2 p-2">How's your feeling today?</label>
            <div class="img-fluid w-full" style="height: 24px;"></div>
            <hr class="border-t border-customPink3">
            <div class="p-2 flex items-center">
                <img src="{{ asset('img/icon_pen.png') }}" style="width: 24px; height: 24px; margin-right: 8px;">
                <h2 class="flex-1 bg-white text-black rounded-lg">Tell us your story today</h2>
                <button onclick="location.href='/add-journal'" class="font-bold text-4xl hover:text-customPink3">
                    &raquo;
                </button>
            </div>
        </div>

        <div class="img-fluid w-4/5" style="height: 32px;"></div>

        <div class="bg-white rounded-2xl border-sm shadow-md p-4 text-center mb-6">
            <p class="text-customGray2 text-4xl mb-2">{{ $journalCount }}</p>
            <h2 class="text-customGray2">journals created</h2>
        </div>

        <div class="flex bg-white rounded-2xl border-none shadow-md mb-4">
            <input id="search-input" type="text" placeholder="Search" class="w-full p-2 border-none" style="margin-left: 16px;">
            <button class="p-2">
                <img src="{{ asset('img/icon_search.png') }}" style="width: 24px; height: 24px;">
            </button>
        </div>

        <div id="journal" class="space-y-4">
            @if ($journals->isEmpty())
                <div class="bg-white p-6 rounded-2xl shadow-md text-center">
                    <p class="text-customGray2">No journals found. Start by creating one!</p>
                </div>
            @else
                @foreach ($journals as $journal)
                    <div id="journal-{{ $journal->id }}" class="bg-white p-6 rounded-2xl shadow-md overflow-hidden" date-created="{{ $journal->created_at}}">
                        <div class="flex items-start mb-4 justify-center">
                            <div class="text-center mr-4">
                                <p class="text-gray-700">{{ $journal->created_at->format('D') }}</p>
                                <p class="text-2xl font-bold">{{ $journal->created_at->format('d') }}</p>
                                <p class="text-gray-700">{{ $journal->created_at->format('Y') }}</p>
                            </div>
                            <div class="flex-1 w-full">
                                @if ($journal->image)
                                    <img src="{{ asset('storage/' . $journal->image) }}" alt="Journal Image" class="rounded-lg max-h-24 w-full object-cover">
                                @endif
                                <h2 class="text-xl font-bold mb-2">{{ $journal->title }}</h2>
                                <p class="w-full">{{ $journal->description }}</p>
                            </div>
                            <button onclick="showPopup({{ $journal->id }})" class="p-2">
                                <img src="{{ asset('img/icon_more.png') }}" style="width: 24px; height: 24px; margin-right: 8px;">
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div id="popup-menu" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-4 rounded-2xl shadow-lg w-1/2">
        <ul>
            <li>
                <div class="flex" style="margin-top: 12px; margin-bottom: 12px;">
                    <img src="img/icon_calendar.png" style="width: 40px; height: 40px; padding: 4px;">
                    <p id="journal-date" class="px-4 py-2 text-gray-600"></p>
                </div>
            </li>
            <hr class="border-t border-customPink3">
            <li>
                <div class="flex" style="margin-top: 12px; margin-bottom: 12px;">
                    <img src="img/icon_pen.png" style="width: 40px; height: 40px; padding: 4px;">
                    @if (!$journals->isEmpty())    
                        <a id="edit-button" href="{{ url('/edit-journal/' . $journal->id) }}" class="block w-full text-left px-4 py-2 hover:text-customPink3">
                            Edit Journal
                        </a>
                    @else
                        <span class="block w-full text-left px-4 py-2 text-gray-500 cursor-not-allowed">
                            No Journal to Edit
                        </span>
                    @endif
                </div>
            </li>
            <hr class="border-t border-customPink3">
            <li>
                <div class="flex" style="margin-top: 12px; margin-bottom: 0px;">
                    <img src="img/icon_trash.png" style="width: 40px; height: 40px; padding: 4px;">
                    <form action="{{ route('journals.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="journal-id" id="journal-id">
                        <button id="delete-button" name="delete-button" type="submit" 
                            class="block w-full text-left text-black px-4 py-2 hover:text-customPink3">
                            Delete Journal
                        </button>
                    </form>
                </div>
            </li>
            <hr class="border-t border-customPink3">
        </ul>
        <button id="close-popup" 
            class="mt-4 bg-red-500 text-black px-4 py-2 rounded hover:text-customPink3">
            Close
        </button>
    </div>
</div>

<script>
    document.getElementById("date-display").innerText = new Date().toLocaleDateString('en-US', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    document.getElementById("search-input").addEventListener("input", function () {
        const keyword = this.value.toLowerCase();
        const journals = document.querySelectorAll("#journal .bg-white");

        journals.forEach(journal => {
            const text = journal.innerText.toLowerCase();
            journal.style.display = text.includes(keyword) ? "block" : "none";
        });
    });

    function showPopup(journalId) {
        const popupMenu = document.getElementById('popup-menu');
        const journalDate = document.getElementById('journal-date');
        const journalIdInput = document.getElementById('journal-id');
        const editButton = document.getElementById('edit-button');

        const journal = document.querySelector(`#journal-${journalId}`);
        if (journal && journalDate) {
            const dateStr = journal.getAttribute('date-created'); 
            const date = new Date(dateStr);
            journalDate.textContent = date.toLocaleString('en-US', {
                weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric'
            });
        }
        editButton.href = `/edit-journal/${journalId}`;
        journalIdInput.value = journalId;
        popupMenu.classList.remove('hidden');
    }

    document.getElementById('close-popup').addEventListener('click', function () {
        document.getElementById('popup-menu').classList.add('hidden');
    });
</script>