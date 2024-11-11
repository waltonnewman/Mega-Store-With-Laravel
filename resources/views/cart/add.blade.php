<x-layout>

	<x-slot:heading>
		Add Items To cart
	</x-slot:heading>
 
<form method="POST" action="/cart">

	@csrf
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Create a New Job</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">We just need a handful of details.</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <x-form-field>
          <x-form-label for="title">Title</x-form-label>
          <div class="mt-2">

            <x-form-input name="title" id="title" placeholder="CEO" required />

            <x-form-error name="title"/>
          </div>
        </x-form-field>
          

        </div>

      </div>


    </div>

  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <x-form-button>Save</x-form-button>
  </div>
</form>


</x-layout>