<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }" class=" relative min-w-screen">

    @include('admin.body.sidebar')
    @include('admin.body.header')

    <main>
        <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
                <div class="col-span-12 space-y-6">
                    {{-- Metric grup --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 md:gap-6">
                        {{-- Metrix item --}}
                        <div
                                    class="cursor-pointer rounded-2xl shadow-lg bg-blue-400 p-5 dark:border-gray-800 dark:bg-gray-600 md:p-6 hover:shadow-xl transform transition duration-300 hover:scale-105 hover:-translate-y-1"
                                >
                                    <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-200 dark:bg-gray-800"
                                    >
                                    <svg
                                        class="fill-black dark:fill-white/90"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
                                        fill=""
                                        />
                                    </svg>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between">
                                    <div>
                                        <span class="text-md text-white dark:text-white">Customers</span>
                                        <h4
                                        class="mt-2 text-title-sm font-bold text-white dark:text-white/90"
                                        >
                                        {{ number_format($todayCustomer) }}
                                        </h4>
                                    </div>

                                    <span
                                        class="flex items-center gap-1 rounded-full {{ $customerChange >= 0 ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500' : 'bg-white text-red-600 dark:bg-red-500/15 dark:text-red-500' }} 
    py-0.5 pl-2 pr-2.5 text-sm font-medium"
                                    >
                                        <svg
                                        class="fill-current"
                                        width="12"
                                        height="12"
                                        viewBox="0 0 12 12"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="{{ $customerChange >= 0 
                  ? 'M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z' : 'M5.31462 10.3761C5.45194 10.5293 5.65136 10.6257 5.87329 10.6257C5.8736 10.6257 5.8739 10.6257 5.87421 10.6257C6.0663 10.6259 6.25845 10.5527 6.40505 10.4062L9.40514 7.4082C9.69814 7.11541 9.69831 6.64054 9.40552 6.34754C9.11273 6.05454 8.63785 6.05438 8.34486 6.34717L6.62329 8.06753L6.62329 1.875C6.62329 1.46079 6.28751 1.125 5.87329 1.125C5.45908 1.125 5.12329 1.46079 5.12329 1.875L5.12329 8.06422L3.40516 6.34719C3.11218 6.05439 2.6373 6.05454 2.3445 6.34752C2.0517 6.64051 2.05185 7.11538 2.34484 7.40818L5.31462 10.3761Z'}}"
                                            fill=""
                                        />
                                        </svg>

                                        {{ round($customerChange, 2) }}%
                                    </span>
                                    </div>
                                </div>

                        {{-- End metrix item --}}
                        <!-- Metric Item Start -->
                                <div
                                    class="cursor-pointer rounded-2xl shadow-lg bg-blue-300 p-5 dark:border-gray-800 dark:bg-gray-400 md:p-6 hover:shadow-xl transform transition duration-300 hover:scale-105 hover:-translate-y-1"
                                >
                                    <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-gray-800"
                                    >
                                    <svg
                                        class="fill-black dark:fill-white/90"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.9469 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z"
                                        fill=""
                                        />
                                    </svg>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between">
                                    <div>
                                        <span class="text-sm text-white">Orders</span>
                                        <h4
                                        class="mt-2 text-title-sm font-bold text-white dark:text-white"
                                        >
                                        {{ number_format($todayMenu) }}
                                        </h4>
                                    </div>

                                    <span
                                        class="flex items-center gap-1 rounded-full {{ $menuChange >= 0 ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500' : 'bg-white text-red-600 dark:bg-red-500/15 dark:text-red-500' }} 
    py-0.5 pl-2 pr-2.5 text-sm font-medium"
                                    >
                                        <svg
                                        class="fill-current"
                                        width="12"
                                        height="12"
                                        viewBox="0 0 12 12"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="{{ $menuChange >= 0 
                  ? 'M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z' : 'M5.31462 10.3761C5.45194 10.5293 5.65136 10.6257 5.87329 10.6257C5.8736 10.6257 5.8739 10.6257 5.87421 10.6257C6.0663 10.6259 6.25845 10.5527 6.40505 10.4062L9.40514 7.4082C9.69814 7.11541 9.69831 6.64054 9.40552 6.34754C9.11273 6.05454 8.63785 6.05438 8.34486 6.34717L6.62329 8.06753L6.62329 1.875C6.62329 1.46079 6.28751 1.125 5.87329 1.125C5.45908 1.125 5.12329 1.46079 5.12329 1.875L5.12329 8.06422L3.40516 6.34719C3.11218 6.05439 2.6373 6.05454 2.3445 6.34752C2.0517 6.64051 2.05185 7.11538 2.34484 7.40818L5.31462 10.3761Z'}}"
                                            fill=""
                                        />
                                        </svg>

                                        {{ round($menuChange, 2) }}%
                                    </span>
                                    </div>
                                </div>
                                <!-- Metric Item End -->
                            <!-- Metric Item Start -->
                                <div
                                    class="cursor-pointer rounded-2xl shadow-lg bg-gradient-to-r from-blue-700 to-blue-500 p-5 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-900 hover:shadow-xl transform transition duration-300 hover:scale-105 hover:-translate-y-1"
                                >
                                    <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-gray-800"
                                    >
                                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="-5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><path d="M8.699 11.907a3.005 3.005 0 0 1-1.503 2.578 4.903 4.903 0 0 1-1.651.663V16.3a1.03 1.03 0 1 1-2.059 0v-1.141l-.063-.011a5.199 5.199 0 0 1-1.064-.325 3.414 3.414 0 0 1-1.311-.962 1.029 1.029 0 1 1 1.556-1.347 1.39 1.39 0 0 0 .52.397l.002.001a3.367 3.367 0 0 0 .648.208h.002a4.964 4.964 0 0 0 .695.084 3.132 3.132 0 0 0 1.605-.445c.5-.325.564-.625.564-.851a1.005 1.005 0 0 0-.245-.65 2.06 2.06 0 0 0-.55-.44 2.705 2.705 0 0 0-.664-.24 3.107 3.107 0 0 0-.65-.066 6.046 6.046 0 0 1-1.008-.08 4.578 4.578 0 0 1-1.287-.415A3.708 3.708 0 0 1 1.02 9.04a3.115 3.115 0 0 1-.718-1.954 2.965 2.965 0 0 1 .321-1.333 3.407 3.407 0 0 1 1.253-1.335 4.872 4.872 0 0 1 1.611-.631V2.674a1.03 1.03 0 1 1 2.059 0v1.144l.063.014h.002a5.464 5.464 0 0 1 1.075.368 3.963 3.963 0 0 1 1.157.795A1.03 1.03 0 0 1 6.39 6.453a1.901 1.901 0 0 0-.549-.376 3.516 3.516 0 0 0-.669-.234l-.066-.014a3.183 3.183 0 0 0-.558-.093 3.062 3.062 0 0 0-1.572.422 1.102 1.102 0 0 0-.615.928 1.086 1.086 0 0 0 .256.654l.002.003a1.679 1.679 0 0 0 .537.43l.002.002a2.57 2.57 0 0 0 .703.225h.002a4.012 4.012 0 0 0 .668.053 5.165 5.165 0 0 1 1.087.112l.003.001a4.804 4.804 0 0 1 1.182.428l.004.002a4.115 4.115 0 0 1 1.138.906l.002.002a3.05 3.05 0 0 1 .753 2.003z"/></svg>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between">
                                    <div>
                                        <span class="text-sm text-white">Income</span>
                                        <h4
                                        class="mt-2 text-title-sm font-bold text-white dark:text-white"
                                        >
                                        {{ number_format($todayIncome) }}
                                        </h4>
                                    </div>

                                    <span
                                        class="flex items-center gap-1 rounded-full {{ $incomeChange >= 0 ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-500' : 'bg-white text-red-600 dark:bg-red-500/15 dark:text-red-500' }} 
    py-0.5 pl-2 pr-2.5 text-sm font-medium"
                                    >
                                        <svg
                                        class="fill-current"
                                        width="12"
                                        height="12"
                                        viewBox="0 0 12 12"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="{{ $incomeChange >= 0 
                  ? 'M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.1236 1.37432 6.12391 1.37432 6.12422 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z' : 'M5.31462 10.3761C5.45194 10.5293 5.65136 10.6257 5.87329 10.6257C5.8736 10.6257 5.8739 10.6257 5.87421 10.6257C6.0663 10.6259 6.25845 10.5527 6.40505 10.4062L9.40514 7.4082C9.69814 7.11541 9.69831 6.64054 9.40552 6.34754C9.11273 6.05454 8.63785 6.05438 8.34486 6.34717L6.62329 8.06753L6.62329 1.875C6.62329 1.46079 6.28751 1.125 5.87329 1.125C5.45908 1.125 5.12329 1.46079 5.12329 1.875L5.12329 8.06422L3.40516 6.34719C3.11218 6.05439 2.6373 6.05454 2.3445 6.34752C2.0517 6.64051 2.05185 7.11538 2.34484 7.40818L5.31462 10.3761Z'}}"
                                            fill=""
                                        />
                                        </svg>

                                        {{ round($incomeChange, 2) }}%
                                    </span>
                                    </div>
                                </div>
                                <!-- Metric Item End -->
                    </div>
                    {{-- metric grup end --}}

                    {{-- charts  --}}
                            <div class="grid grid-cols-2 gap-4">
                                {{-- Chart 1 --}}
                                <div
                                class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6" 

                                >
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                    Monthly Sales
                                    </h3>

                                    
                                </div>

                                <div class="max-w-full overflow-x-auto custom-scrollbar">
                                    <div class="-ml-5 min-w-[650px] pl-2 xl:min-w-full">
                                    <div
                                        id="chartOne"
                                        class="-ml-5 h-full min-w-[650px] pl-2 xl:min-w-full"
                                    ></div>
                                    </div>
                                </div>
                            </div>

                                {{-- Chart 1 end  --}}
                                {{-- chart 2 --}}

                                <div
                                    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6"
                                    >
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                        Monthly Customers
                                        </h3>
                                    </div>

                                    <div class="max-w-full overflow-x-auto custom-scrollbar">
                                        <div class="-ml-5 min-w-[650px] pl-2 xl:min-w-full">
                                        <div id="chartCustomer" class="h-full min-w-[650px]"></div>
                                        </div>
                                    </div>
                                </div>


                                {{-- chart 2 end  --}}
                            </div>
                            {{-- end charts --}}
                </div>
            </div>
        </div>
    </main>

</body>

</html>

<script>
    const incomeChartData = @json($incomeData ?? []);
    const customerChartData = @json($customerData ?? []);
</script>
<script type="module">
    import chart01 from '/js/chart/chart-one.js';
    document.addEventListener('DOMContentLoaded', function () {
        chart01();
    });
</script>

