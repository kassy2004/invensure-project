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

