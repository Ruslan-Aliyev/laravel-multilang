<x-app-layout>
	<div class="py-12">	
	    <x-slot name="header">
	        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
	            {{ __('see_table') }}
	        </h2>
	    </x-slot>

		@include('multilingual.en-pdf')

		<form method="POST" action="/en/multilingual" class="p-6 text-gray-900">
			@csrf
			<input type="submit" class="hover:underline hover:cursor-pointer" value="{{ __('print_pdf') }}">
		</form> 
	</div>
</x-app-layout>
