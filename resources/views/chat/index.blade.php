<x-app-layout>
  @include('partials.sidebar')

  <!-- Content -->
  <div class="relative h-screen w-full lg:ps-64 dark:bg-neutral-900">
    <div class="py-10 lg:py-14 dark:bg-neutral-900">
      <!-- Title -->
      <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto text-center">
        <h1 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
          Welcome to ASADEV
        </h1>
        <p class="mt-3 text-gray-600 dark:text-neutral-400">
          Your GEMINI AI-powered Accounting copilot
        </p>
      </div>
      <!-- End Title -->
      <div id="chat-container" _="on htmx:afterSettle me.scrollTop = me.scrollHeight">
        <ul  id="chat-box" class="mt-16 space-y-5 dark:text-white">
          @foreach($messages as $key => $message)
            @if($key !== 0)
              <x-chat-bubble 
                :sender="$message['sender']" 
                :contentType="'text'"
                :key="$loop->index"
              >
                {!! $message['content'] !!}
              </x-chat-bubble>
            @endif
          @endforeach

          @if(session('errors'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg dark:bg-neutral-800">
              <div class="text-red-600">
                @foreach($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              </div>
            </div>
          @endif
        </ul>
      </div>
    </div>

    <!-- Textarea -->
    <div class="max-w-4xl mx-auto sticky bottom-0 z-10 p-3 sm:py-6 dark:bg-neutral-900">
      <div class="lg:hidden flex justify-end mb-2 sm:mb-3">
        <!-- Sidebar Toggle -->
        <button type="button" class="p-2 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar" aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" x2="21" y1="6" y2="6"/>
            <line x1="3" x2="21" y1="12" y2="12"/>
            <line x1="3" x2="21" y1="18" y2="18"/>
          </svg>
          <span>Sidebar</span>
        </button>
        <!-- End Sidebar Toggle -->
      </div>

      <!-- Input -->
      <div class="relative dark:bg-neutral-900">
        <form 
          id="chat-form"
          hx-post="{{ route('chat.ask') }}"
          hx-target="#chat-box"
          hx-swap="none"
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
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                    <line x1="9" x2="15" y1="15" y2="9"/>
                  </svg>
                </button>
                <!-- End Mic Button -->

                <!-- Attach Button -->
                <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-white focus:z-10 focus:outline-none focus:bg-white dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                  </svg>
                </button>
                <!-- End Attach Button -->
              
              </div>
              <!-- End Button Group -->

              <!-- Button Group -->
              <div class="flex items-center gap-x-1">
                <!-- Mic Button -->
                <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-white focus:z-10 focus:outline-none focus:bg-white dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                    <line x1="12" x2="12" y1="19" y2="22"/>
                  </svg>
                </button>
                <!-- End Mic Button -->

                <!-- Tombol Send dan Spinner -->
                <button type="submit" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-none focus:bg-blue-500">
                  <!-- Ikon Send -->
                  <svg id="send-icon" class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                  </svg>
                  <!-- Spinner (tersembunyi secara default) -->
                  <svg id="loading-spinner" class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="currentColor">
                    <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/>
                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z"/>
                  </svg>
                </button>
              </div>
              <!-- End Button Group -->
            </div>
          </div>
          <!-- End Toolbar -->
        </form>
      </div>
      <!-- End Input -->
    </div>
    <!-- End Textarea -->
  </div>
  <!-- End Content -->

  <script>
    document.body.addEventListener('htmx:afterRequest', function(evt) {
      if (evt.detail.elt.id === 'chat-form') {
        evt.detail.elt.reset();
      }
    });
  </script>

  <script>
    const chatContainer = document.getElementById("chat-container");
    const observer = new MutationObserver((mutations) => {
      mutations.forEach(mutation => {
        if (mutation.addedNodes.length) {
          chatContainer.scrollTo({
            top: chatContainer.scrollHeight,
            behavior: 'smooth'
          });
        }
      });
    });

    observer.observe(chatContainer, {
      childList: true,
      subtree: true
    });

  </script>

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

  <!-- Script untuk toggle ikon send dan spinner -->
  <script>
    // Sebelum request dikirim, tampilkan spinner dan sembunyikan ikon send
    document.body.addEventListener('htmx:beforeRequest', function(evt) {
      const form = evt.detail.elt;
      // Pastikan event berasal dari form yang relevan
      if (form.tagName.toLowerCase() === 'form') {
        const sendIcon = form.querySelector('#send-icon');
        const spinner = form.querySelector('#loading-spinner');
        if (sendIcon && spinner) {
          sendIcon.classList.add('hidden');
          spinner.classList.remove('hidden');
        }
      }
    });

    // Setelah request selesai, kembalikan tampilan ikon send dan sembunyikan spinner
    document.body.addEventListener('htmx:afterRequest', function(evt) {
      const form = evt.detail.elt;
      
      if (form.tagName.toLowerCase() === 'form') {
        const sendIcon = form.querySelector('#send-icon');
        const spinner = form.querySelector('#loading-spinner');
        if (sendIcon && spinner) {
          sendIcon.classList.remove('hidden');
          spinner.classList.add('hidden');
        }
      }
    });
  </script>

  <script>
    document.addEventListener("htmx:afterRequest", function (event) {
      // Pastikan respons berasal dari form chat
      if (event.detail.elt.id === "chat-form") {
        // Parse respons JSON yang dikirim dari /chat/ask
        const response = JSON.parse(event.detail.xhr.responseText);
        const decodedPrompt = response.prompt;
        window.authUser = @json(Auth::user()->name);
        
        // Tambahkan chat bubble untuk prompt pengguna (jika belum ada)
        // Misalnya, jika Anda ingin menampilkan prompt sebagai chat bubble:
        const userBubbleHTML = `
          <li class="max-w-4xl py-2 px-4 sm:px-6 lg:px-8 mx-auto flex gap-x-2 sm:gap-x-4 flex-row-reverse">
            <span class="shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-gray-600">
              <span class="text-sm font-medium text-white leading-none">${window.authUser.charAt(0).toUpperCase()}</span>
            </span>
            <div class="grow max-w-[90%] md:max-w-2xl w-full space-y-3 text-right bg-gray-100 dark:bg-neutral-800 rounded-md py-2 px-2">
              <div class="space-y-3">
                <p class="text-sm text-gray-800 dark:text-white">
                  ${decodedPrompt}
                </p>
              </div>
            </div>
          </li>
        `;
        document.getElementById("chat-box").insertAdjacentHTML('beforeend', userBubbleHTML);
        
        // Inisiasi koneksi SSE dengan URL dari respons
        const streamUrl = response.stream_url;
        const eventSource = new EventSource(streamUrl);
        let finalMessage = ""; // Untuk menggabungkan seluruh chunk
        let botBubble = null; // Referensi elemen chat bubble bot
        let contentId = "";   // Akan diisi saat botBubble dibuat
        let spinnerId = "";   // Akan diisi saat botBubble dibuat
        let spinnerTimeout;

        eventSource.onmessage = function (e) {
          const data = JSON.parse(e.data);
          if (data.error) {
            alert(data.error);
            eventSource.close();
          } else {
            // Jika botBubble belum dibuat, buat satu kali saja dan simpan ID-nya
            if (!botBubble) {
              const bubbleId = `bot-bubble-${Date.now()}`;
              contentId = `bot-content-${bubbleId}`;
              spinnerId = `bot-spinner-${bubbleId}`;
                  
              botBubble = document.createElement("li");
              botBubble.id = bubbleId;
              botBubble.className = "max-w-4xl py-2 px-4 sm:px-6 lg:px-8 mx-auto flex gap-x-2 sm:gap-x-4 justify-start animate-chatMessageEnter";
              botBubble.innerHTML = `
                <svg class="shrink-0 size-[38px] rounded-full" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="38" height="38" rx="6" fill="#2563EB"></rect>
                  <path d="M10 28V18.64C10 13.8683 14.0294 10 19 10C23.9706 10 28 13.8683 28 18.64C28 23.4117 23.9706 27.28 19 27.28H18.25" stroke="white" stroke-width="1.5"></path>
                  <path d="M13 28V18.7552C13 15.5104 15.6863 12.88 19 12.88C22.3137 12.88 25 15.5104 25 18.7552C25 22 22.3137 24.6304 19 24.6304H18.25" stroke="white" stroke-width="1.5"></path>
                  <ellipse cx="19" cy="18.6554" rx="3.75" ry="3.6" fill="white"></ellipse>
                </svg>
                <div class="grow max-w-[90%] md:max-w-2xl w-full space-y-3">
                  <div class="space-y-3">
                    <p class="text-sm text-gray-800 dark:text-white" id="${contentId}"></p>
                  <div id="${spinnerId}">
                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="currentColor">
                      <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"/>
                      <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z"/>
                    </svg>
                  </div>
                </div>
              </div>
              `;
              document.getElementById("chat-box").appendChild(botBubble);
            }
              
            // Update konten chat bubble bot secara incremental
            const contentElement = document.getElementById(contentId);
            const spinnerElement = document.getElementById(spinnerId);
            if (data.message) {
              finalMessage += data.message + " ";
              // Gunakan textNode untuk menghindari XSS dan reflow
              const textNode = document.createTextNode(data.message + " ");
              contentElement.appendChild(textNode);
      
              // Update scroll
              chatContainer.scrollTo({
                top: chatContainer.scrollHeight,
                behavior: 'smooth'
              });
      
              // Hapus spinner setelah 1 detik idle
              clearTimeout(spinnerTimeout);
              spinnerTimeout = setTimeout(() => {
                spinnerElement?.remove();
              }, 1000); // Hapus spinner 1 detik setelah pesan terakhir
            }
          };

          eventSource.onerror = function() {
            document.getElementById('bot-stream-spinner')?.remove();
            eventSource.close();
          };

          setTimeout(() => {
            document.getElementById('bot-stream-spinner')?.remove();
            eventSource.close();
          }, 30000);
        }
      }
    });

  </script>
</x-app-layout>
