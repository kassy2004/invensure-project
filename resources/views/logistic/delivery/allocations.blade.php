<div>
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-lg font-semibold text-zinc-900">
                Allocation Management
            </h1>
            <h4 class="text-zinc-700">Complete logistics management from allocation to delivery</h4>
        </div>

        {{-- <button id="sortToggleBtn"
            class="px-4 py-2 text-sm bg-zinc-200 hover:bg-zinc-300 text-zinc-700 rounded-md border border-zinc-300 transition">
            Sort by Allocation ID
        </button> --}}
        <div class="flex gap-3 text-sm items-center">
            <span class="text-zinc-600 text-sm">Sort by</span>
            <a href="{{ url('/operations?sort=asc') }}" onclick="resetPagination()"
                class="px-4 py-2 rounded-lg transition flex items-center gap-1
        {{ request('sort') === 'asc' ? 'bg-orange-500 text-white hover:bg-orange-600' : 'text-zinc-600 border hover:border-orange-500' }}">
                <x-lucide-arrow-up-0-1 class="h-4 w-4 " />
                <span>Asc</span>
            </a>

            <a href="{{ url('/operations?sort=desc') }}" onclick="resetPagination()"
                class="px-4 py-2 rounded-lg transition flex items-center gap-1
        {{ request('sort') === 'desc' ? 'bg-orange-500 text-white hover:bg-orange-600' : 'text-zinc-600 border hover:border-orange-500 ' }}">
                <x-lucide-arrow-down-1-0 class="h-4 w-4 " />
                <span>Desc</span>
            </a>
        </div>

    </div>

    {{-- Loop --}}
    <div id="allocation-container">
        @include('logistic.partials._allocations', ['allocations' => $allocations])
    </div>

    <div id="loader" class="text-center mt-5 hidden text-zinc-500">
        <span>Loading...</span>
    </div>
</div>
<script>
    let page = 1;
    let loading = false;

    // Get current sort parameter from URL
    function getCurrentSort() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('sort') || '';
    }

    // Reset pagination when sorting changes
    function resetPagination() {
        page = 1;
        // Clear existing content and start fresh
        document.getElementById('allocation-container').innerHTML = '';
        // The page will reload with new sorting, so this is just a safety measure
    }

    window.addEventListener('scroll', () => {
        if (loading) return;

        const scrollTop = window.scrollY;
        const windowHeight = window.innerHeight;
        const fullHeight = document.documentElement.scrollHeight;

        if (scrollTop + windowHeight >= fullHeight - 100) {
            loading = true;
            page++;

            document.getElementById('loader').classList.remove('hidden');

            // Build query string with sort parameter
            const sort = getCurrentSort();
            const queryString = sort ? `?page=${page}&sort=${sort}` : `?page=${page}`;

            fetch(queryString, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('allocation-container').insertAdjacentHTML('beforeend', html);
                    loading = false;
                    document.getElementById('loader').classList.add('hidden');
                })
                .catch(() => {
                    loading = false;
                    document.getElementById('loader').classList.add('hidden');
                });
        }
    });
</script>
<script>
    document.querySelectorAll("[id^='signature']").forEach(canvas => {
        const id = canvas.id.replace("signature", "");
        const signaturePad = new SignaturePad(canvas);

        function resizeCanvas() {
            const ratio = window.devicePixelRatio || 1;
            const styles = getComputedStyle(canvas);
            const width = parseInt(styles.width);
            const height = parseInt(styles.height);

            canvas.width = width * ratio;
            canvas.height = height * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            signaturePad.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        document.getElementById(`clear${id}`).addEventListener("click", () => {
            signaturePad.clear();
        });

        document.getElementById(`save${id}`).addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature.");
                return;
            }
            const dataURL = signaturePad.toDataURL();
            const img = document.getElementById(`signature-image${id}`);
            img.src = dataURL;
            img.classList.remove("hidden");
        });
    });
</script>
