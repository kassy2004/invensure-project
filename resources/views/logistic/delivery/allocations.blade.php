<div>
    <h1 class="text-lg font-semibold text-zinc-900">
        Allocation Management
    </h1>
    <h4 class="text-zinc-700">Complete logistics management from allocation to delivery</h4>

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

    window.addEventListener('scroll', () => {
        if (loading) return;

        const scrollTop = window.scrollY;
        const windowHeight = window.innerHeight;
        const fullHeight = document.documentElement.scrollHeight;

        if (scrollTop + windowHeight >= fullHeight - 100) {
            loading = true;
            page++;

            document.getElementById('loader').classList.remove('hidden');

            fetch(`?page=${page}`, {
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