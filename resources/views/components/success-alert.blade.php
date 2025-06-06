<div
    {{ $attributes->merge(['class' => 'p-4 flex items-center text-sm text-green-600 border border-green-200 rounded-lg bg-green-50 dark:border-green-800 dark:bg-green-900/50 dark:text-green-400']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"/>
    </svg>
    {{ $slot }}
</div>
