<x-app-layout>

    <div class="flex flex-col items-center justify-center min-h-screen ">
        <div class="p-8 text-center">
            <div class="flex justify-center mb-10">

                <img src="img/pending-icon.svg" alt="" class="h-52">
            </div>
           
                <h1 class="text-xl font-semibold mb-3 text-orange-500">Account Pending Approval</h1>
                <p class="text-gray-600 mb-4 text-sm">
                    Your Google account has been registered but is pending admin approval.
                    You’ll be notified once your access is activated.
                </p>

            {{-- <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-blue-600 hover:underline">
                Log out
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form> --}}
        </div>
    </div>

</x-app-layout>
