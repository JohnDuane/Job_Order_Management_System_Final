@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-500 bg-white-900 dark:text-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm']) }}>
