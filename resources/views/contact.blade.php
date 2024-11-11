<x-layout>
	<x-slot:heading>
		Contact Page
	</x-slot:heading>


	<div class="container mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 ">
                {{ session('success') }}
            </div>
        @endif

   <form action="{{ route('contact.store') }}" method="POST" class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md">
   	@csrf
    <h2 class="text-2xl font-bold mb-4">Contact Us</h2>

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" id="name" name="name" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary" />
    </div>

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary" />
    </div>

    <div class="mb-4">
        <label for="referal" class="block text-sm font-medium text-gray-700">Referal</label>
        <input type="text" id="referal" name="referal" value="admin@gmail.com" required readonly class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary opacity-50 cursor-not-allowed" />
    </div>

    <div class="mb-4">
        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
        <textarea id="message" name="message" rows="4" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary"></textarea>
    </div>


    <div class="mb-4">
        <label for="attarchment" class="block text-sm font-medium text-gray-700">Add Attarchment</label>
        <input type="file" id="file" name="file" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary" />
    </div>


    <button type="submit" class="w-full bg-primary text-white p-2 rounded-md hover:bg-red-600">Send</button>
</form>

</div>

</x-layout>