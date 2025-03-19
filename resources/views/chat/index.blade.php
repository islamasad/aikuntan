<x-app-layout>

@include('partials.sidebar')

<!-- Content -->
<div class="relative h-screen w-full lg:ps-64">
  <div class="py-10 lg:py-14">
    <!-- Title -->
    <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto text-center">
      <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
        Welcome to ASADEV
      </h1>
      <p class="mt-3 text-gray-600 dark:text-neutral-400">
        Your GEMINI AI-powered copilot
      </p>
    </div>
    <!-- End Title -->
    <div id="chat-container" _="on htmx:afterSettle me.scrollTop = me.scrollHeight">
      <ul class="mt-16 space-y-5">
        
        @foreach($messages as $message)
          <x-chat-bubble 
              :sender="$message['sender']" 
              :contentType="'text'"
              :avatar="$message['avatar']"
          >
            {{ $message['content'] }}
          </x-chat-bubble>
        @endforeach

        @if(session('errors'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="text-red-600">
                    @foreach($errors->all() as $error) <!-- Tambahkan $ sebelum error -->
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif
      </ul>
    </div>
  </div>

  <!-- Textarea -->
  <div class="max-w-4xl mx-auto sticky bottom-0 z-10 p-3 sm:py-6">
    <div class="lg:hidden flex justify-end mb-2 sm:mb-3">
      
      <!-- Sidebar Toggle -->
      <button type="button" class="p-2 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar" aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
        <span>Sidebar</span>
      </button>
      <!-- End Sidebar Toggle -->
    </div>

    <!-- Input -->
    <div class="relative">
      <form 
        hx-post="{{ route('chat.ask') }}"
        hx-target="#chat-container ul"
        hx-swap="beforeend"
        hx-indicator="#loading-spinner"
      >
      @csrf
        <textarea type="text" name="prompt" class="p-4 pb-12 block w-full bg-gray-100 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Ask me anything..."></textarea>

        <!-- Toolbar -->
        <div class="absolute bottom-px inset-x-px p-2 rounded-b-lg bg-gray-100 dark:bg-neutral-800">
          <div class="flex justify-between items-center">
            <!-- Button Group -->
            <div class="flex items-center">
              <!-- Mic Button -->
              <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-white focus:z-10 focus:outline-none focus:bg-white dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="9" x2="15" y1="15" y2="9"/></svg>
              </button>
              <!-- End Mic Button -->

              <!-- Attach Button -->
              <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-white focus:z-10 focus:outline-none focus:bg-white dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
              </button>
              <!-- End Attach Button -->
            </div>
            <!-- End Button Group -->

            <!-- Button Group -->
            <div class="flex items-center gap-x-1">
              <!-- Mic Button -->
              <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-white focus:z-10 focus:outline-none focus:bg-white dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/></svg>
              </button>
              <!-- End Mic Button -->

              <!-- Send Button -->
              <button type="submit" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-none focus:bg-blue-500">
                <!-- Send Icon -->
                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                </svg>
              </button>
              <!-- Loading Spinner -->
              <svg id="loading-spinner" class="htmx-indicator animate-spin h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/>
                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z"/>
              </svg>
              <!-- End Send Button -->

            </div>
            <!-- End Button Group -->
          </div>
        </div>
        <!-- End Toolbar -->
      </div>
      <!-- End Input -->
      </form>
    </div>
    <!-- End Input -->
    
  <!-- End Textarea -->
</div>
<!-- End Content -->
<script>
  document.body.addEventListener('htmx:afterRequest', function(evt) {
    // Pastikan event berasal dari form yang ingin di-reset
    if (evt.detail.elt.tagName.toLowerCase() === 'form') {
      evt.detail.elt.reset();
    }
  });
</script>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle copy button
    document.querySelectorAll('[data-copy]').forEach(button => {
        button.addEventListener('click', function() {
            const text = this.parentElement.querySelector('.chat-content').innerText;
            navigator.clipboard.writeText(text);
        });
    });
});
</script>

@endpush

</x-app-layout>