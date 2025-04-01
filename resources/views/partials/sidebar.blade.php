<!-- Sidebar -->
<div id="hs-application-sidebar" class="hs-overlay [--auto-close:lg]
hs-overlay-open:translate-x-0 -translate-x-full duration-300 transform
hidden
fixed top-0 start-0 bottom-0 z-[60]
w-64 h-full
bg-white border-e border-gray-200
lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
dark:bg-neutral-900 dark:border-neutral-700" role="dialog" tabindex="-1" aria-label="Sidebar">
  <nav class="size-full flex flex-col">
    <div class="flex items-center pt-4 pe-4 ps-7 space-x-3">
		<!-- Avatar -->
		<span class="shrink-0 inline-flex items-center justify-center size-[38px] rounded-full bg-gray-600">
			<span class="text-sm font-medium text-white leading-none">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
		</span>
		
		<!-- Nama Pengguna -->
		<div class="flex flex-col">
			<span class="font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</span>
			
		</div>

      <div class="block lg:ms-2">
        <!-- Templates Dropdown -->
        <div class="hs-dropdown  relative  [--auto-close:inside] inline-flex">
          <button id="hs-dropdown-preview-navbar" type="button" class="hs-dropdown-toggle  group relative flex justify-center items-center size-8 text-xs rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
          	<span class="">
        	    <svg class=" size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
        	  </span>

            <span class="absolute -top-0.5 -end-0.5">
              <span class="relative flex">
                <span class="animate-ping absolute inline-flex size-full rounded-full bg-red-400 dark:bg-red-600 opacity-75"></span>
                <span class="relative inline-flex size-2 bg-red-500 rounded-full"></span>
                <span class="sr-only">Notification</span>
              </span>
            </span>
          </button>

          <!-- Dropdown -->
          <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-full md:w-[450px] transition-[opacity,margin] duration opacity-0 hidden z-30 overflow-hidden border border-gray-200 bg-white rounded-xl shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)] dark:bg-neutral-800 dark:border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-preview-navbar">
          	<!-- Tab -->
          	<div class="p-3 pb-0 flex flex-wrap justify-between items-center gap-3 border-b border-gray-200 dark:border-neutral-700">
            	<!-- Nav Tab -->
            	<nav class="flex  gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            	  <button type="button" class="hs-tab-active:after:bg-gray-800 hs-tab-active:text-gray-800 px-2 py-1.5 mb-2 relative inline-flex justify-center items-center gap-x-2 text-nowrap  hover:bg-gray-100 text-gray-500 hover:text-gray-800 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 after:absolute after:-bottom-2 after:inset-x-2 after:z-10 after:h-0.5 after:pointer-events-none dark:hs-tab-active:text-neutral-200 dark:hs-tab-active:after:bg-neutral-400 dark:text-neutral-500 dark:hover:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  " id="hs-pmn-item-pro" aria-selected="false" data-hs-tab="#hs-pmn-pro" aria-controls="hs-pmn-pro" role="tab" >
            	    Pro
            	  </button>
            	  <button type="button" class="hs-tab-active:after:bg-gray-800 hs-tab-active:text-gray-800 px-2 py-1.5 mb-2 relative inline-flex justify-center items-center gap-x-2 text-nowrap  hover:bg-gray-100 text-gray-500 hover:text-gray-800 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 after:absolute after:-bottom-2 after:inset-x-2 after:z-10 after:h-0.5 after:pointer-events-none dark:hs-tab-active:text-neutral-200 dark:hs-tab-active:after:bg-neutral-400 dark:text-neutral-500 dark:hover:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 active " id="hs-pmn-item-free" aria-selected="true" data-hs-tab="#hs-pmn-free" aria-controls="hs-pmn-free" role="tab" >
            	    Free
            	  </button>
            	</nav>
            	<!-- End Nav Tab -->
            </div>
            <!-- End Tab -->

            <!-- Tab Content -->
            <div id="hs-pmn-pro" class="hidden" role="tabpanel" aria-labelledby="hs-pmn-item-pro">
        	    <!-- Header -->
        	  	<div class="p-3 flex flex-wrap justify-between items-center gap-3">
        	    	<span class="block font-semibold text-sm text-gray-800 dark:text-neutral-200">Templates (12)</span>

        	      <div class="ms-auto">
        	      	<a class="group py-2 px-2.5 rounded-md flex items-center gap-x-1 text-[13px] bg-gray-800 text-white hover:bg-gray-900 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-900 dark:bg-white dark:hover:bg-neutral-200 dark:focus:bg-neutral-200 dark:text-neutral-800" href="../pro/pricing.html">
        						Purchase
        						<svg class="hidden md:inline-block shrink-0 size-3.5 group-hover:translate-x-0.5 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:group-focus:opacity-100 lg:group-focus:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:group-focus:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	    </div>
        	    <!-- End Header -->

        	    <!-- Body -->
        	    <div class="p-3 max-h-[25rem] overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        	    	<!-- Grid -->
        	      <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
        	        <!-- Link -->
        	        <a class="p-3 relative flex flex-col justify-center items-center gap-y-3 rounded-xl hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  transition" href="../pro/dashboard/index.html">
        	          
        	          <p class="text-sm text-gray-800 dark:text-neutral-400">
        	            Dashboard
        	          </p>
        	        </a>
        	        <!-- End Link -->

        	        <!-- Link -->
        	        <a class="p-3 relative flex flex-col justify-center items-center gap-y-3 rounded-xl hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  transition" href="../pro/shop/index.html">
        	          
        	          <p class="text-sm text-gray-800 dark:text-neutral-400">
        	            Shop
        	          </p>
        	        </a>
        	        <!-- End Link -->

        	        <!-- Link -->
        	        <a class="p-3 relative flex flex-col justify-center items-center gap-y-3 rounded-xl hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  transition" href="../pro/chat/index.html">
        	          
        	          <p class="text-sm text-gray-800 dark:text-neutral-400">
        	            Chat
        	          </p>

        	          <div class="absolute -top-px end-[3px]'>
        	            <span class="py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full dark:bg-emerald-900 dark:text-emerald-500">+4</span>
        	          </div>
        	        </a>
        	        <!-- End Link -->

        	        
        	    	</div>
        	    	<!-- End Grid -->
        	  	</div>
        	  	<!-- Body -->

        	  	<!-- Footer -->
        	    <div class="p-3 flex flex-wrap justify-center items-center gap-0.5">
        	    	<div class="relative ps-2 ms-1 first:ps-0 first:ms-0 first:before:hidden before:hidden md:before:block before:absolute before:top-1/2 before:start-0 before:w-px before:h-4 before:bg-gray-200 before:-translate-y-1/2 dark:before:bg-neutral-700">
        	        <a class="group flex items-center gap-x-1.5 py-1.5 px-2 rounded-md text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" href="../pro/index.html">
        	          Main page
        	          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	      <div class="relative ps-2 ms-1 first:ps-0 first:ms-0 first:before:hidden before:hidden md:before:block before:absolute before:top-1/2 before:start-0 before:w-px before:h-4 before:bg-gray-200 before:-translate-y-1/2 dark:before:bg-neutral-700">
        	        <a class="group flex items-center gap-x-1.5 py-1.5 px-2 rounded-md text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" href="../pro/examples.html">
        	          Examples (600+<!-- (601) -->)
        	          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	      <div class="relative ps-2 ms-1 first:ps-0 first:ms-0 first:before:hidden before:hidden md:before:block before:absolute before:top-1/2 before:start-0 before:w-px before:h-4 before:bg-gray-200 before:-translate-y-1/2 dark:before:bg-neutral-700">
        	        <a class="group flex items-center gap-x-1.5 py-1.5 px-2 rounded-md text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" href="../pro/templates.html">
        	          Templates (12)
        	          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	    </div>
        	    <!-- End Footer -->
        	  </div>
        	  <!-- End Tab Content -->

        	  <!-- Tab Content -->
            <div id="hs-pmn-free" class="" role="tabpanel" aria-labelledby="hs-pmn-item-free">
            	<!-- Header -->
        	  	<div class="p-3 flex flex-wrap justify-between items-center gap-3">
        	    	<span class="block font-semibold text-sm text-gray-800 dark:text-neutral-200">Templates (5)</span>

        	      <div class="ms-auto">
        	      	<a class="group py-2 px-2.5 rounded-md flex items-center gap-x-1 text-[13px] bg-gray-800 text-white hover:bg-gray-900 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-900 dark:bg-white dark:hover:bg-neutral-200 dark:focus:bg-neutral-200 dark:text-neutral-800" href="../templates.html">
        						Free download
        						<svg class="hidden md:inline-block shrink-0 size-3.5 group-hover:translate-x-0.5 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:group-focus:opacity-100 lg:group-focus:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:group-focus:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	    </div>
        	    <!-- End Header -->

        	    <!-- Body -->
        	    <div class="p-3 max-h-[25rem] overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        	    	<!-- Grid -->
        	      <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
        	        <!-- Link -->
        	        <a class="p-3 relative flex flex-col justify-center items-center gap-y-3 rounded-xl hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  transition" href="../templates/agency/index.html">
        	          
        	          <p class="text-sm text-gray-800 dark:text-neutral-400">
        	            Agency
        	          </p>
        	        </a>
        	        <!-- End Link -->

        	        <!-- Link -->
        	        <a class="p-3 relative flex flex-col justify-center items-center gap-y-3 rounded-xl hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  transition" href="../templates/personal/index.html">
        	          
        	          <p class="text-sm text-gray-800 dark:text-neutral-400">
        	            Personal
        	          </p>
        	        </a>
        	        <!-- End Link -->

        	        <!-- Link -->
        	        <a class="p-3 relative flex flex-col justify-center items-center gap-y-3 rounded-xl hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700  transition" href="../templates/admin/index.html">
        	          
        	          <p class="text-sm text-gray-800 dark:text-neutral-400">
        	            Admin
        	          </p>
        	        </a>
        	        <!-- End Link -->

        	        
        	    	</div>
        	    	<!-- End Grid -->
        	  	</div>
        	  	<!-- Body -->

        	  	<!-- Footer -->
        	    <div class="p-3 flex flex-wrap justify-center items-center gap-0.5">
        	    	<div class="relative ps-2 ms-1 first:ps-0 first:ms-0 first:before:hidden before:hidden md:before:block before:absolute before:top-1/2 before:start-0 before:w-px before:h-4 before:bg-gray-200 before:-translate-y-1/2 dark:before:bg-neutral-700">
        	        <a class="group flex items-center gap-x-1.5 py-1.5 px-2 rounded-md text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" href="../index.html">
        	          Main page
        	          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	      <div class="relative ps-2 ms-1 first:ps-0 first:ms-0 first:before:hidden before:hidden md:before:block before:absolute before:top-1/2 before:start-0 before:w-px before:h-4 before:bg-gray-200 before:-translate-y-1/2 dark:before:bg-neutral-700">
        	        <a class="group flex items-center gap-x-1.5 py-1.5 px-2 rounded-md text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" href="../examples.html">
        	          Examples (200+<!-- 202 -->)
        	          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	      <div class="relative ps-2 ms-1 first:ps-0 first:ms-0 first:before:hidden before:hidden md:before:block before:absolute before:top-1/2 before:start-0 before:w-px before:h-4 before:bg-gray-200 before:-translate-y-1/2 dark:before:bg-neutral-700">
        	        <a class="group flex items-center gap-x-1.5 py-1.5 px-2 rounded-md text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" href="../templates.html">
        	          Templates (5)
        	          <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path class="lg:opacity-0 lg:-translate-x-1 lg:group-hover:opacity-100 lg:group-hover:translate-x-0 lg:transition" d="M5 12h14"/><path class="lg:-translate-x-1.5 lg:group-hover:translate-x-0 lg:transition" d="m12 5 7 7-7 7"/></svg>
        	        </a>
        	      </div>
        	    </div>
        	    <!-- End Footer -->
            </div>
        	  <!-- End Tab Content -->
          </div>
          <!-- End Dropdown -->
        </div>
        <!-- End Templates Dropdown -->
      </div>
    </div>

    <div class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
      <!-- List -->
      <ul class="space-y-1.5 p-4">
        <li>
          <a class="flex items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 dark:focus:text-neutral-300" href="#">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            New chat
          </a>
        </li>
        <li>
          <a class="flex items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 dark:focus:text-neutral-300" href="#">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.052.052 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1-.004.085 8.254 8.254 0 0 1-1.249.594.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.235 13.235 0 0 0 4.001-2.02.049.049 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612Z"/>
            </svg>
            Accountant AI
          </a>
        </li>
        <li>
          <a class="flex items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 dark:focus:text-neutral-300" href="#">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Save conversation
          </a>
        </li>
        <li>
          <a class="flex items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 dark:focus:text-neutral-300" href="#">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
            Updates & FAQ
          </a>
        </li>
        <li>
          <a class="flex items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-900 dark:hover:text-neutral-300 dark:focus:bg-neutral-900 dark:focus:text-neutral-300" href="#">
          <svg class="shrink-0 size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            <span class="bg-clip-text bg-gradient-to-tl from-blue-600 to-violet-600 text-transparent">Upgrade Plan</span>
          </a>
        </li>
      </ul>
      <!-- End List -->
    </div>

    <!-- Footer -->
    <div class="mt-auto">
      <div class="py-2.5 px-7">
        <!-- Dark Mode Toggle -->
		<button id="theme-toggle" type="button"
		class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-2">
			<svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
				xmlns="http://www.w3.org/2000/svg">
				<path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
			</svg>
			<svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
				xmlns="http://www.w3.org/2000/svg">
				<path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
			</svg>
		</button>
		
      </div>

      <div class="p-4 border-t border-gray-200 dark:border-neutral-700">
	  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="flex justify-between items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" x2="3" y1="12" y2="12"/>
        </svg>
		Log out
    </button>
</form>

      </div>
    </div>
    <!-- End Footer -->
  </nav>
</div>
<!-- End Sidebar -->