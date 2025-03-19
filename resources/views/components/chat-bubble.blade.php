{{-- components/chat-bubble.blade.php --}}
@props([
    'sender', // 'user' atau 'bot'
    'contentType', // 'text', 'code', 'media', 'table', 'voice'
    'avatar',
    // 'align', // 'left' atau 'right'
])

<li class="max-w-4xl py-2 px-4 sm:px-6 lg:px-8 mx-auto flex gap-x-2 sm:gap-x-4 {{ $sender === 'user' ? 'flex-row-reverse' : 'justify-start' }}">
    @if($sender === 'user')
        <span class="shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-gray-600">
            <span class="text-sm font-medium text-white leading-none">{{ $avatar }}</span>
        </span>
    @else
        <svg class="shrink-0 size-[38px] rounded-full" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            {{-- Bot SVG avatar --}}
            <rect width="38" height="38" rx="6" fill="#2563EB"/>
            <path d="M10 28V18.64C10 13.8683 14.0294 10 19 10C23.9706 10 28 13.8683 28 18.64C28 23.4117 23.9706 27.28 19 27.28H18.25" stroke="white" stroke-width="1.5"/>
            <path d="M13 28V18.7552C13 15.5104 15.6863 12.88 19 12.88C22.3137 12.88 25 15.5104 25 18.7552C25 22 22.3137 24.6304 19 24.6304H18.25" stroke="white" stroke-width="1.5"/>
            <ellipse cx="19" cy="18.6554" rx="3.75" ry="3.6" fill="white"/>
        </svg>
    @endif

    <div class="grow max-w-[90%] md:max-w-2xl w-full space-y-3 {{ $sender === 'user' ? 'text-right bg-gray-100 rounded-md py-2 px-2' : '' }}">
        <div class="space-y-3">
            @if($contentType === 'text')
                <p class="text-sm text-gray-800 dark:text-white">
                    {{ $slot }}
                </p>

            @elseif($contentType === 'file')
                <div class="mt-2 space-y-3">
                    {{-- Header --}}
                    <p class="text-sm text-gray-800 dark:text-neutral-200">
                        {{ $slot }}
                    </p>

                    {{-- File list container --}}
                    <ul class="flex flex-col justify-end text-start -space-y-px">
                        <li class="flex items-center gap-x-2 p-3 text-sm bg-white border text-gray-800 first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
                            <div class="w-full flex justify-between truncate">
                                <span class="me-3 flex-1 w-0 truncate">
                                resume_web_ui_developer.csv
                                </span>
                                <button type="button" class="flex items-center gap-x-2 text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 whitespace-nowrap dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                Download
                                </button>
                            </div>
                        </li>
                        {{ $files ?? '' }}
                    </ul>
                </div>
            
            @elseif($contentType === 'code')
                <div class="mt-3 flex-none min-w-full bg-gray-800 font-mono text-sm p-5 rounded-lg dark:bg-neutral-800">
                    {{ $slot }}
                </div>
            
            @elseif($contentType === 'media')
                <div class="grid grid-cols-2 gap-1 rounded-lg overflow-hidden">
                    {{ $slot }}
                </div>
            
            @elseif($contentType === 'table')
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                    {{ $slot }}
                </div>
            
            @elseif($contentType === 'voice')
                <div class="">
                    <button type="button" class="p-2 inline-flex justify-center items-center gap-x-1 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 text-xs dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-white">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        {{ $slot }}
                    </button>
                </div>
            @endif
        </div>

        {{-- Action Buttons --}}
        @if($sender === 'bot')
        <div>
        <div class="sm:flex sm:justify-between">
              <div>
                <div class="inline-flex border border-gray-200 rounded-full p-0.5 dark:border-neutral-700">
                  <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:bg-blue-100 focus:text-blue-800 dark:text-neutral-500 dark:hover:bg-blue-900 dark:hover:text-blue-200 dark:focus:bg-blue-900 dark:focus:text-blue-200">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z"/></svg>
                  </button>
                  <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-full text-gray-500 hover:bg-blue-100 hover:text-blue-800 focus:z-10 focus:outline-none focus:bg-blue-100 focus:text-blue-800 dark:text-neutral-500 dark:hover:bg-blue-900 dark:hover:text-blue-200 dark:focus:bg-blue-900 dark:focus:text-blue-200">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"/></svg>
                  </button>
                </div>
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm rounded-full border border-transparent text-gray-500 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 14V2"/><path d="M9 18.12 10 14H4.17a2 2 0 0 1-1.92-2.56l2.33-8A2 2 0 0 1 6.5 2H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.76a2 2 0 0 0-1.79 1.11L12 22h0a3.13 3.13 0 0 1-3-3.88Z"/></svg>
                  Copy
                </button>
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm rounded-full border border-transparent text-gray-500 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                  Share
                </button>
              </div>

              <div class="mt-1 sm:mt-0">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm rounded-full border border-transparent text-gray-500 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/></svg>
                  New answer
                </button>
              </div>
            </div>
        </div>
        @endif
    </div>
</li>